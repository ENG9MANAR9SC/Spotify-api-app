<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 col-span-3 items-center gap-2 py-8 lg:grid-cols-3">
                    <div class="flex gap-4 lg:col-start-2 lg:justify-between">
                       <div> 
                            <img src=""/>Logo
                        </div>
                        <div class="flex flex-wrap gap-2"> 
                            <Link href="">Home</Link>
                            <Link href="">Playlists</Link>
                            <Link href="">Songs</Link>
                            <Link href="">About us</Link>
                        </div>
                    </div>
                    <!-- Register & Login -->
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <div class="">
                        <div
                            class="flex flex-col items-start gap-3 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                        >
                        <div class="w-full">
                            <h1 class="p-2">Browse Songs</h1>
                            <input class="rounded-lg mb-6" type="text" v-model="searchQuery">
                            <button @click="searchSpotifySongs" class="p-2">Search</button>
                        
                            <ul v-if="songs.length > 0" class="flex flex-wrap gap-6">
                                <li v-for="song in songs" :key="song.id" >
                                    <div>
                                        {{ song.name }}  - {{ song.artist }} 
                                        <img class="rounded-lg" :src="song.album.images[0].url" width="100" height="100" />
                                        <audio controls :src="song.preview_url" v-if="song.preview_url"></audio>
                                        <button @click="addToPlaylist(song)">Add to Playlist</button>
                                    </div>
                                </li>
                            </ul>
                            <p v-else-if="loading">Loading songs...</p>
                            <p v-else>No songs found.</p>

                        </div>
                           
                        </div>
                    </div>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
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
     searchSpotifySongs() {
      this.loading = true;
      try {
        axios.get(`/spotify/songs/search?q=${this.searchQuery}`)
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
    addToPlaylist(song) {
      // Logic to select a playlist and call the backend API to add the song
      console.log('Adding song to playlist:', song);
      // You'll need to implement a way for the user to choose a playlist here
    },
  },
};
</script>