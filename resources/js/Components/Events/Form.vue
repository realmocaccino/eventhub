<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  form: Object,
  errors: Object,
  event: Object
});

defineEmits(['submit']);
</script>

<template>
  <form @submit.prevent="$emit('submit')" class="max-w-3xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden">
    <div class="p-6 sm:p-8 space-y-6">
      <div class="border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-bold text-gray-800">
          {{ event ? 'Edit Event' : 'Create New Event' }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
          Fill in the details below to {{ event ? 'update' : 'create' }} your event
        </p>
      </div>

      <div class="space-y-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Event Title *</label>
        <input v-model="form.title" id="title" type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            :class="{ 'border-red-500': errors.title }"
            placeholder="Enter event title"
            required />
        <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
      </div>

      <div class="space-y-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
        <textarea v-model="form.description" id="description" rows="4"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': errors.description }"
                placeholder="Describe your event in detail"
                required></textarea>
        <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="starts_at" class="block text-sm font-medium text-gray-700">Start Date & Time *</label>
          <input v-model="form.starts_at" id="starts_at" type="datetime-local"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  :class="{ 'border-red-500': errors.starts_at }"
                  required />
          <p v-if="errors.starts_at" class="mt-1 text-sm text-red-600">{{ errors.starts_at }}</p>
        </div>

        <div class="space-y-2">
          <label for="ends_at" class="block text-sm font-medium text-gray-700">End Date & Time *</label>
          <input v-model="form.ends_at" id="ends_at" type="datetime-local"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  :class="{ 'border-red-500': errors.ends_at }"
                  required />
          <p v-if="errors.ends_at" class="mt-1 text-sm text-red-600">{{ errors.ends_at }}</p>
        </div>
      </div>

      <div class="space-y-2">
        <label for="location" class="block text-sm font-medium text-gray-700">Location *</label>
        <input v-model="form.location" id="location" type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            :class="{ 'border-red-500': errors.location }"
            placeholder="Where will the event take place?"
            required />
        <p v-if="errors.location" class="mt-1 text-sm text-red-600">{{ errors.location }}</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
          <div class="relative rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
              <span class="text-gray-500 sm:text-sm">$</span>
            </div>
            <input v-model="form.price" id="price" type="number" step="0.01" min="0"
                    class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :class="{ 'border-red-500': errors.price }"
                    placeholder="0.00" />
          </div>
          <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
          <p class="mt-1 text-xs text-gray-500">Leave as 0 for free events</p>
        </div>

        <div class="space-y-2">
          <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
          <input v-model="form.capacity" id="capacity" type="number" min="1"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  :class="{ 'border-red-500': errors.capacity }"
                  placeholder="Maximum attendees" />
          <p v-if="errors.capacity" class="mt-1 text-sm text-red-600">{{ errors.capacity }}</p>
          <p class="mt-1 text-xs text-gray-500">Leave empty for unlimited capacity</p>
        </div>
      </div>

      <div class="space-y-2">
        <label for="image" class="block text-sm font-medium text-gray-700">Event Image</label>
        <div v-if="event && event.image" class="mb-3 flex items-center space-x-4">
          <img :src="`/storage/${event.image}`" alt="Current event image" class="h-16 w-16 object-cover rounded-md">
          <span class="text-sm text-gray-600">Current image</span>
        </div>
        <div class="flex items-center justify-center w-full">
          <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
              </svg>
              <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
              <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
            </div>
            <input id="dropzone-file" type="file" @change="e => form.image = e.target.files[0]" class="hidden" />
          </label>
        </div>
        <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
      </div>

      <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <Link href="/" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Cancel
        </Link>
        <button :disabled="form.processing"
            type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-75 cursor-pointer disabled:cursor-not-allowed">
          {{ event ? 'Update Event' : 'Create Event' }}
        </button>
      </div>
    </div>
  </form>
</template>