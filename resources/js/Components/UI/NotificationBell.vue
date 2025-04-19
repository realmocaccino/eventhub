<script setup>
import { ref, onMounted } from 'vue';
import { useFormattedDate } from '@/Composables/useFormattedDate';
import { useNotificationStore } from '@/Stores/useNotificationStore';

const store = useNotificationStore();
const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value && store.notifications.length === 0) {
        store.fetchNotifications();
    }
};

const { formatDate } = useFormattedDate();

onMounted(() => {
    store.fetchNotifications();
});
</script>

<template>
    <div class="relative">
        <button @click="toggleDropdown" class="p-2 rounded-full hover:bg-gray-100 cursor-pointer">
            <span v-if="store.unreadCount > 0" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                {{ store.unreadCount }}
            </span>
            <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        <div v-if="isOpen" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl z-10 border border-gray-100 overflow-hidden">
            <div class="px-5 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                        {{ store.notifications.length }} new
                    </span>
                </div>
            </div>
            
            <div v-if="store.notifications.length === 0" class="p-5 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h4 class="text-sm font-medium text-gray-700 mb-1">No notifications</h4>
                <p class="text-xs text-gray-500">We'll notify you when something arrives</p>
            </div>
            
            <div v-else class="max-h-96 overflow-y-auto">
                <div 
                    v-for="notification in store.notifications" 
                    :key="notification.id"
                    @click="store.markAsRead(notification.id)"
                    class="px-5 py-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 cursor-pointer transition-colors duration-100"
                    :class="{ 'bg-gray-50/50': notification.read_at }"
                >
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 mb-1 leading-tight">
                                {{ notification.data.message }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    {{ formatDate(notification.created_at).full }}
                                </span>
                                <span v-if="!notification.read_at" class="inline-block h-2 w-2 rounded-full bg-blue-500"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-if="store.notifications.length > 0" class="px-5 py-3 border-t border-gray-100 bg-gray-50/50">
                <button 
                    @click="store.markAllAsRead()"
                    class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors cursor-pointer"
                >
                    Mark all as read
                </button>
            </div>
        </div>
    </div>
</template>