<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Console\Command;

class RecalculateProgressCommand extends Command
{
    protected $signature = 'progress:recalculate';
    protected $description = 'Recalculate course progress for all students';

    public function handle()
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            $totalLessons = Lesson::where('course_id', $enrollment->course_id)->count();
            $completedLessons = LessonCompletion::whereIn('lesson_id', function($query) use ($enrollment) {
                $query->select('id')
                    ->from('lessons')
                    ->where('course_id', $enrollment->course_id);
            })->where('user_id', $enrollment->user_id)->count();

            $progressPercentage = $totalLessons > 0 
                ? round(($completedLessons / $totalLessons) * 100) 
                : 0;

            $enrollment->update(['progress_percentage' => $progressPercentage]);

            $this->info("User {$enrollment->user_id} - Course {$enrollment->course_id}: {$completedLessons}/{$totalLessons} lessons ({$progressPercentage}%)");
        }

        $this->info('Progress recalculation complete!');
    }
}
