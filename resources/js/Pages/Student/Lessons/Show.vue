<template>
    <Head :title="lesson.title" />
    
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/student/dashboard" class="text-2xl font-bold text-primary-500">QuickLearn</a>

                    <!-- Right Side - Profile & Logout -->
                    <div class="flex items-center space-x-6">
                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-primary-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="toggleProfileDropdown" class="flex items-center space-x-2 hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ user.name }}</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div v-if="showProfileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                    My Profile
                                </a>
                                <button @click="logout" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content with Sidebar -->
        <div class="flex pt-16">
            <!-- Left Sidebar Navigation -->
            <div class="fixed left-0 top-16 h-screen w-64 bg-white border-r border-gray-200 overflow-y-auto">
                <nav class="p-4">
                    <ul class="space-y-2">
                        <!-- Home -->
                        <li>
                            <a href="/student/dashboard" :class="route().current('dashboard') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Home</span>
                            </a>
                        </li>

                        <!-- My Courses -->
                        <li>
                            <a href="/student/courses" :class="route().current('student.courses.index') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>My Courses</span>
                            </a>
                        </li>

                        <!-- Browse Courses -->
                        <li>
                            <a href="/student/courses/browse" :class="route().current('student.courses.browse') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Browse Courses</span>
                            </a>
                        </li>

                        <!-- Certificates -->
                        <li>
                            <a href="/student/certificates" :class="route().current('student.certificates.index') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Certificates</span>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li class="pt-4 border-t border-gray-200">
                            <a href="/profile" :class="route().current('profile.*') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                </svg>
                                <span>Settings</span>
                            </a>
                        </li>

                        <!-- Logout -->
                        <li>
                            <button @click="logout" class="w-full text-left flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 ml-64 py-8 px-6">
                <!-- Breadcrumb -->
                <div class="mb-6 flex items-center text-sm text-gray-600">
                    <a href="/student/courses/browse" class="hover:text-primary-500">Courses</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a :href="`/student/courses/${course.id}`" class="hover:text-primary-500">{{ course.title }}</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-900 font-medium">{{ lesson.title }}</span>
                </div>

                <div class="max-w-4xl">

                    <!-- Lesson Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" :class="lesson.lesson_type === 'Video' ? 'bg-primary-100 text-primary-700' : 'bg-gray-100 text-gray-700'">
                                {{ lesson.lesson_type }}
                            </span>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ lesson.estimated_duration || 0 }} minutes
                            </div>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ lesson.title }}</h1>
                    </div>

                    <!-- Video Content -->
                    <div v-if="lesson.lesson_type === 'Video' && lesson.video_url" class="mb-6 bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/9;">
                            <iframe
                                v-if="isYouTubeUrl(lesson.video_url)"
                                :src="getYouTubeEmbedUrl(lesson.video_url)"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="w-full h-full"
                            ></iframe>
                            <video
                                v-else
                                :src="lesson.video_url"
                                controls
                                class="w-full h-full"
                            >
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>

                    <!-- Text Content -->
                    <div v-if="lesson.content" class="bg-white rounded-lg shadow-sm p-6 mb-6 text-gray-700 leading-relaxed border border-gray-200">
                        <div v-html="lesson.content"></div>
                    </div>

                    <!-- Attachments -->
                    <div v-if="attachments && attachments.length > 0" class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Attachments</h3>
                        <div class="space-y-2">
                            <a
                                v-for="attachment in attachments"
                                :key="attachment.id"
                                :href="attachment.file_url"
                                target="_blank"
                                class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition"
                            >
                                <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ attachment.file_name }}</p>
                                    <p class="text-sm text-gray-600">{{ attachment.file_type }}</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Mark Complete & Navigation -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg v-if="lesson.is_completed" class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span v-if="lesson.is_completed" class="text-green-600 font-medium">Lesson Completed</span>
                                <span v-else>Ready to move forward?</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button
                                    v-if="previousLesson"
                                    @click="navigateLesson(previousLesson.id)"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition"
                                >
                                    ← Previous
                                </button>
                                <button
                                    v-if="!lesson.is_completed"
                                    @click="markComplete"
                                    :disabled="isMarkingComplete"
                                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    {{ isMarkingComplete ? 'Marking...' : 'Mark as Complete' }}
                                </button>
                                <button
                                    v-if="nextLesson"
                                    @click="navigateLesson(nextLesson.id)"
                                    class="px-4 py-2 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition"
                                >
                                    Next →
                                </button>
                                <a
                                    v-else
                                    :href="`/student/courses/${course.id}`"
                                    class="px-4 py-2 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition"
                                >
                                    Back to Course
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar - Lesson List -->
                    <div class="mt-8 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Course Content</h3>
                        <div class="space-y-2 max-h-[600px] overflow-y-auto">
                            <div
                                v-for="(item, index) in allLessons"
                                :key="item.id"
                                :class="[
                                    'p-3 rounded-lg cursor-pointer transition',
                                    item.id === lesson.id 
                                        ? 'bg-primary-100 border-2 border-primary-500'
                                        : 'border-2 border-transparent hover:border-gray-200 hover:bg-gray-50',
                                    item.is_completed ? 'bg-green-50' : ''
                                ]"
                                @click="navigateLesson(item.id)"
                            >
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-gray-200 text-gray-700 text-xs font-bold flex items-center justify-center mr-2">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ item.title }}</p>
                                        <p class="text-xs text-gray-600">{{ item.estimated_duration || 0 }} min</p>
                                    </div>
                                    <svg
                                        v-if="item.is_completed"
                                        class="flex-shrink-0 w-5 h-5 text-green-500 ml-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    lesson: {
        type: Object,
        required: true
    },
    course: {
        type: Object,
        required: true
    },
    attachments: {
        type: Array,
        default: () => []
    },
    allLessons: {
        type: Array,
        default: () => []
    },
    previousLesson: {
        type: Object,
        default: null
    },
    nextLesson: {
        type: Object,
        default: null
    }
});

