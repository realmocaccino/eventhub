import { defineComponent, reactive, onMounted } from 'vue';
import { useNotificationStore } from '@/Stores/useNotificationStore';

export default defineComponent({
  setup() {
    const store = useNotificationStore();
    const notifications = reactive(store.notifications);

    onMounted(() => {
      Echo.channel('user.' + store.userId)
        .listen('RegistrationStatusChanged', (event) => {
          notifications.push(event);
        });
    });

    return { notifications };
  }
});