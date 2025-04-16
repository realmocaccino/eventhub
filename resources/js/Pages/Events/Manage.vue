<script setup>
import { router, usePoll } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import DateRangeFilter from '@/Components/UI/DateRangeFilter.vue';
import SortControls from '@/Components/UI/SortControls.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import EventTable from '@/Components/Events/Table.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import useEventFilters, { sortOptions } from '@/Composables/useEventFilters';

const props = defineProps({
  events: Object,
  filters: Object,
});

const { filters, toggleSortDirection } = useEventFilters(props.filters, '/events/manage');

usePoll(5000, {
  onMounted() {
    router.get('/events/manage', filters.value, {
      preserveState: true,
      replace: true,
      only: ['events'],
    });
  },
})
</script>

<template>
  <Head title="Manage Events" />

  <Layout>
    <template #default>
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Events</h1>
      </div>

      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between gap-4">
              <DateRangeFilter 
                v-model:startDate="filters.start_date"
                v-model:endDate="filters.end_date"
              />

              <SortControls 
                v-model:sort="filters.sort"
                :direction="filters.direction"
                :options="sortOptions"
                @toggle-direction="toggleSortDirection"
              />
            </div>
          </div>

          <EmptyState 
            v-if="events.data.length === 0"
            title="No events match your filters"
            description="Try adjusting your date range or sorting options."
            :showCreateButton="$page.props.auth.user?.canManageEvents"
          >
            <template #action>
              <Link 
                href="/events/create/" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Create a new event
              </Link>
            </template>
          </EmptyState>

          <EventTable 
            v-else
            :events="events.data"
            :canManageEvents="$page.props.auth.user?.canManageEvents"
          />

          <Pagination 
            :links="events.links"
            :from="events.from"
            :to="events.to"
            :total="events.total"
          />
        </div>
      </div>
    </template>
  </Layout>
</template>