<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Institution;

class AuthController extends Controller
{
    /**
     * Register a new individual user
     */
    public function register(Request $request): JsonResponse
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'grade_level' => 'required|string|max:255',
            'mpesa_phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'grade_level' => $request->grade_level,
                'user_type' => 'student',
                'mpesa_phone' => $request->mpesa_phone,
            ]);

            // Generate a simple token (in a real app, you'd use Laravel Sanctum or Passport)
            $token = base64_encode($user->id . '|' . time());

            return response()->json([
                'success' => true,
                'message' => 'Student registered successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'institution_id' => $user->institution_id,
                        'grade_level' => $user->grade_level,
                        'user_type' => $user->user_type,
                        'updated_at' => $user->updated_at,
                        'created_at' => $user->created_at,
                        'wallet' => [
                            'id' => 1, // This would come from wallet creation
                            'user_id' => $user->id,
                            'balance' => 0,
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ],
                        'institution' => null
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'dashboard' => [
                        'token_balance' => 0,
                        'assessment_stats' => [
                            'total_attempts' => 0,
                            'completed_attempts' => 0,
                            'in_progress_attempts' => 0,
                            'average_score' => 0,
                            'total_tokens_used' => 0,
                            'completion_rate' => 0
                        ],
                        'recent_assessments' => [],
                        'recent_attempts' => []
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => 'An error occurred during registration. Please try again.'
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        // For now, we'll do a simple check (in a real app, use Laravel's Auth)
        $user = User::where('email', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            $token = base64_encode($user->id . '|' . time());

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'institution_id' => $user->institution_id,
                        'grade_level' => $user->grade_level,
                        'user_type' => $user->user_type,
                        'updated_at' => $user->updated_at,
                        'created_at' => $user->created_at,
                        'wallet' => [
                            'id' => 1, // This would come from actual wallet data
                            'user_id' => $user->id,
                            'balance' => 25, // Example balance
                            'created_at' => $user->created_at,
                            'updated_at' => $user->updated_at,
                        ],
                        'institution' => null
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'dashboard' => [
                        'token_balance' => 25,
                        'assessment_stats' => [
                            'total_attempts' => 10,
                            'completed_attempts' => 8,
                            'in_progress_attempts' => 2,
                            'average_score' => 87,
                            'total_tokens_used' => 15,
                            'completion_rate' => 80
                        ],
                        'recent_assessments' => [
                            [
                                'id' => 1,
                                'name' => 'JavaScript Fundamentals',
                                'status' => 'completed',
                                'score' => 92,
                                'completed_at' => '2025-09-02T10:30:00.000000Z'
                            ],
                            [
                                'id' => 2,
                                'name' => 'Python Data Analysis',
                                'status' => 'in_progress',
                                'score' => 65,
                                'completed_at' => null
                            ],
                            [
                                'id' => 3,
                                'name' => 'UI/UX Design',
                                'status' => 'completed',
                                'score' => 88,
                                'completed_at' => '2025-08-28T14:15:00.000000Z'
                            ]
                        ],
                        'recent_attempts' => []
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
            'error' => 'The provided email or password is incorrect.'
        ], 401);
    }

    /**
     * Register a new institution
     */
    public function registerInstitution(Request $request): JsonResponse
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'motto' => 'nullable|string|max:255',
            'theme_color' => 'nullable|string|max:7',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'mpesa_phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the institution
            $institution = Institution::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'motto' => $request->motto,
                'theme_color' => $request->theme_color ?? '#3b82f6',
            ]);

            // Create the institution admin user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => 'institution',
                'institution_id' => $institution->id,
                'mpesa_phone' => $request->mpesa_phone,
            ]);

            // Generate a simple token
            $token = base64_encode($user->id . '|' . time());

            return response()->json([
                'success' => true,
                'message' => 'Institution registered successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'institution_id' => $user->institution_id,
                        'user_type' => $user->user_type,
                        'updated_at' => $user->updated_at,
                        'created_at' => $user->created_at,
                        'institution' => $institution
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'dashboard' => [
                        'token_balance' => 0,
                        'assessment_stats' => [
                            'total_attempts' => 0,
                            'completed_attempts' => 0,
                            'in_progress_attempts' => 0,
                            'average_score' => 0,
                            'total_tokens_used' => 0,
                            'completion_rate' => 0
                        ],
                        'recent_assessments' => [],
                        'recent_attempts' => []
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => 'An error occurred during registration. Please try again.'
            ], 500);
        }
    }
}
