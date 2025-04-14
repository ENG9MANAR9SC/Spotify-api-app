<template>
    <div >
        <div class="py-3 px-2">Playlist All : </div>
        <div v-if="Loading" class="m-3">
            <h3>Loading--</h3>
        </div>
        <div v-else class="">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="border border-red-400 p-2">Cover</th>
                        <th class="border border-red-400 p-2">Playlist Name</th>
                        <th class="border border-red-400 p-2">Create At</th>
                        <th class="border border-red-400 p-2">Songs</th>
                        <th class="border border-red-400 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                <!-- <tr v-if="playlists.length == 0">
                    <span> There is no data</span>
                </tr> -->
                <tr v-for="playlist in playlists" :key="playlist?.id">
                    <td class="p-2"><img :src="cover_path" width="40" height="40"/></td>
                    <td class="p-2">{{playlist?.name}}</td>
                    <td class="p-2">{{ formatDate(playlist?.created_at) }}</td>
                    <td class="p-2">1961</td>
                    <td class="p-2">
                        <a :href="route('playlist.edit', { playlistId: playlist.id })" class="text-base rounded-lg bg-red-400 text-black/70 p-2 m-2"> Edit</a>
                        <a :href="route('playlist.delete', { playlistId: playlist.id })" class="text-base rounded-lg bg-red-400 text-black/70 p-2 m-2"> Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
   
export default {
    data() {
        return {
            Loading:false,
            playlists:[],
        };
        
    },
    methods : {
        getPlaylists() {
            this.loading = true;
           try{
                axios.get('/spotify/playlists/get/playlists').then(response => {
                this.playlists = response.data.data;
                console.log('this.playlists');
                console.log(this.playlists);
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
