import { useForm } from '@inertiajs/vue3';

export function useEventRegistration(eventId) {
  const registerForm = useForm({});
  const unregisterForm = useForm({});

  const register = () => registerForm.post(`/events/${eventId}/register`);
  const unregister = () => unregisterForm.post(`/events/${eventId}/unregister`);

  return {
    registerForm,
    unregisterForm,
    register,
    unregister,
  };
}