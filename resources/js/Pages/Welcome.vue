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
    <div class="">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- header section -->
                <header class="grid grid-cols-2 col-span-3 items-center gap-2 py-3 lg:grid-cols-3">
                    <div class="flex gap-4 lg:col-start-2 lg:justify-between">
                       <div> 
                            <img src="/public/images/music.png" height="40" width="40"/>  
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
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition "
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <!-- main section -->
                <main class="mt-2">
                    <div class="">
                        <div class="flex flex-col items-start gap-3 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300  md:row-span-3 lg:p-10 lg:pb-10 bg-red-100">
                            <!-- intro section -->
                            <div class="w-full">
                                <!-- title -->
                                <h2 class="p-2 text-2xl my-6 text-red-600">Spotify App</h2>
                                <!-- description -->
                                <p class="text-sm">One Good Thing About Music</p>
                                <p class="text-2xl my-3">When It Hits You, You Feel No Pain.</p>
                                <!-- CTA btn -->
                                <button class="text-base rounded-lg bg-red-400 text-black/70 p-2">Listen Now</button>
                            </div>

                            <!-- search section -->
                            <div class="w-full">
                                <!-- title -->
                                <h2 class="p-2 text-2xl">Browse Songs</h2>
                                <!-- search input -->
                                <input class="rounded-lg mb-6 text-base text-black/70" type="text" v-model="searchQuery">
                                <button @click="searchSpotifySongs" class="p-2">Search</button>
                                <!-- search result -->
                                <ul v-if="songs.length > 0" class="flex flex-wrap gap-8 justify-content-between ">
                                    <li v-for="song in songs" :key="song.id" >
                                        <div>
                                            <h3 class="p-2 text-xl text-wrap">{{ song.name }} </h3>
                                            <div class="text-base text-wrap">{{ song.album.name }} </div><span class="text-sm">{{ song.release_year }}</span>
                                            <img class="rounded-lg" :src="song.album.images[0].url" width="130" height="130" />
                                            <audio controls :src="song.preview_url" v-if="song.preview_url"></audio>
                                            <button @click="addToPlaylist(song)" class="rounded-lg text-orange bg-white/30 p-2">Add to Playlist</button>
                                        </div>
                                    </li>
                                </ul>
                                <p v-else-if="loading">Loading songs...</p>
                                <p v-else>No songs found.</p>

                            </div>

                            <!-- Trend Songs -->
                            <song-card></song-card>

                        </div>
                    </div>
                </main>

                <!-- footer section -->
                <footer class="py-16 flex justify-between text-center text-sm text-black">
                    <div>
                        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                    </div>  
                    <div>
                        Made with 💕 by Manar Abo Alkheir
                    </div> 
                </footer>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import songCard from '@/Components/songCard.vue';
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
      // Logic here
    //   try {
    //     axios.post()
    //   }
      console.log('Adding song to playlist:', song);
    },
  },
};
</script>