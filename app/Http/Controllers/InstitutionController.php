<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Institution;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class InstitutionController extends Controller
{
    /**
     * Get institution dashboard data
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        $institution = $user->institution;
        $learners = $user->learners()->with('wallet')->get();
        
        $totalLearners = $learners->count();
        $activeLearners = $learners->where('is_active', true)->count();
        $totalTokens = $learners->sum('wallet.balance');
        $averageTokens = $totalLearners > 0 ? round($totalTokens / $totalLearners) : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'institution' => $institution,
                'stats' => [
                    'total_learners' => $totalLearners,
                    'active_learners' => $activeLearners,
                    'total_tokens' => $totalTokens,
                    'average_tokens' => $averageTokens,
                ],
                'recent_learners' => $learners->take(5)->map(function ($learner) {
                    return [
                        'id' => $learner->id,
                        'name' => $learner->name,
                        'email' => $learner->email,
                        'grade_level' => $learner->grade_level,
                        'tokens' => $learner->wallet ? $learner->wallet->balance : 0,
                        'created_at' => $learner->created_at,
                    ];
                })
            ]
        ]);
    }

    /**
     * Get all learners for the institution
     */
    public function getLearners(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        $learners = $user->learners()
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($learner) {
                return [
                    'id' => $learner->id,
                    'name' => $learner->name,
                    'email' => $learner->email,
                    'grade_level' => $learner->grade_level,
                    'tokens' => $learner->wallet ? $learner->wallet->balance : 0,
                    'is_active' => $learner->is_active ?? true,
                    'created_at' => $learner->created_at,
                    'updated_at' => $learner->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $learners
        ]);
    }

    /**
     * Add a new learner
     */
    public function addLearner(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'grade_level' => 'required|string|max:255',
            'initial_tokens' => 'integer|min:0|max:1000',
            'phone_number' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the learner
            $learner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'), // Default password
                'grade_level' => $request->grade_level,
                'user_type' => 'student',
                'institution_id' => $user->institution_id,
                'phone_number' => $request->phone_number,
            ]);

            // Create wallet with initial tokens
            $initialTokens = $request->initial_tokens ?? 0;
            Wallet::create([
                'user_id' => $learner->id,
                'balance' => $initialTokens,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Learner added successfully',
                'data' => [
                    'id' => $learner->id,
                    'name' => $learner->name,
                    'email' => $learner->email,
                    'grade_level' => $learner->grade_level,
                    'tokens' => $initialTokens,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add learner',
                'error' => 'An error occurred while adding the learner. Please try again.'
            ], 500);
        }
    }

    /**
     * Update learner tokens
     */
    public function updateLearnerTokens(Request $request, $learnerId): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'tokens' => 'required|integer|min:0|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $learner = User::where('id', $learnerId)
                ->where('institution_id', $user->institution_id)
                ->where('user_type', 'student')
                ->first();

            if (!$learner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Learner not found'
                ], 404);
            }

            $wallet = $learner->wallet;
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id' => $learner->id,
                    'balance' => 0,
                ]);
            }

            $wallet->update(['balance' => $request->tokens]);

            return response()->json([
                'success' => true,
                'message' => 'Learner tokens updated successfully',
                'data' => [
                    'id' => $learner->id,
                    'name' => $learner->name,
                    'tokens' => $wallet->balance,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update learner tokens',
                'error' => 'An error occurred while updating tokens. Please try again.'
            ], 500);
        }
    }

    /**
     * Toggle learner active status
     */
    public function toggleLearnerStatus(Request $request, $learnerId): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        try {
            $learner = User::where('id', $learnerId)
                ->where('institution_id', $user->institution_id)
                ->where('user_type', 'student')
                ->first();

            if (!$learner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Learner not found'
                ], 404);
            }

            $learner->is_active = !($learner->is_active ?? true);
            $learner->save();

            return response()->json([
                'success' => true,
                'message' => 'Learner status updated successfully',
                'data' => [
                    'id' => $learner->id,
                    'name' => $learner->name,
                    'is_active' => $learner->is_active,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update learner status',
                'error' => 'An error occurred while updating status. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk upload learners
     */
    public function bulkUploadLearners(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user->user_type !== 'institution') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Institution admin required.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'learners' => 'required|array|min:1|max:100',
            'learners.*.name' => 'required|string|max:255',
            'learners.*.email' => 'required|string|email|max:255',
            'learners.*.grade_level' => 'required|string|max:255',
            'learners.*.initial_tokens' => 'integer|min:0|max:1000',
            'learners.*.phone_number' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $createdLearners = [];
            $errors = [];

            foreach ($request->learners as $index => $learnerData) {
                try {
                    // Check if email already exists
                    if (User::where('email', $learnerData['email'])->exists()) {
                        $errors[] = "Row " . ($index + 1) . ": Email already exists";
                        continue;
                    }

                    // Create the learner
                    $learner = User::create([
                        'name' => $learnerData['name'],
                        'email' => $learnerData['email'],
                        'password' => Hash::make('password123'),
                        'grade_level' => $learnerData['grade_level'],
                        'user_type' => 'student',
                        'institution_id' => $user->institution_id,
                        'phone_number' => $learnerData['phone_number'],
                    ]);

                    // Create wallet
                    $initialTokens = $learnerData['initial_tokens'] ?? 0;
                    Wallet::create([
                        'user_id' => $learner->id,
                        'balance' => $initialTokens,
                    ]);

                    $createdLearners[] = [
                        'id' => $learner->id,
                        'name' => $learner->name,
                        'email' => $learner->email,
                        'grade_level' => $learner->grade_level,
                        'tokens' => $initialTokens,
                    ];

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk upload completed',
                'data' => [
                    'created_count' => count($createdLearners),
                    'error_count' => count($errors),
                    'created_learners' => $createdLearners,
                    'errors' => $errors,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process bulk upload',
                'error' => 'An error occurred during bulk upload. Please try again.'
            ], 500);
        }
    }
}

