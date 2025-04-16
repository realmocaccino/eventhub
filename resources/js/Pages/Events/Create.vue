<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import Form from '@/Components/Events/Form.vue';

const form = useForm({
  title: '',
  description: '',
  starts_at: '',
  ends_at: '',
  location: '',
  price: '',
  capacity: '',
  image: null,
});

function submit() {
  form.post('/events/');
}
</script>

<template>
  <Head title="Create Event" />

  <Layout>
    <div class="max-w-3xl mx-auto">
      <Form 
        :form="form"
        :errors="form.errors"
        @submit="submit"
      />
    </div>
  </Layout>
</template>