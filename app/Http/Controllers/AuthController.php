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
     * Standardize phone number to 2547... format
     */
    private function standardizePhoneNumber($phone)
    {
        if (!$phone) return $phone;
        
        // Remove all non-digit characters
        $cleanPhone = preg_replace('/\D/', '', $phone);
        
        // Handle different formats
        if (str_starts_with($cleanPhone, '254')) {
            // Already in 254 format
            return $cleanPhone;
        } elseif (str_starts_with($cleanPhone, '07') && strlen($cleanPhone) === 10) {
            // 07... format (10 digits)
            return '254' . substr($cleanPhone, 1);
        } elseif (str_starts_with($cleanPhone, '7') && strlen($cleanPhone) === 9) {
            // 7... format (9 digits)
            return '254' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 9 && !str_starts_with($cleanPhone, '0')) {
            // 9 digits starting with 7
            return '254' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 10 && str_starts_with($cleanPhone, '0')) {
            // 10 digits starting with 0
            return '254' . substr($cleanPhone, 1);
        }
        
        // Return as is if no pattern matches
        return $cleanPhone;
    }

    /**
     * Register a new individual user
     */
    public function register(Request $request): JsonResponse
    {
        // Standardize phone number before validation
        $standardizedPhone = $this->standardizePhoneNumber($request->phone_number);
        $request->merge(['phone_number' => $standardizedPhone]);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|regex:/^254[0-9]{9}$/',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'user_type' => 'required|string|in:student,parent',
            'grade_level' => 'nullable|string|max:255',
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
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => $request->user_type,
                'institution_id' => null, // Individual users are not associated with any institution
                'grade_level' => $request->grade_level,
            ]);

            // Generate a simple token (in a real app, you'd use Laravel Sanctum or Passport)
            $token = base64_encode($user->id . '|' . time());

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->user_type) . ' registered successfully',
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
        // Standardize login identifier if it's a phone number
        $loginIdentifier = $request->login_identifier;
        if (preg_match('/^[0-9]+$/', $loginIdentifier)) {
            $standardizedPhone = $this->standardizePhoneNumber($loginIdentifier);
            $request->merge(['login_identifier' => $standardizedPhone]);
        }

        $validator = Validator::make($request->all(), [
            'login_identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('login_identifier', 'password');

        // Try to find user by phone_number first, then by admission_number (if it exists)
        $user = User::where('phone_number', $credentials['login_identifier'])->first();
        
        // If not found by phone, try by admission_number (for institution students)
        if (!$user) {
            $user = User::where('admission_number', $credentials['login_identifier'])->first();
        }

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
        // Standardize phone number before validation
        $standardizedPhone = $this->standardizePhoneNumber($request->institution_phone);
        $request->merge(['institution_phone' => $standardizedPhone]);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'institution_name' => 'required|string|max:255',
            'institution_email' => 'required|string|email|max:255',
            'institution_phone' => 'required|string|regex:/^254[0-9]{9}$/',
            'institution_address' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_phone_number' => 'required|string|regex:/^254[0-9]{9}$/',
            'admin_email' => 'required|string|email|max:255|unique:users',
            'admin_password' => 'required|string|min:8|confirmed',
            'admin_password_confirmation' => 'required|string|min:8',
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
                'name' => $request->institution_name,
                'email' => $request->institution_email,
                'phone' => $request->institution_phone,
                'address' => $request->institution_address,
                'motto' => null,
                'theme_color' => '#3b82f6',
            ]);

            // Create the institution admin user
            $user = User::create([
                'name' => $request->admin_name,
                'phone_number' => $request->admin_phone_number,
                'email' => $request->admin_email,
                'password' => bcrypt($request->admin_password),
                'user_type' => 'institution',
                'institution_id' => $institution->id,
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
