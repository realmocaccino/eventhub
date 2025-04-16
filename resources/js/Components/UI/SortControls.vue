<script setup>
defineProps({
  sort: [Function, String],
  direction: String,
  options: Array
});

defineEmits(['update:sort', 'toggle-direction']);
</script>

<template>
  <div class="flex flex-col sm:flex-row gap-4">
    <div class="w-full sm:w-auto">
      <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Sort By</label>
      <select 
        :value="sort"
        @change="$emit('update:sort', $event.target.value)"
        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
      >
        <option v-for="option in options" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
    <div class="w-full sm:w-auto self-end">
      <button 
        @click="$emit('toggle-direction')"
        class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
      >
        <span class="mr-2">{{ direction === 'asc' ? 'Ascending' : 'Descending' }}</span>
        <svg 
          xmlns="http://www.w3.org/2000/svg" 
          class="h-4 w-4" 
          fill="none" 
          viewBox="0 0 24 24" 
          stroke="currentColor"
          :class="{ 'transform rotate-180': direction === 'desc' }"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
        </svg>
      </button>
    </div>
  </div>
</template>