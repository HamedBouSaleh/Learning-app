<template>
    <Head :title="`${student.name} - Performance Details`" />
    
    <InstructorLayout>
        <div class="p-6">
            <!-- Back Button -->
            <Link 
                :href="route('instructor.students.index')"
                class="inline-flex items-center text-primary-600 hover:text-primary-800 mb-6"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Students
            </Link>

            <!-- Student Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-primary-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ student.name.charAt(0).toUpperCase() }}</span>
                        </div>
                        <div class="ml-6">
                            <h1 class="text-3xl font-bold text-gray-900">{{ student.name }}</h1>
                            <p class="text-gray-600 mt-1">{{ student.email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Overall Average</h3>
                    <div class="text-3xl font-bold text-gray-900">{{ studentStats.overall_average }}%</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Quizzes Taken</h3>
                    <div class="text-3xl font-bold text-gray-900">{{ studentStats.total_quizzes_taken }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Quizzes Passed</h3>
                    <div class="text-3xl font-bold text-green-600">{{ studentStats.quizzes_passed }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Highest Score</h3>
                    <div class="text-3xl font-bold text-blue-600">{{ studentStats.highest_score }}%</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Lowest Score</h3>
                    <div class="text-3xl font-bold text-red-600">{{ studentStats.lowest_score }}%</div>
                </div>
            </div>

            <!-- Course Performance -->
            <div v-if="coursePerformance.length === 0" class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-medium text-gray-900">No course data available</p>
                <p class="text-sm text-gray-500 mt-1">This student hasn't enrolled in any of your courses yet</p>
            </div>

            <div v-else class="space-y-6">
                <!-- Each Course -->
                <div 
                    v-for="course in coursePerformance" 
                    :key="course.course_id"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                >
                    <!-- Course Header -->
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ course.course_title }}</h2>
                                <p class="text-primary-100 text-sm mt-1">Enrolled: {{ course.enrolled_at }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-white">{{ course.course_average ?? 'N/A' }}<span v-if="course.course_average">%</span></div>
                                <div class="text-primary-100 text-sm">Course Average</div>
                            </div>
                        </div>
                        <div class="mt-3 text-primary-100 text-sm">
                            {{ course.quizzes_completed }} / {{ course.total_quizzes }} quizzes completed
                        </div>
                    </div>

                    <!-- Quizzes -->
                    <div class="p-6">
                        <div v-if="course.quizzes.length === 0" class="text-center py-8 text-gray-500">
                            No quizzes in this course yet
                        </div>
                        <div v-else class="space-y-6">
                            <div 
                                v-for="quiz in course.quizzes" 
                                :key="quiz.quiz_id"
                                class="border border-gray-200 rounded-lg overflow-hidden"
                            >
                                <!-- Quiz Header -->
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ quiz.quiz_title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Passing Score: {{ quiz.passing_score }}% • 
                                                Attempts: {{ quiz.attempts_count }}
                                            </p>
                                        </div>
                                        <div v-if="quiz.best_score !== null" class="text-right">
                                            <div 
                                                class="text-2xl font-bold"
                                                :class="{
                                                    'text-green-600': quiz.passed,
                                                    'text-red-600': !quiz.passed
                                                }"
                                            >
                                                {{ quiz.best_score }}%
                                            </div>
                                            <div class="text-xs text-gray-600">Best Score</div>
                                            <div 
                                                class="mt-1 px-3 py-1 rounded-full text-xs font-semibold inline-block"
                                                :class="{
                                                    'bg-green-100 text-green-800': quiz.passed,
                                                    'bg-red-100 text-red-800': !quiz.passed
                                                }"
                                            >
                                                {{ quiz.passed ? 'PASSED' : 'FAILED' }}
                                            </div>
                                        </div>
                                        <div v-else class="text-gray-400 text-sm italic">
                                            Not attempted yet
                                        </div>
                                    </div>
                                </div>

                                <!-- All Attempts -->
                                <div v-if="quiz.all_attempts.length > 0" class="p-6">
                                    <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase">All Attempts</h4>
                                    <div class="space-y-3">
                                        <div 
                                            v-for="attempt in quiz.all_attempts" 
                                            :key="attempt.attempt_number"
                                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200"
                                        >
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-sm font-bold text-gray-700">#{{ attempt.attempt_number }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ attempt.score }} / {{ attempt.total_points }} points
                                                    </div>
                                                    <div class="text-xs text-gray-600 mt-1">
                                                        {{ attempt.completed_at }} • {{ attempt.time_spent }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <div 
                                                    class="text-xl font-bold"
                                                    :class="{
                                                        'text-green-600': attempt.passed,
                                                        'text-red-600': !attempt.passed
                                                    }"
                                                >
                                                    {{ attempt.percentage }}%
                                                </div>
                                                <div 
                                                    class="px-3 py-1 rounded-full text-xs font-semibold"
                                                    :class="{
                                                        'bg-green-100 text-green-800': attempt.passed,
                                                        'bg-red-100 text-red-800': !attempt.passed
                                                    }"
                                                >
                                                    {{ attempt.passed ? 'PASSED' : 'FAILED' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </InstructorLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import InstructorLayout from '@/Layouts/InstructorLayout.vue';

defineProps({
    student: {
        type: Object,
        required: true
    },
    coursePerformance: {
        type: Array,
        required: true
    },
    studentStats: {
        type: Object,
        required: true
    }
});
</script>
