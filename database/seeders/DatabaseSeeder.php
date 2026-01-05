<?php

namespace Database\Seeders;

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
        // Create admin user
        $this->call(AdminUserSeeder::class);
        
        // Create test student user (or get existing)
        $student = \App\Models\User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password123'),
                'role' => 'Student',
            ]
        );
        
        // Create test instructor user (or get existing)
        $instructor = \App\Models\User::firstOrCreate(
            ['email' => 'instructor@example.com'],
            [
                'name' => 'Test Instructor',
                'password' => Hash::make('password123'),
                'role' => 'Instructor',
            ]
        );
        
        // Create test courses
        $courses = [
            [
                'title' => 'PHP Fundamentals',
                'description' => 'A comprehensive guide to PHP programming',
                'short_description' => 'Learn PHP basics',
                'long_description' => 'A comprehensive guide to PHP programming',
                'category' => 'Programming',
                'difficulty' => 'Beginner',
                'estimated_duration' => 120,
                'is_published' => true,
                'created_by' => $instructor->id,
            ],
            [
                'title' => 'Vue.js Mastery',
                'description' => 'Learn Vue.js from scratch to advanced',
                'short_description' => 'Master Vue.js framework',
                'long_description' => 'Learn Vue.js from scratch to advanced',
                'category' => 'Programming',
                'difficulty' => 'Intermediate',
                'estimated_duration' => 150,
                'is_published' => true,
                'created_by' => $instructor->id,
            ],
        ];
        
        foreach ($courses as $courseData) {
            $course = \App\Models\Course::firstOrCreate(
                ['title' => $courseData['title']],
                $courseData
            );
            
            // Create 2 lessons per course
            for ($i = 1; $i <= 2; $i++) {
                \App\Models\Lesson::firstOrCreate(
                    ['course_id' => $course->id, 'title' => "{$course->title} - Lesson {$i}"],
                    [
                        'content' => "Lesson {$i} content for {$course->title}",
                        'lesson_type' => $i % 2 == 0 ? 'Video' : 'Article',
                        'estimated_duration' => 30 + ($i * 10),
                        'order_position' => $i,
                    ]
                );
            }
            
            // Enroll student in course (if not already enrolled)
            \App\Models\Enrollment::firstOrCreate(
                ['user_id' => $student->id, 'course_id' => $course->id],
                ['progress_percentage' => 0]
            );
        }
    }
}
