import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
  const { props } = usePage();

  const canManageEvents = props.auth?.user?.canManageEvents ?? false;

  return { canManageEvents };
}