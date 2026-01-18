<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'student',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Sign Up" />

    <div class="min-h-screen flex bg-white">
        <!-- Left Side - Light Blue Branding -->
        <div class="hidden lg:flex lg:flex-1 flex-col justify-between px-14 py-16 bg-gradient-to-br from-blue-50 to-blue-100">
            <div>
                <div class="flex items-center space-x-4 mb-12">
                    <span class="text-4xl font-black text-primary-500">QuickLearn</span>
                </div>

                <h1 class="text-5xl font-black text-blue-900 mb-6 leading-tight max-w-lg">
                    Start Your <span class="text-primary-500">Learning</span> Journey
                </h1>

                <p class="text-lg text-blue-700 mb-10 max-w-lg leading-relaxed font-medium">
                    Join thousands of learners mastering new skills. Access world-class courses, earn certificates, and advance your career with expert instruction.
                </p>
                
                <div class="space-y-5">
                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-all">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-blue-900 mb-1">Learn at Your Pace</h3>
                            <p class="text-blue-700">24/7 access to all courses and materials</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-all">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-blue-900 mb-1">Get Certified</h3>
                            <p class="text-blue-700">Earn recognized certificates upon completion</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-all">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-blue-900 mb-1">Expert Instructors</h3>
                            <p class="text-blue-700">Learn from industry professionals</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-blue-700 text-sm">
                <p>© 2025 QuickLearn. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="flex-1 flex items-center justify-center px-6 sm:px-8 lg:px-12 py-10 overflow-y-auto">
            <div class="max-w-md w-full">
                <!-- Mobile Logo -->
                <div class="text-center lg:hidden mb-6">
                    <h2 class="text-3xl font-black text-blue-900">Sign Up</h2>
                </div>

                <!-- Form Container -->
                <div class="bg-white border-2 border-blue-200 rounded-2xl p-7 shadow-lg">
                    <div class="hidden lg:block mb-6">
                        <h2 class="text-3xl font-black text-blue-900">Create Account</h2>
                        <p class="text-blue-700 mt-2">Join our learning community</p>
                    </div>

                    <!-- Signup Form -->
                    <form class="space-y-5" @submit.prevent="submit">
                        <!-- Role Selection -->
                        <div>
                            <label class="block text-sm font-bold text-blue-900 mb-2.5">Join as</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    type="button"
                                    @click="form.role = 'student'"
                                    :class="[
                                        'rounded-xl border-2 p-4 flex flex-col items-center cursor-pointer transition-all',
                                        form.role === 'student'
                                            ? 'border-blue-600 bg-blue-100'
                                            : 'border-blue-300 bg-blue-50 hover:border-blue-400'
                                    ]"
                                >
                                    <svg class="w-8 h-8 mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                    <span :class="['text-sm font-semibold', form.role === 'student' ? 'text-blue-900' : 'text-blue-700']">Student</span>
                                </button>

                                <button
                                    type="button"
                                    @click="form.role = 'instructor'"
                                    :class="[
                                        'rounded-xl border-2 p-4 flex flex-col items-center cursor-pointer transition-all',
                                        form.role === 'instructor'
                                            ? 'border-blue-600 bg-blue-100'
                                            : 'border-blue-300 bg-blue-50 hover:border-blue-400'
                                    ]"
                                >
                                    <svg class="w-8 h-8 mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span :class="['text-sm font-semibold', form.role === 'instructor' ? 'text-blue-900' : 'text-blue-700']">Instructor</span>
                                </button>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-blue-900 mb-2">Your Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                autocomplete="name"
                                required
                                v-model="form.name"
                                class="w-full px-4 py-3 rounded-xl border-2 border-blue-300 bg-white text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Your Name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-blue-900 mb-2">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                v-model="form.email"
                                class="w-full px-4 py-3 rounded-xl border-2 border-blue-300 bg-white text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="you@example.com"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-blue-900 mb-2">Password</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    autocomplete="new-password"
                                    required
                                    v-model="form.password"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-blue-300 bg-white text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all pr-12"
                                    placeholder="Create a strong password"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-700"
                                >
                                    <svg v-if="!showPassword" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.262l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M15.171 13.576l1.474 1.474a1 1 0 001.414-1.414l-14-14a1 1 0 00-1.414 1.414l1.473 1.473A10.014 10.014 0 00.458 10c1.274 4.057 5.064 7 9.542 7 .8 0 1.577-.066 2.341-.184l.824.824a1 1 0 001.414-1.414l-1.48-1.48z" />
                                    </svg>
                                </button>
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-blue-900 mb-2">Confirm Password</label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    :type="showPasswordConfirmation ? 'text' : 'password'"
                                    autocomplete="new-password"
                                    required
                                    v-model="form.password_confirmation"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-blue-300 bg-white text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all pr-12"
                                    placeholder="Confirm password"
                                />
                                <button
                                    type="button"
                                    @click="showPasswordConfirmation = !showPasswordConfirmation"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-700"
                                >
                                    <svg v-if="!showPasswordConfirmation" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.262l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                        <path d="M15.171 13.576l1.474 1.474a1 1 0 001.414-1.414l-14-14a1 1 0 00-1.414 1.414l1.473 1.473A10.014 10.014 0 00.458 10c1.274 4.057 5.064 7 9.542 7 .8 0 1.577-.066 2.341-.184l.824.824a1 1 0 001.414-1.414l-1.48-1.48z" />
                                    </svg>
                                </button>
                            </div>
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="!form.processing">Create Account</span>
                            <span v-else class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating account...
                            </span>
                        </button>

                        <!-- Sign In Link -->
                        <div class="mt-6 pt-5 border-t-2 border-blue-200 text-center">
                            <p class="text-blue-900">
                                Already have an account?
                                <Link :href="route('login')" class="text-blue-600 font-bold hover:text-blue-700">
                                    Sign in
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px white inset;
    -webkit-text-fill-color: #0f172a;
}

input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px white inset;
    -webkit-text-fill-color: #0f172a;
}
</style>
