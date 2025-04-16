<script setup>
import { Link, Head, useForm, usePoll } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { useFormattedDate } from '@/Composables/useFormattedDate';
import { useEventRegistration } from '@/Composables/useEventRegistration';
import { usePermissions } from '@/Composables/usePermissions';

const { event, registered } = defineProps({
  event: Object,
  registered: Boolean,
});

const { formatDate } = useFormattedDate();
const { registerForm, unregisterForm, register, unregister } = useEventRegistration(event.id);
const { canManageEvents } = usePermissions();

usePoll(5000, {
  onMounted() {
    router.reload();
  },
})
</script>

<template>
  <Head :title="event.title" />

  <Layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="h-64 w-full overflow-hidden">
          <img
            :src="`/storage/${event.image}`"
            alt="Event image"
            class="w-full h-full object-cover"
          >
        </div>

        <div class="p-6 sm:p-8">
          <!-- Header -->
          <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ event.title }}</h1>
            <p class="mt-2 text-lg text-gray-600">{{ event.description }}</p>
          </header>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                  <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-500">Date & Time</p>
                  <p class="text-sm text-gray-900">
                    {{ formatDate(event.starts_at).full }} - {{ formatDate(event.ends_at).time }}
                  </p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                  <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-500">Location</p>
                  <p class="text-sm text-gray-900">{{ event.location }}</p>
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                  <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-500">Price</p>
                  <p class="text-sm font-semibold" :class="event.price ? 'text-green-600' : 'text-gray-900'">
                    {{ event.price ? `$${event.price}` : 'Free' }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8">
            <form
              @submit.prevent="registered ? unregister() : register()"
            >
              <button
                type="submit"
                class="w-full sm:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white transition-colors cursor-pointer"
                :class="registered
                  ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                  : 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'"
                :disabled="registered ? unregisterForm.processing : registerForm.processing"
              >
                {{ registered ? 'Cancel Registration' : 'Register Now' }}
              </button>
            </form>
          </div>

          <div
            v-if="canManageEvents"
            class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4"
          >
            <Link
              :href="`/events/${event.id}/edit`"
              class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Edit Event
            </Link>
            <Link
              :href="`/events/${event.id}`"
              method="delete"
              as="button"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer"
            >
              Delete Event
            </Link>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>