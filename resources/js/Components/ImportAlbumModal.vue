<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Add Albums for {{ artistName }}
            </h2>

            <!-- Error Message -->
            <div v-if="error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ error }}</span>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
            </div>

            <!-- Results -->
            <div v-else-if="albums.length > 0" class="space-y-4 max-h-[60vh] overflow-y-auto">
                <div v-for="album in sortedAlbums" :key="album.spotify_id" 
                    class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50"
                    :class="{ 'bg-gray-50': selectedAlbums.includes(album.spotify_id) }"
                >
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="flex-shrink-0">
                            <img 
                                v-if="album.spotify_image_url"
                                :src="album.spotify_image_url" 
                                :alt="album.name"
                                class="w-16 h-16 rounded-lg object-cover"
                            >
                            <div v-else class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium truncate">{{ album.name }}</div>
                            <div class="text-sm text-gray-500">{{ formatDate(album.release_date) }}</div>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <template v-if="!album.already_imported">
                            <button
                                @click="toggleAlbum(album.spotify_id)"
                                class="px-4 py-2 rounded-full transition-colors duration-200"
                                :class="selectedAlbums.includes(album.spotify_id) 
                                    ? 'bg-green-500 text-white hover:bg-green-600' 
                                    : 'border border-green-500 text-green-500 hover:bg-green-50'"
                            >
                                {{ selectedAlbums.includes(album.spotify_id) ? 'Selected' : 'Select' }}
                            </button>
                        </template>
                        <span v-else class="text-gray-500">Already in collection</span>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-else-if="!loading" class="text-center py-4 text-gray-500">
                No albums found
            </div>

            <!-- Footer -->
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    {{ selectedAlbums.length }} albums selected
                </div>
                <div class="flex gap-4">
                    <button
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500"
                        @click="closeModal"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        :disabled="selectedAlbums.length === 0 || importing"
                        @click="importSelected"
                    >
                        {{ importing ? 'Adding...' : `Add ${selectedAlbums.length} Albums` }}
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    show: Boolean,
    artistId: {
        type: Number,
        required: true
    },
    artistName: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['close']);

const albums = ref([]);
const selectedAlbums = ref([]);
const loading = ref(false);
const importing = ref(false);
const error = ref(null);

const sortedAlbums = computed(() => {
    return [...albums.value].sort((a, b) => new Date(b.release_date) - new Date(a.release_date));
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const toggleAlbum = (spotifyId) => {
    const index = selectedAlbums.value.indexOf(spotifyId);
    if (index === -1) {
        selectedAlbums.value.push(spotifyId);
    } else {
        selectedAlbums.value.splice(index, 1);
    }
};

const fetchAlbums = async () => {
    loading.value = true;
    error.value = null;
    
    try {
        const response = await axios.post(route('albums.search'), {
            artist_id: props.artistId
        });
        
        if (response.data.error) {
            error.value = response.data.error;
            albums.value = [];
        } else {
            albums.value = response.data.results;
        }
    } catch (e) {
        error.value = 'Failed to fetch albums from Spotify. Please try again.';
        albums.value = [];
        console.error('Fetch error:', e);
    } finally {
        loading.value = false;
    }
};

const importSelected = () => {
    if (selectedAlbums.value.length === 0) return;
    
    importing.value = true;
    error.value = null;
    
    const selectedAlbumsData = albums.value
        .filter(album => selectedAlbums.value.includes(album.spotify_id))
        .map(album => ({
            name: album.name,
            artist_id: props.artistId,
            spotify_id: album.spotify_id,
            spotify_uri: album.spotify_uri,
            spotify_image_url: album.spotify_image_url,
            release_date: album.release_date
        }));
    
    router.post(route('albums.import'), {
        albums: selectedAlbumsData
    }, {
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            error.value = Object.values(errors)[0];
        },
        onFinish: () => {
            importing.value = false;
        }
    });
};

const closeModal = () => {
    albums.value = [];
    selectedAlbums.value = [];
    error.value = null;
    emit('close');
};

watch(() => props.show, (newVal) => {
    if (newVal) {
        fetchAlbums();
    }
});
</script> 