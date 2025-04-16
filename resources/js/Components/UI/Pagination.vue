<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  links: Array,
  from: Number,
  to: Number,
  total: Number
});
</script>

<template>
  <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
    <div class="text-sm text-gray-700">
      Showing <span class="font-medium">{{ from }}</span> to <span class="font-medium">{{ to }}</span> of <span class="font-medium">{{ total }}</span> events
    </div>
    <div class="flex space-x-2">
      <Link 
        v-for="link in links"
        :href="link.url || '#'"
        :class="{
          'bg-blue-50 border-blue-500 text-blue-600': link.active,
          'border-gray-300 text-gray-500 hover:bg-gray-50': !link.active
        }"
        class="px-4 py-2 border rounded-md text-sm font-medium"
        v-html="link.label"
        preserve-scroll
      />
    </div>
  </div>
</template>