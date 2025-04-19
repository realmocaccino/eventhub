import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useNotificationStore = defineStore('notification', () => {
    const notifications = ref([]);

    const unreadCount = computed(() => 
        notifications.value.filter(n => !n.read_at).length
    );

    const fetchNotifications = async () => {
        try {
            const response = await axios.get('/notifications');
            notifications.value = response.data;
        } catch (error) {
            console.error('Failed to fetch notifications:', error);
        }
    };

    const markAsRead = async (id) => {
        try {
            await axios.patch(`/notifications/${id}/mark-as-read`);
            const n = notifications.value.find(n => n.id === id);
            if (n) n.read_at = new Date().toISOString();
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    };

    const markAllAsRead = async () => {
        try {
            await axios.patch(`/notifications/mark-all-as-read`);
            notifications.value = notifications.value.map(n => ({
                ...n,
                read_at: n.read_at ?? new Date().toISOString()
            }));
        } catch (error) {
            console.error('Error marking notifications as read:', error);
        }
    };

    return { notifications, unreadCount, fetchNotifications, markAsRead, markAllAsRead };
});