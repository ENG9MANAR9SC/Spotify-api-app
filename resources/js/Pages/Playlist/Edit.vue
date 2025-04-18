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
          <h3 class="text-bold text-xl">{{ playlist.name }}</h3>
        </div>
        <div>
            <a :href="route('playlists.index')" class="text-base rounded-lg bg-red-500 text-white p-2"> Show Your Playlists</a>
        </div>
      </div>
      <!-- Songs -->
       <div class="mb-6 p-2">
          <div class="flex justify-between mb-4">
            <h3 class="text-base font-bold text-red-900"> Your Songs</h3>
            
          </div>
          
          <!-- filter -->
          <div class="flex my-4 text-sm gap-4">
            <!-- filter by artist -->
            <div class="filter-input">
              <label for="artist" class="px-2">Filter by Artist:</label>
              <select id="artist" v-model="selectedArtist" class="rounded-lg"> 
                <option value="">All Artists</option>
                <option v-for="artist in artists" :key="artist" :value="artist">{{ artist }}</option>
              </select>
            </div>
            <!-- filter by year -->
            <div class="filter-input">
              <label for="year" class="px-2">Filter by Year:</label>
              <select id="year" v-model="selectedYear" class="rounded-lg">
                <option value="">All Years</option>
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>
            <!-- search -->
            <div class="">
              <label for="year" class="px-2">search for Name song / album</label>
              <input class="rounded-lg text-sm text-black/70 mx-2" type="text" v-model="searchKey">
              <button @click="getPlaylist()" class="rounded-md p-2 px-4 text-sm text-white bg-red-500">Search</button> 
            </div> 
          </div>
        <!--  -->
        <div v-if="loading" class="m-3">
            <h3>Loading--</h3>
        </div>                  
        <div v-else class="">
            <div class="" v-if="playlist.songs == 0">
              <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p>You do not have any song in your playlist.</p>
              </div>
            </div>
            <div v-else>
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
                    <tr v-for="songPlaylist in playlist?.songs" :key="songPlaylist?.id">
                        <td class="p-2"><img :src="cover_path" width="40" height="40"/></td>
                        <td class="p-2">{{songPlaylist?.name}}</td>
                        <td class="p-2">{{ formatDate(songPlaylist?.created_at) }}</td>
                        <td class="p-2">{{songPlaylist?.name}}</td>
                        <td class="p-2">{{songPlaylist?.name}}</td>
                        <td class="p-2">
                            <a @click="deleteSong(songPlaylist)" class="text-base rounded-lg cursor-pointer bg-red-500 text-white p-2 m-2"> Delete</a>
                        </td>
                    </tr>
                  </tbody>
              </table>
            </div>
        </div>
      </div>
      <!-- search for songs to add them to playlist-->
      <!-- search section -->
      <div class="w-full ">
        <div class="flex gap-2 items-start my-6"> 
          <!-- title -->
          <h2 class="text-base font-bold text-red-900">Browse Songs From Spotify</h2>
          <!-- search input -->
          <input class="rounded-lg text-base text-black/70" type="text" v-model="searchQuery">
          <button @click="searchSpotifySongs" class="rounded-lg p-1 text-base text-red-500 bg-white border-2 border-red-500 my-auto px-4 mx-2 border-solid-1">Search</button>
        </div>
        <!-- search result -->
        <ul v-if="songs.length > 0" class="flex flex-wrap gap-8 justify-content-between ">
            <li v-for="song in songs" :key="song.id" >
                <div class="flex flex-col items-center bg-red-50 rounded-lg p-2">
                    <h3 class="p-2 text-base text-wrap">{{ song.name }} </h3>
                    <div class="text-base text-wrap">{{ song.album.name }} </div><span class="text-sm">{{ song.release_year }}</span>
                    <img class="rounded-lg w-48 h-48 object-cover p-2 items-center" :src="song.album.images[0].url" height="20px" style="width: -webkit-fill-available;"/>

                    <audio controls :src="song.preview_url" v-if="song.preview_url"></audio>
                    <div class="flex gap-2 my-3">
                      <button v-if="song.external_urls && song.external_urls.spotify" @click="openInSpotify" class="text-base rounded-lg text-white bg-red-500 p-2">Open on Spotify</button>
                      <button @click="addToPlaylist(song)" class="text-base rounded-lg text-white bg-red-500 p-2">Add to Playlist</button>
                    </div>
                </div>
            </li>
        </ul>
        
        <div v-else-if="loading && searchQuery">Loading songs...</div>
        
        <div class="flex justify-center my-4" v-if="songs && totalSongs> perPage">
          <button
            :disabled="currentPage=== 1"
            @click="searchSpotifySongs(searchQuery, Number(currentPage)- 1)"
            class="text-sm text-red-500 bg-white "
          >
            <<
          </button>

          <span class="mx-2 text-red-500">
            <!-- {{ currentPage}} / {{ Math.ceil(totalSongs / perPage) }} -->
            {{ currentPage}} 
          </span>
          
          <button
            :disabled="currentPage=== Math.ceil(totalSongs / perPage)"
            @click="searchSpotifySongs(searchQuery, Number(currentPage) + 1)"
            class="text-sm text-red-500 bg-white"
          >
            >>
          </button>
        </div>

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
      perPage:0,
      totalSongs:0,
      currentPage:0,
      loading: false,
      playlist:[
      ],
      isModalOpen:false,
      searchKey:'',
      artists:[],
      selectedArtist:'',
      years :[],
      selectedYear:'',
    };
  },
  methods: {
    searchSpotifySongs(query, currentPage = 1) { 
        try {
            this.loading = true;
            axios.get(`/spotify/songs/search?q=${this.searchQuery}&page=${currentPage}`)
            .then(response => {
                this.songs       = response.data.data;
                this.per_page    = response.data.per_page;
                this.totalSongs  = response.data.total;
                this.currentPage = response.data.current_page;
            })
            .catch(error => {
                console.error('Error searching songs:', error);
                this.error = 'Failed to fetch songs. Please try again.';
                this.loading = false;
            });
        } finally {
            this.loading = false;
        }
    },
    getPlaylist() {
      try {
        axios.get(`/spotify/playlists/show/${this.playlistId}?search_key=${this.searchKey}&artist_key=${this.selectedArtist}&year_key=${this.selectedYear}`)
        .then(response => {
          this.playlist = response.data.playlist;
          this.artists  = response.data.artists;
          this.years    = response.data.years;
        })
          
        } catch (error) {
          console.error('Error deleting playlist:', error);
        }
      },
    addToPlaylist(song) {
      try {
        this.loading = true;
        console.log(song.id);
        axios.post(`/spotify/playlists/${this.playlistId}/songs/add`,{
          selected_song_id : song.id,
        })
        .then(response => {
          console.log(response);
          this.playlist = response.data;
        }).catch(error => {
          console.error('Error adding song to playlist:', error);
          this.error = 'Failed to add song to playlist. Please try again.';
        });}
         finally {
          this.loading = false;
          window.location.href = `/spotify/playlist/edit/${this.playlistId}`;
        }
      },
    openInSpotify(url) {
        window.open(url, '_blank');
      },
    deleteSong(song) {
      try {           
        if (confirm('Are you sure you want to delete this Song?')) {
            axios.post(`/spotify/playlists/${this.playlistId}/songs/${song.id}/delete`)
                .then(() => {
                    console.log('Error deleting song:');
                })
                .catch(error => {
                    console.error('Error deleting song:', error);

                });
            }
        } finally {
            this.loading = false;
            window.location.href = 'index';
        }
    },
 
  },
  mounted() {
    this.playlistId = window.location.pathname.split('/').pop(); 
    this.getPlaylist();
  }
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