const page = usePage();
const showProfileDropdown = ref(false);
const isMarkingComplete = ref(false);

const user = computed(() => page.props.auth.user);

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value;
};

const logout = () => {
    router.post(route('logout'));
};

const isYouTubeUrl = (url) => {
    return url && (url.includes('youtube.com') || url.includes('youtu.be'));
};

const getYouTubeEmbedUrl = (url) => {
    if (!url) return '';
    
    let videoId = '';
    if (url.includes('youtube.com/watch?v=')) {
        videoId = url.split('watch?v=')[1].split('&')[0];
    } else if (url.includes('youtu.be/')) {
        videoId = url.split('youtu.be/')[1].split('?')[0];
    } else if (url.includes('youtube.com/embed/')) {
        return url;
    }
    
    return `https://www.youtube.com/embed/${videoId}`;
};

const markComplete = () => {
    isMarkingComplete.value = true;
    router.post(route('student.lessons.complete', props.lesson.id), {}, {
        onSuccess: () => {
            // Lesson marked as complete - visit the lesson page again to refresh all data
            router.visit(route('student.lessons.show', props.lesson.id));
        },
        onError: (errors) => {
            isMarkingComplete.value = false;
            console.error('Error marking lesson as complete:', errors);
            alert('Error marking lesson as complete. Please check the console.');
        }
    });
};

const navigateLesson = (lessonId) => {
    router.visit(route('student.lessons.show', lessonId));
};
</script>

<style scoped>
.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.aspect-w-16 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.prose {
    max-width: 65ch;
}

.prose p {
    margin-bottom: 1.25em;
}

.prose h2 {
    font-size: 1.5em;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
}

.prose h3 {
    font-size: 1.25em;
    font-weight: 600;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
}

.prose ul, .prose ol {
    margin: 1.25em 0;
    padding-left: 1.625em;
}

.prose li {
    margin: 0.5em 0;
}
</style>
