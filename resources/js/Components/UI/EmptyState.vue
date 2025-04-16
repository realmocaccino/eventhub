<script setup>
defineProps({
  title: String,
  description: String,
  showCreateButton: Boolean
});
</script>

<template>
  <div class="p-8 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h3 class="mt-2 text-lg font-medium text-gray-900">{{ title }}</h3>
    <p class="mt-1 text-gray-500">{{ description }}</p>
    <div v-if="showCreateButton" class="mt-6">
      <slot name="action">
        <!-- Default action button can go here -->
      </slot>
    </div>
  </div>
</template>