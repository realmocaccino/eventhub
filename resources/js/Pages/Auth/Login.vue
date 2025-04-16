<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login')
}
</script>

<template>
  <Head title="Login" />
  
  <Layout>
    <div class="min-h-screen bg-gray-50 flex justify-center p-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
            Sign in to your account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
            Please enter your credentials.
            </p>
        </div>

        <form class="mt-4 space-y-4" @submit.prevent="submit">
            <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                id="email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                id="password"
                v-model="form.password"
                type="password"
                required
                autocomplete="current-password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div class="flex items-center">
            <input
                id="remember"
                v-model="form.remember"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            >
            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>

            <div v-if="form.hasErrors && form.errors.message" class="text-sm text-red-600 flex justify-center">
             {{ form.errors.message }}
            </div>

            <div>
            <button
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer"
                :disabled="form.processing"
            >
                Sign in
            </button>
            </div>

            <div class="text-center text-sm pt-2">
            <Link 
                href="/register" 
                class="text-blue-600 hover:text-blue-500"
            >
                Need an account?
            </Link>
            </div>
        </form>
        </div>
    </div>
  </Layout>
</template>