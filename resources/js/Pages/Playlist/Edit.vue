<template>
    <div class="px-6">
      <!-- Breadcrumbs -->
      <div class="flex gap-2 pt-4 pb-6 justify-between">
        <div class="flex gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" fill="none">
            <path d="M8 14H3" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M12 9L3 9" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M16 17.4286C16 18.8487 14.8807 20 13.5 20C12.1193 20 11 18.8487 11 17.4286C11 16.0084 12.1193 14.8571 13.5 14.8571C14.8807 14.8571 16 16.0084 16 17.4286ZM16 17.4286V11" stroke="#1C274C" stroke-width="1.5"/>
            <path d="M18.675 8.11607L16.9205 8.95824C16.5788 9.12225 16.408 9.20426 16.2845 9.33067C16.1855 9.43211 16.1091 9.55346 16.0605 9.68666C16 9.85265 16 10.0422 16 10.4212C16 11.2976 16 11.7358 16.1911 11.9987C16.3421 12.2066 16.5673 12.3483 16.8201 12.3945C17.1397 12.453 17.5348 12.2634 18.325 11.8841L20.0795 11.0419C20.4212 10.8779 20.592 10.7959 20.7155 10.6695C20.8145 10.5681 20.8909 10.4467 20.9395 10.3135C21 10.1475 21 9.95803 21 9.57901C21 8.70256 21 8.26434 20.8089 8.00144C20.6579 7.79361 20.4327 7.65188 20.1799 7.60565C19.8603 7.54717 19.4652 7.7368 18.675 8.11607Z" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M20 4L9.5 4M3 4L5.25 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          <h3 class="text-bold text-2xl">Playlist</h3>
        </div>
        <div>
            <a :href="route('playlists.index')" class="text-base rounded-lg bg-red-400 text-black/70 p-2"> Show Your Playlists</a>
        </div>
      </div>
      <!-- Songs -->
       <div class="mb-6 p-2">
        <h3> Your Songs</h3>
        <div v-if="loading" class="m-3">
            <h3>Loading--</h3>
        </div>
        <div v-else class="">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="border border-red-400 p-2">Cover</th>
                        <th class="border border-red-400 p-2">Song Name</th>
                        <th class="border border-red-400 p-2">Artist</th>
                        <th class="border border-red-400 p-2">Year</th>
                        <th class="border border-red-400 p-2">Album</th>
                        <th class="border border-red-400 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                <!-- <tr v-if="playlist.songs.length == 0">
                    <span> There is no data</span>
                </tr> -->
                <tr v-for="songPlaylist in playlist?.songs" :key="songPlaylist?.id">
                    <td class="p-2"><img :src="cover_path" width="40" height="40"/></td>
                    <td class="p-2">{{songPlaylist?.name}}</td>
                    <td class="p-2">{{ formatDate(songPlaylist?.created_at) }}</td>
                    <td class="p-2">{{songPlaylist?.name}}</td>
                    <td class="p-2">{{songPlaylist?.name}}</td>
                    <td class="p-2">
                        <a @click="deleteSong(songPlaylist.id)" class="text-base rounded-lg bg-red-400 text-black/70 p-2 m-2"> Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
      </div>
      <!-- search for songs to add them to playlist-->
      <!-- search section -->
      <div class="w-full ">
        <div class="flex gap-2 items-start"> 
          <!-- title -->
          <h2 class="p-2 text-xl">Browse Songs</h2>
          <!-- search input -->
          <input class="rounded-lg mb-6 text-base text-black/70" type="text" v-model="searchQuery">
          <button @click="searchSpotifySongs" class="p-2">Search</button>
        </div>
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
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      loading:false,
      searchQuery: '',
      songs: [],
      loading: false,
      playlist:[
      ],
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
      // Logic here ${playlist.id}
      try {
        this.loading = true;
        axios.post(`/spotify/playlists/${32}/songs/${song.id}/add`)
        .then(response => {
          console.log(response);
          this.playlist = response.data;
        }).catch(error => {
          console.error('Error adding song to playlist:', error);
          this.error = 'Failed to add song to playlist. Please try again.';
        });}
         finally {
          this.loading = false;
        }
      }
  },
};
</script>
<script setup>
    const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
    return new Intl.DateTimeFormat('de-DE', options).format(date);
    };
</script>