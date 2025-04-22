<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useFormattedDate } from '@/Composables/useFormattedDate'

const { formatDate } = useFormattedDate();

const user = usePage().props.auth.user
</script>

<template>
  <Head title="Account"></Head>

  <Layout>
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 py-12 px-4 text-center text-white">
      <div class="w-24 h-24 rounded-full bg-white bg-opacity-20 backdrop-blur-sm border-2 border-white border-opacity-20 flex items-center justify-center mx-auto mb-4">
        <span class="text-3xl font-bold text-white">
          {{ userInitials }}
        </span>
      </div>
      <h1 class="text-2xl font-semibold">
        {{ user.name }}
      </h1>
    </div>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">My Events</h2>
      
      <div v-if="user?.events.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="event in user.events"
          :key="event.id"
          class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 overflow-hidden hover:-translate-y-1"
        >
          <div class="h-40 bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
          </div>
          
          <div class="p-5">
            <h3 class="font-medium text-gray-800 mb-1 line-clamp-1">
              <Link
                :href="`/event/${event.id}`"
              >
                {{ event.title }}
              </Link>
            </h3>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-500">
                {{ formatDate(event.date).full }}
              </span>
              <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">
                {{ event.price }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-xl">
        <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-700 mb-2">No events yet</h3>
        <p class="text-gray-500 max-w-md mx-auto mb-6">Discover and join exciting events in your area</p>
        <button class="px-6 py-2 bg-indigo-600 text-white rounded-full font-medium shadow-sm hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Browse Events
        </button>
      </div>
    </div>
  </Layout>
</template>
