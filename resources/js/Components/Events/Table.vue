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
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <tr v-for="event in events" :key="event.id">
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="flex items-center">
            <template v-if="event.image">
              <img 
                class="h-10 w-10 rounded-full object-cover" 
                :src="`/storage/${event.image}`" 
                :alt="event.title">
            </template>
            <template v-else>
              <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-xs font-medium text-gray-600">
                  {{ getNameInitials(event.title) }}
                </span>
              </div>
            </template>
            <div class="ml-4">
              <div class="text-sm font-medium text-gray-900">
                <Link :href="`/event/${event.id}`" class="hover:text-blue-600">
                  {{ event.title }}
                </Link>
              </div>
            </div>
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm text-gray-900">
            {{ formatDate(event.starts_at).date }}
          </div>
          <div class="text-sm text-gray-500">
            {{ formatDate(event.starts_at).time }}
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ event.location }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          {{ formatPrice(event.price) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <Link :href="`/event/${event.id}`" class="text-blue-600 hover:text-blue-900 mr-3">View</Link>
          <Link v-if="canManageEvents" 
                :href="`/events/${event.id}/edit/`"
                class="text-indigo-600 hover:text-indigo-900 mr-3">
            Edit
          </Link>
          <Link v-if="canManageEvents" 
                :href="`/events/${event.id}`"
                method="delete" 
                as="button"
                class="text-red-600 hover:text-red-900 cursor-pointer"
                :preserve-scroll="true">
            Delete
          </Link>
        </td>
      </tr>
    </tbody>
  </table>
</template>