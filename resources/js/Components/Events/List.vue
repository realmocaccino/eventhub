<script setup>
import { Link } from '@inertiajs/vue3';
import { useFormattedDate } from '@/Composables/useFormattedDate';
import { useFormattedPrice } from '@/Composables/useFormattedPrice';
import { useNameInitials } from '@/Composables/useNameInitials';

defineProps({
  events: Array,
  canManageEvents: Boolean
});

const { formatDate } = useFormattedDate();
const { formatPrice } = useFormattedPrice();
const { getNameInitials } = useNameInitials();
</script>

<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div v-for="event in events" :key="event.id" class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-200">
      <!-- Event Image/Thumbnail -->
      <div class="relative h-40 bg-gray-100">
        <template v-if="event.image">
          <img 
            class="w-full h-full object-cover" 
            :src="`/storage/${event.image}`" 
            :alt="event.title">
        </template>
        <template v-else>
          <div class="w-full h-full flex items-center justify-center bg-gray-200">
            <span class="text-2xl font-medium text-gray-600">
              {{ getNameInitials(event.title) }}
            </span>
          </div>
        </template>
      </div>

      <!-- Event Content -->
      <div class="p-4">
        <div class="flex justify-between items-start">
          <div>
            <Link :href="`/event/${event.id}`" class="text-lg font-semibold text-gray-900 hover:text-blue-600 line-clamp-1">
              {{ event.title }}
            </Link>
            <p class="mt-1 text-sm text-gray-500">
              <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              {{ event.location }}
            </p>
          </div>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            {{ formatPrice(event.price) }}
          </span>
        </div>

        <!-- Date and Time -->
        <div class="mt-3 flex items-center text-sm text-gray-500">
          <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <div>
            <span class="font-medium text-gray-900">{{ formatDate(event.starts_at).date }}</span>
            <span class="ml-1">{{ formatDate(event.starts_at).time }}</span>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-4 flex justify-between items-center border-t border-gray-100 pt-3">
          <Link 
            :href="`/event/${event.id}`" 
            class="text-sm font-medium text-blue-600 hover:text-blue-500">
            View details
          </Link>
          <div v-if="canManageEvents" class="flex space-x-3">
            <Link 
              :href="`/events/${event.id}/edit/`"
              class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
              Edit
            </Link>
            <Link 
              :href="`/events/${event.id}`"
              method="delete" 
              as="button"
              class="text-sm font-medium text-red-600 hover:text-red-500"
              :preserve-scroll="true">
              Delete
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>