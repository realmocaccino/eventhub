<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Form from '@/Components/Events/Form.vue';

const props = defineProps({
  event: Object,
  errors: Object,
});

const form = useForm({
  title: props.event.title,
  description: props.event.description,
  starts_at: props.event.starts_at,
  ends_at: props.event.ends_at,
  location: props.event.location,
  price: props.event.price,
  capacity: props.event.capacity,
  image: null,
});

const submit = () => {
  form.post(`/events/${props.event.id}`, {
    _method: 'put',
    preserveScroll: true
  });
};
</script>

<template>
  <Head title="Edit Event" />

  <Layout>
    <div class="max-w-3xl mx-auto">
      <Form
        :form="form"
        :errors="errors"
        :event="props.event"
        @submit="submit"
      />
    </div>
  </Layout>
</template>
