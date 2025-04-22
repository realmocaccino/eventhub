<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import NotificationBell from '@/Components/UI/NotificationBell.vue';

const flash = computed(() => usePage().props.flash);
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
            <Link href="/" class="text-xl font-bold text-gray-900 flex items-center">
              <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              EventHub
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <Link
              href="/"
              class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              :class="{
                'border-blue-500 text-gray-900': $page.component === 'Events/Index',
                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': $page.component !== 'Events/Index',
              }"
            >
              Home
            </Link>
            <Link
              v-if="$page.props.auth.user?.canManageEvents"
              href="/events/manage"
              class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              :class="{
                'border-blue-500 text-gray-900': $page.component === 'Events/Manage',
                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': $page.component !== 'Events/Manage',
              }"
            >
              Manage Events
            </Link>
          </div>

          <div class="ml-4 flex items-center md:ml-6 space-x-4">
            <NotificationBell v-if="$page.props.auth.user" />

            <div class="flex items-center space-x-3">
              <Link href="/account" class="flex items-center space-x-2 group">
                <div class="relative">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-gray-700 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <span class="hidden md:inline text-sm font-medium text-gray-500 group-hover:text-gray-700 transition-colors">
                  {{ $page.props.auth.user?.name || 'Account' }}
                </span>
              </Link>
            </div>

            <div v-if="$page.props.auth.user?.canManageEvents">
              <Link 
                href="/events/create" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Event
              </Link>
            </div>

            <!-- Auth Buttons -->
            <div v-if="$page.props.auth.user" class="flex items-center">
              <Link 
                method="post" 
                href="/logout" 
                as="button"
                class="text-sm font-medium text-gray-500 hover:text-gray-700 px-2 py-1 rounded hover:bg-gray-100 transition-colors cursor-pointer">
                Sign Out
              </Link>
            </div>
            <div v-else class="flex items-center space-x-2">
              <Link 
                href="/login" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Login
              </Link>
              <Link 
                href="/register" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Register
              </Link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="flash.success" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
      <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-800">
              {{ flash.success }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <slot />
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-sm text-gray-500">
          &copy; {{ new Date().getFullYear() }} EventHub. All rights reserved.
        </p>
      </div>
    </footer>
  </div>
</template>