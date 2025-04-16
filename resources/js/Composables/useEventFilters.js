import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

export const sortOptions = [
  { value: 'title', label: 'Title' },
  { value: 'starts_at', label: 'Date' },
  { value: 'location', label: 'Location' },
  { value: 'price', label: 'Price' },
];

export default function useEventFilters(initialFilters, routeName = '/') {
  const filters = ref({
    start_date: initialFilters.start_date || '',
    end_date: initialFilters.end_date || '',
    sort: initialFilters.sort || '',
    direction: initialFilters.direction || 'asc'
  });

  const toggleSortDirection = () => {
    filters.value.direction = filters.value.direction === 'asc' ? 'desc' : 'asc';
  };

  watch(filters, debounce(() => {
    router.get(routeName, filters.value, {
      preserveState: true,
      replace: true,
    });
  }, 300), { deep: true });

  return {
    filters,
    sortOptions,
    toggleSortDirection
  };
}