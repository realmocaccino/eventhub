<script setup>
defineProps({
  startDate: String,
  endDate: String
});

defineEmits(['update:startDate', 'update:endDate']);
</script>

<template>
  <div class="flex flex-col sm:flex-row gap-4">
    <div class="w-full sm:w-auto">
      <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Start Date</label>
      <input 
        :value="startDate"
        @input="$emit('update:startDate', $event.target.value)"
        type="date" 
        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
      >
    </div>
    <div class="w-full sm:w-auto">
      <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">End Date</label>
      <input 
        :value="endDate"
        @input="$emit('update:endDate', $event.target.value)"
        type="date" 
        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
      >
    </div>
  </div>
</template>