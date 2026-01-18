<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo with Instructor Badge -->
                    <div class="flex items-center gap-2">
                        <a href="/instructor/dashboard" class="text-2xl font-bold text-primary-500">QuickLearn</a>
                        <span class="bg-emerald-500 text-white text-xs font-semibold px-2 py-1 rounded">Instructor</span>
                    </div>

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
                                    {{ $page.props.auth.user?.name?.charAt(0).toUpperCase() || 'I' }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $page.props.auth.user?.name }}</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div v-if="showProfileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    My Profile
                                </a>
                                <button @click="logout" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
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
                        <!-- Dashboard -->
                        <li>
                            <a href="/instructor/dashboard" :class="route().current('instructor.dashboard') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- My Courses -->
                        <li>
                            <a href="/instructor/courses" :class="route().current('instructor.courses.*') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>My Courses</span>
                            </a>
                        </li>

                        <!-- Students -->
                        <li>
                            <Link 
                                :href="route('instructor.students.index')" 
                                :class="route().current('instructor.students*') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" 
                                class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Students</span>
                            </Link>
                        </li>

                        <!-- Analytics -->
                        <li>
                            <Link 
                                :href="route('instructor.analytics.index')" 
                                :class="route().current('instructor.analytics*') ? 'bg-sky-100 text-primary-500' : 'text-gray-600 hover:bg-gray-50'" 
                                class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span>Analytics</span>
                            </Link>
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
            <main class="flex-1 ml-64">
                <div class="py-8 px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const showProfileDropdown = ref(false);

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value;
};

const logout = () => {
    router.post(route('logout'));
};
</script>
