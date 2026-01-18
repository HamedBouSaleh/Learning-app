<template>
    <Head title="Quiz Analytics" />
    
    <InstructorLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Quiz Analytics</h1>
                <p class="text-gray-600 mt-2">Performance statistics for all quizzes across your courses (based on best attempts)</p>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-600">Total Quizzes</h3>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ overallStats.total_quizzes }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-600">Active Courses</h3>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ overallStats.total_courses }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-600">Overall Average</h3>
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ overallStats.overall_average }}%</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-600">Avg Pass Rate</h3>
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ overallStats.avg_pass_rate }}%</div>
                </div>
            </div>

            <!-- Quiz Analytics Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Quiz Performance Breakdown</h2>
                </div>

                <div v-if="quizAnalytics.length === 0" class="p-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-lg font-medium">No quiz data available</p>
                    <p class="text-sm mt-1">Create quizzes and wait for students to complete them</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course & Quiz
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Students
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Average
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Std. Deviation
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Highest
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lowest
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pass Rate
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="quiz in quizAnalytics" :key="quiz.quiz_id" class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ quiz.quiz_title }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ quiz.course_title }}</div>
                                        <div class="text-xs text-gray-400">Lesson: {{ quiz.lesson_title }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-semibold text-gray-900">{{ quiz.total_students }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span 
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold"
                                        :class="{
                                            'bg-green-100 text-green-800': quiz.average_score >= 80,
                                            'bg-yellow-100 text-yellow-800': quiz.average_score >= 60 && quiz.average_score < 80,
                                            'bg-red-100 text-red-800': quiz.average_score < 60
                                        }"
                                    >
                                        {{ quiz.average_score }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-900">{{ quiz.standard_deviation }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-green-600">{{ quiz.highest_score }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-red-600">{{ quiz.lowest_score }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="w-full max-w-xs">
                                            <div class="flex items-center">
                                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div 
                                                        class="h-full rounded-full transition-all"
                                                        :class="{
                                                            'bg-green-500': quiz.pass_rate >= 70,
                                                            'bg-yellow-500': quiz.pass_rate >= 50 && quiz.pass_rate < 70,
                                                            'bg-red-500': quiz.pass_rate < 50
                                                        }"
                                                        :style="{ width: quiz.pass_rate + '%' }"
                                                    ></div>
                                                </div>
                                                <span class="ml-2 text-sm font-semibold text-gray-700">{{ quiz.pass_rate }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </InstructorLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import InstructorLayout from '@/Layouts/InstructorLayout.vue';

defineProps({
    quizAnalytics: {
        type: Array,
        required: true
    },
    overallStats: {
        type: Object,
        required: true
    }
});
</script>
