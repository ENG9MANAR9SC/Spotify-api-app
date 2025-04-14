<template>
    <div class="px-6">
      <!-- music icon -->
      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="60px" height="60px" viewBox="0 0 24 24" fill="none">
        <path d="M12 19.5C12 20.8807 10.8807 22 9.5 22C8.11929 22 7 20.8807 7 19.5C7 18.1193 8.11929 17 9.5 17C10.8807 17 12 18.1193 12 19.5Z" stroke="#1C274C" stroke-width="1.5"/>
        <path d="M22 17.5C22 18.8807 20.8807 20 19.5 20C18.1193 20 17 18.8807 17 17.5C17 16.1193 18.1193 15 19.5 15C20.8807 15 22 16.1193 22 17.5Z" stroke="#1C274C" stroke-width="1.5"/>
        <path d="M22 8L12 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M14.4556 5.15803L14.7452 5.84987L14.4556 5.15803ZM16.4556 4.32094L16.1661 3.62909L16.4556 4.32094ZM21.1081 3.34059L20.6925 3.96496L20.6925 3.96496L21.1081 3.34059ZM12.75 19.0004V8.84787H11.25V19.0004H12.75ZM22.75 17.1542V8.01078H21.25V17.1542H22.75ZM14.7452 5.84987L16.7452 5.01278L16.1661 3.62909L14.1661 4.46618L14.7452 5.84987ZM22.75 8.01078C22.75 6.67666 22.752 5.59091 22.6304 4.76937C22.5067 3.93328 22.2308 3.18689 21.5236 2.71622L20.6925 3.96496C20.8772 4.08787 21.0473 4.31771 21.1466 4.98889C21.248 5.67462 21.25 6.62717 21.25 8.01078H22.75ZM16.7452 5.01278C18.0215 4.47858 18.901 4.11263 19.5727 3.94145C20.2302 3.77391 20.5079 3.84204 20.6925 3.96496L21.5236 2.71622C20.8164 2.24554 20.0213 2.2792 19.2023 2.48791C18.3975 2.69298 17.3967 3.114 16.1661 3.62909L16.7452 5.01278ZM12.75 8.84787C12.75 8.18634 12.751 7.74991 12.7875 7.41416C12.822 7.09662 12.8823 6.94006 12.9594 6.8243L11.7106 5.99325C11.4527 6.38089 11.3455 6.79864 11.2963 7.25218C11.249 7.68752 11.25 8.21893 11.25 8.84787H12.75ZM14.1661 4.46618C13.5859 4.70901 13.0953 4.91324 12.712 5.12494C12.3126 5.34549 11.9686 5.60562 11.7106 5.99325L12.9594 6.8243C13.0364 6.70855 13.1575 6.59242 13.4371 6.438C13.7328 6.27473 14.135 6.10528 14.7452 5.84987L14.1661 4.46618Z" fill="#1C274C"/>
        <path opacity="0.5" d="M7 11V2C7 4.07107 8.75736 5 10 5M7 10.5C7 11.8807 5.88071 13 4.5 13C3.11929 13 2 11.8807 2 10.5C2 9.11929 3.11929 8 4.5 8C5.88071 8 7 9.11929 7 10.5Z" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg> -->
      <!-- playlist icon -->
     
      <!--  -->
      <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" width="60px" height="60px" viewBox="0 -15.59 122.88 122.88" version="1.1" id="Layer_1" style="enable-background:new 0 0 122.88 91.69" xml:space="preserve">

        <g>

        <path class="st0" d="M49.58,0h11.34v3.79c28.37,6.5,31.61,20.12,15.16,41.59c1.75-21.3-0.4-25.87-15.16-26.86v53.86 c0.03,0.29,0.04,0.57,0.04,0.86c0,7-7.35,13.94-16.4,15.51c-9.06,1.57-16.4-2.84-16.4-9.84c0-9.55,13.12-17.84,21.43-14.92L49.58,0 L49.58,0L49.58,0z M72.31,91.69h-0.16c0-1.29-0.48-2.41-1.44-3.38c-0.96-0.96-2.09-1.44-3.38-1.44v-0.16 c1.29,0,2.41-0.48,3.38-1.44c0.96-0.97,1.44-2.09,1.44-3.37h0.16c0,1.29,0.48,2.41,1.44,3.37c0.96,0.96,2.09,1.44,3.38,1.44v0.16 c-1.29,0-2.41,0.48-3.38,1.44C72.79,89.27,72.31,90.4,72.31,91.69L72.31,91.69L72.31,91.69z M92.53,74.61l-0.4-0.03 c0.24-3.22-0.75-6.13-2.97-8.72s-4.94-4.01-8.17-4.25l0.03-0.4c3.22,0.25,6.13-0.75,8.72-2.97c2.59-2.23,4.01-4.95,4.25-8.16 l0.4,0.03c-0.24,3.22,0.75,6.13,2.97,8.72s4.94,4.01,8.17,4.25l-0.03,0.4c-3.22-0.25-6.13,0.75-8.72,2.97 C94.19,68.67,92.78,71.39,92.53,74.61L92.53,74.61L92.53,74.61z M109.33,42.87l-0.5,0.06c-0.52-4.13-2.51-7.55-5.99-10.26 c-3.47-2.71-7.28-3.8-11.42-3.29l-0.06-0.5c4.13-0.51,7.55-2.51,10.26-5.99s3.8-7.29,3.29-11.41l0.5-0.06 c0.52,4.13,2.51,7.55,5.99,10.26c3.48,2.71,7.28,3.8,11.42,3.29l0.06,0.5c-4.13,0.52-7.55,2.51-10.26,5.99 C109.91,34.93,108.82,38.74,109.33,42.87L109.33,42.87L109.33,42.87z M18.45,54.03c-2.3,0-4.17-1.87-4.17-4.17s1.87-4.17,4.17-4.17 h16.63c2.3,0,4.17,1.87,4.17,4.17s-1.87,4.17-4.17,4.17H18.45L18.45,54.03L18.45,54.03z M10.57,33.79c-2.3,0-4.17-1.87-4.17-4.17 c0-2.3,1.87-4.17,4.17-4.17h24.52c2.3,0,4.17,1.87,4.17,4.17c0,2.3-1.87,4.17-4.17,4.17H3.67L10.57,33.79L10.57,33.79z M4.17,13.55 C1.87,13.55,0,11.68,0,9.37c0-2.3,1.87-4.17,4.17-4.17h30.92c2.3,0,4.17,1.87,4.17,4.17c0,2.3-1.87,4.17-4.17,4.17L4.17,13.55 L4.17,13.55L4.17,13.55z"/>

        </g>

      </svg> -->
      <!-- spotify -->
      <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 48 48" version="1.1">
          
          <title>Spotify-color</title>
          <desc>Created with Sketch.</desc>
          <defs>

      </defs>
          <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <g id="Color-" transform="translate(-200.000000, -460.000000)" fill="#00DA5A">
                    <path d="M238.16,481.36 C230.48,476.8 217.64,476.32 210.32,478.6 C209.12,478.96 207.92,478.24 207.56,477.16 C207.2,475.96 207.92,474.76 209,474.4 C217.52,471.88 231.56,472.36 240.44,477.64 C241.52,478.24 241.88,479.68 241.28,480.76 C240.68,481.6 239.24,481.96 238.16,481.36 M237.92,488.08 C237.32,488.92 236.24,489.28 235.4,488.68 C228.92,484.72 219.08,483.52 211.52,485.92 C210.56,486.16 209.48,485.68 209.24,484.72 C209,483.76 209.48,482.68 210.44,482.44 C219.2,479.8 230,481.12 237.44,485.68 C238.16,486.04 238.52,487.24 237.92,488.08 M235.04,494.68 C234.56,495.4 233.72,495.64 233,495.16 C227.36,491.68 220.28,490.96 211.88,492.88 C211.04,493.12 210.32,492.52 210.08,491.8 C209.84,490.96 210.44,490.24 211.16,490 C220.28,487.96 228.2,488.8 234.44,492.64 C235.28,493 235.4,493.96 235.04,494.68 M224,460 C210.8,460 200,470.8 200,484 C200,497.2 210.8,508 224,508 C237.2,508 248,497.2 248,484 C248,470.8 237.32,460 224,460" id="Spotify">

      </path>
              </g>
          </g>
      </svg> -->

      <!-- add plylist -->
      <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" width="60px" height="60px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" version="1.1" xml:space="preserve">

        <g id="play"/>

        <g id="stop"/>

        <g id="pause"/>

        <g id="replay"/>

        <g id="next"/>

        <g id="Layer_8"/>

        <g id="search"/>

        <g id="list"/>

        <g id="love"/>

        <g id="menu"/>

        <g id="add">

        <g>

        <g>

        <path d="M4.743,2.496C4.266,2.223,4,2.45,4,3v26c0,0.55,0.266,0.776,0.743,0.504l22.701-13.008     c0.478-0.273,0.509-0.719,0.031-0.992L4.743,2.496z"/>

        <path d="M4.385,30.619L4.385,30.619C3.718,30.619,3,30.112,3,29V3c0-1.113,0.718-1.62,1.385-1.62c0.28,0,0.567,0.083,0.854,0.248     l22.733,13.008c0.538,0.308,0.846,0.798,0.846,1.347c0,0.559-0.32,1.063-0.878,1.382L5.24,30.371     C4.952,30.536,4.665,30.619,4.385,30.619z M5.003,3.797L5,28.203l21.314-12.212L5.003,3.797z"/>

        </g>

        <g>

        <line x1="28" x2="20" y1="26" y2="26"/>

        <path d="M28,27h-8c-0.552,0-1-0.447-1-1s0.448-1,1-1h8c0.552,0,1,0.447,1,1S28.552,27,28,27z"/>

        </g>

        <g>

        <line x1="24" x2="24" y1="22" y2="30"/>

        <path d="M24,31c-0.552,0-1-0.447-1-1v-8c0-0.553,0.448-1,1-1s1,0.447,1,1v8C25,30.553,24.552,31,24,31z"/>

        </g>

        </g>

        </g>

        <g id="headset"/>

        <g id="random"/>

        <g id="music"/>

        <g id="setting"/>

        <g id="Layer_17"/>

        <g id="Layer_18"/>

        <g id="Layer_19"/>

        <g id="Layer_20"/>

        <g id="Layer_21"/>

        <g id="Layer_22"/>

        <g id="Layer_23"/>

        <g id="Layer_24"/>

        <g id="Layer_25"/>

        <g id="Layer_26"/>

        </svg> -->
      
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
      playlist:[],
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