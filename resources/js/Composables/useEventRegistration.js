import { useForm } from '@inertiajs/vue3';
import { useNotificationStore } from '@/Stores/useNotificationStore';

export function useEventRegistration(eventId) {
  const registerForm = useForm({});
  const unregisterForm = useForm({});
  const notificationStore = useNotificationStore();

  const register = async () => {
    await registerForm.post(`/events/${eventId}/register`, {
      onSuccess: () => {
        notificationStore.fetchNotifications();
      }
    });
  };

  const unregister = async () => {
    await unregisterForm.post(`/events/${eventId}/unregister`, {
      onSuccess: () => {
        notificationStore.fetchNotifications();
      }
    });
  };

  return {
    registerForm,
    unregisterForm,
    register,
    unregister,
  };
}