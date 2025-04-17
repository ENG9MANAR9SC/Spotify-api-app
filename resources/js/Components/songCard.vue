<template class="b">
    <div class=" py-8 px-2">
      <div class="py-6 px-3 ">
        <div class="flex justify-between mb-6">
          <h2 class="text-xl font-bold font-semibold text-red-900 mb-4">Trends Music</h2>
          <button
            @click="createNewPlaylist()"
            class="rounded-md p-2 text-sm text-white bg-red-500">
            Create New Playlist 
          </button>
        </div>
        <Card
            class="overflow-hidden rounded-lg bg-white/5 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)]
            ring-1 ring-white/10 transition duration-300 hover:border-white/20 hover:shadow-lg
            dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:border-zinc-700">
            <CardHeader>
                <CardTitle class="text-gray-200">
                    <div v-if="loading" class="w-48 h-6 bg-black/20" ></div>
                    <div v-else class="text-black mb-4">Discover our Songs</div>
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div v-if="loading" class="flex flex-wrap gap-6">
                    <div v-for="i in 3" :key="i" class="space-y-2 animate-pulse">
                        <div class="w-48 h-8 bg-black/20 rounded-lg" ></div>
                        <div class="w-48 h-4 bg-black/20 rounded-lg" ></div>
                        <div class="w-48 h-4 bg-black/20 rounded-lg" ></div>
                        <div class="w-32 h-8 bg-black/20 rounded-lg" ></div>
                    </div>
                </div>
                <div v-else-if="songs.length > 0" class="flex flex-wrap gap-8 justify-start">
                    <div v-for="song in songs" :key="song.id" class="space-y-2 gap-2 justify-center">
                        <div class="flex flex-col bg-blue-50 gap-3 p-3 rounded-lg">
                          <h3 class="text-base font-semibold text-gray-900">{{ song.name }}</h3>
                          <div class="text-sm text-gray-900">{{ song.album.name }}</div>
                          <span class="text-xs text-gray-900">{{ song.release_year }}</span>
                          <img
                              class="rounded-lg w-48 h-48 object-cover p-2"
                              :src="song.album.images[0].url"
                              :alt="song.album.name"
                              style="width: -webkit-fill-available;"
                          />
                          <audio v-if="song.preview_url" controls :src="song.preview_url" class="w-48">
                              Your browser does not support the audio element.
                          </audio>
                          <!-- <p v-else class="text-sm text-gray-500">No preview available</p> -->
                          <div class="flex gap-2 text-sm">  
                              <button v-if="song.external_urls && song.external_urls.spotify" @click="openInSpotify" class="rounded-lg text-white bg-red-500 p-2">Open on Spotify</button>
                              <Button
                                  @click="addToPlaylist(song)"
                                  class="bg-red-500 p-2 text-white rounded-lg"
                              >
                                  Discover More Songs
                              </Button>
                          </div>
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-400">No songs found.</p>
            </CardContent>
        </Card>
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
      newPlaylist: [],
      loading: false,
    };
  },
  methods: {
     getSpotifySongs() {
      this.loading = true;
      try {
        axios.get(`/spotify/get/tracks`)
        .then(response => {
          this.songs = response.data;
        console.log(this.songs);
        })
        .catch(error => {
          console.error('Error get songs:', error);
          this.error = 'Failed to fetch songs. Please try again.';
        });
      } finally {
        this.loading = false;
      }
    },

    createNewPlaylist() {
       this.loading = true;
       try {
        axios.post("spotify/playlists/edit")
        .then(response => {
          this.newPlaylist = response.data;
        }).catch(error => {
          console.error('Error creating play,ist:', error);
          this.error = 'Failed to create playlist. Please try again.';
        })
       } finally {
        this.loading = false;
        window.location.href = 'spotify/playlist/create';
        
       }

    },

    addToPlaylist(song) {
     // add logic here
      console.log('Adding song to playlist:', song);
    },
  },
  mounted() {
    this.getSpotifySongs();
  }

};
</script>


