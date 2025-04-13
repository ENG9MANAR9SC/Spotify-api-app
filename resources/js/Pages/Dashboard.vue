<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
      <template #header>
          <h2 class="text-xl font-semibold leading-tight text-gray-800">
              Dashboard
          </h2>
      </template>

      <!-- Trend Songs -->
        <song-card></song-card>

    </AuthenticatedLayout>
</template>

<script>
import axios from 'axios';


export default {
  data() {
    return {
      searchQuery: '',
      songs: [],
      loading: false,
    };
  },
  methods: {
     getTrendSpotifySongs() {
        this.loading = true;
        try {
          axios.get(`/spotify/get/tracks`)
          .then(response => {
            this.songs = response.data;

          })
          .catch(error => {
            console.error('Error searching songs:', error);
            this.error = 'Failed to fetch songs. Please try again.';
          });
        } finally {
          this.loading = false;
        }
    },
  },
  mounted() {
    this.getTrendSpotifySongs();
  }
};
</script>
