<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  event: Object,
  registered: Boolean,
  canManageEvents: Boolean
});

const emit = defineEmits(['register', 'unregister']);
</script>

<template>
  <div class="flex flex-col space-y-4">
    <!-- Register/Unregister Buttons -->
    <div class="my-4">
      <button 
        v-if="registered"
        @click="emit('unregister')"
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded cursor-pointer"
      >
        Unregister
      </button>
      <button 
        v-else
        @click="emit('register')"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded cursor-pointer"
      >
        Register
      </button>
    </div>

    <!-- Management Buttons -->
    <div v-if="canManageEvents" class="mt-6">
      <Link
        :href="`/events/${event.id}/edit/`"
        class="text-sm text-yellow-500 mr-4"
      >
        Edit
      </Link>
      <Link 
        :href="`/events/${event.id}/`"
        method="delete"
        as="button"
        class="text-sm text-red-500 cursor-pointer"
        :preserve-scroll="true"
      >
        Delete
      </Link>
    </div>
  </div>
</template>