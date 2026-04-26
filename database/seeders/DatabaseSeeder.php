<?php

namespace Database\Seeders;

use App\Models\AssessmentResult;
use App\Models\Classroom;
use App\Models\Institution;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo data requested by QA (P0)
        // - 1 teacher account
        // - 1 class (Grade 5)
        // - 3–5 learners
        // - For 1 learner: 3 assessments 40%, 60%, 75%

        $institution = Institution::firstOrCreate(
            ['email' => 'demo.school@gravitycbc.local'],
            [
                'name' => 'Gravity Pilot School',
                'phone' => '254700000000',
                'address' => 'Nairobi, Kenya',
                'motto' => 'Assess. Learn. Grow.',
                'theme_color' => '#3b82f6',
            ]
        );

        // Teacher account (using existing user_type convention)
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@gravitycbc.local'],
            [
                'name' => 'Demo Teacher',
                'phone_number' => '254700000001',
                'password' => Hash::make('password123'),
                'user_type' => 'institution',
                'institution_id' => $institution->id,
                'grade_level' => null,
            ]
        );

        $classroom = Classroom::firstOrCreate(
            [
                'institution_id' => $institution->id,
                'name' => 'Grade 5',
            ],
            [
                'teacher_user_id' => $teacher->id,
                'grade_level' => 'Grade 5',
            ]
        );

        // Ensure classroom teacher is correct (in case it existed)
        if ($classroom->teacher_user_id !== $teacher->id) {
            $classroom->update(['teacher_user_id' => $teacher->id]);
        }

        $learners = [];
        foreach (range(1, 4) as $i) {
            $learner = User::firstOrCreate(
                ['email' => "learner{$i}@gravitycbc.local"],
                [
                    'name' => "Demo Learner {$i}",
                    'phone_number' => '25470000001' . $i,
                    'password' => Hash::make('password123'),
                    'user_type' => 'student',
                    'institution_id' => $institution->id,
                    'grade_level' => 'Grade 5',
                ]
            );

            Wallet::firstOrCreate(
                ['user_id' => $learner->id],
                ['balance' => 0]
            );

            $learners[] = $learner;
        }

        $classroom->learners()->syncWithoutDetaching(collect($learners)->pluck('id')->all());

        // Seed 3 assessment results for learner 1: 40%, 60%, 75%
        $targetLearner = $learners[0];

        $results = [
            ['score_percent' => 40, 'subject' => 'Literacy', 'assessment_title' => 'Grade 5 Literacy Assessment'],
            ['score_percent' => 60, 'subject' => 'Literacy', 'assessment_title' => 'Grade 5 Literacy Assessment'],
            ['score_percent' => 75, 'subject' => 'Literacy', 'assessment_title' => 'Grade 5 Literacy Assessment'],
        ];

        foreach ($results as $idx => $r) {
            AssessmentResult::firstOrCreate(
                [
                    'learner_user_id' => $targetLearner->id,
                    'assessment_title' => $r['assessment_title'],
                    'score_percent' => $r['score_percent'],
                ],
                [
                    'classroom_id' => $classroom->id,
                    'subject' => $r['subject'],
                    'assessed_at' => now()->subDays(7 - ($idx * 3)),
                ]
            );
        }
    }
}
