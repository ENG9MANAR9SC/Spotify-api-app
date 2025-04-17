<template>
    <div class="px-6">
        <div class="flex justify-between gap-2 py-4">   
            <h3 class="py-3 px-2">Playlist All : </h3>
            <a :href="route('home')" class="text-base rounded-lg bg-red-500 text-white py-2 px-4"> Go Home</a>
        </div>
        
        <div v-if="loading" class="m-3">
            <h3>Loading--</h3>
        </div>
        <div v-else class="">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="border border-red-400 p-2">Cover</th>
                        <th class="border border-red-400 p-2">Playlist Name</th>
                        <!-- <th class="border border-red-400 p-2">Created At</th> -->
                        <th class="border border-red-400 p-2">Songs</th>
                        <th class="border border-red-400 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                      
                <tr v-for="playlist in playlists" :key="playlist?.id">
                    <td class="p-2"><img :src="cover_path" width="40" height="40"/></td>
                    <td class="p-2">{{playlist?.name}}</td>
                    <!-- <td class="p-2">{{ formatDate(playlist?.created_at) }}</td> -->
                    <td class="p-2">1961</td>
                    <td class="p-2">
                        <a :href="route('playlist.edit', { playlistId: playlist.id })" class="text-base rounded-lg bg-red-500 text-white p-2 m-2"> Listen</a>
                        <a @click="deletePlaylist(playlist.id)" class="text-base rounded-lg bg-red-500 text-white p-2 m-2 cursor-pointer"> Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-center my-4" v-if="playlists && totalPlaylists">
                <button
                    :disabled="currentPage=== 1"
                    @click="getPlaylists(Number(currentPage) - 1)"
                    class="text-sm text-red-500 bg-white"
                >
                    <<
                </button>

                <span class="mx-2 text-red-500">
                   
                    {{ currentPage}} 
                </span>
                
                <button
                    :disabled="currentPage=== Math.ceil(totalSongs / perPage)"
                    @click="getPlaylists(Number(currentPage) + 1)"
                    class="text-sm text-red-500 bg-white"
                >
                    >>
                </button>
            </div>  
        </div>
    </div>
</template>


<script>
   
export default {
    data() {
        return {
            loading:false,
            playlists:[],
            currentPage:1,
            totalPlaylists:0,
        };
        
    },
    methods : {
        getPlaylists(page) {
            this.loading = true;
           try{
                axios.get(`/spotify/playlists/get/playlists?page=${Number(this.page)}`).then(response => {
                this.playlists      = response.data.data;
                this.currentPage    = response.data.current_page;
                this.totalPlaylists = response.data.total;
            }).catch(
                error => {
                console.error('Error get Playlists:', error);
                this.error = 'Failed to fetch playlists. Please try again.';
                }
            );
           } finally{
            this.loading = false;
           }
        },
        deletePlaylist (playlistId) {
            try {           
                if (confirm('Are you sure you want to delete this playlist?')) {
                    axios.post(`/spotify/playlist/delete/${playlistId}`)
                        .then(() => {
                            console.log('Error deleting playlist:');
                        })
                        .catch(error => {
                            console.error('Error deleting playlist:', error);

                        });
                    }
                } finally {
                    this.loading = false;
                    window.location.href = 'index';
                }
        },
    },
    setup() {
        
    },
    mounted() {
        this.getPlaylists();
    },
}
</script>

<script setup>
    const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
    return new Intl.DateTimeFormat('de-DE', options).format(date);
    };
</script>
