import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useNotificationStore = defineStore('notification', () => {
    const notifications = ref([]);
    const unreadCount = ref(0);
    const userId = ref(1);

    const addNotification = (notification) => {
        notifications.value.unshift(notification);
        unreadCount.value++;
    };

    const markAsRead = (id) => {
        const notification = notifications.value.find(n => n.id === id);
        if (notification && !notification.read_at) {
            notification.read_at = new Date();
            unreadCount.value--;
        }
    };

    return { notifications, unreadCount, userId, addNotification, markAsRead };
});