<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Import Artist from Spotify
            </h2>

            <!-- Error Message -->
            <div v-if="error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ error }}</span>
            </div>

            <!-- Search Input -->
            <div class="mb-4">
                <input
                    type="text"
                    v-model="searchQuery"
                    @input="debounceSearch"
                    placeholder="Search for an artist..."
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                >
            </div>

            <!-- Loading State -->
            <div v-if="searching" class="flex justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
            </div>

            <!-- Results -->
            <div v-else-if="searchResults.length > 0" class="space-y-4">
                <div v-for="artist in searchResults" :key="artist.spotify_id" 
                    class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50"
                >
                    <div class="flex items-center space-x-4">
                        <img 
                            v-if="artist.spotify_image_url"
                            :src="artist.spotify_image_url" 
                            :alt="artist.name"
                            class="w-12 h-12 rounded-full object-cover"
                        >
                        <div v-else class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="font-medium">{{ artist.name }}</span>
                    </div>
                    <button
                        v-if="!artist.already_imported"
                        @click="importArtist(artist)"
                        class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors duration-200"
                        :disabled="importing"
                    >
                        {{ importing ? 'Importing...' : 'Import' }}
                    </button>
                    <span v-else class="text-gray-500">Already imported</span>
                </div>
            </div>

            <!-- No Results -->
            <div v-else-if="searchQuery && !searching" class="text-center py-4 text-gray-500">
                No artists found
            </div>

            <!-- Footer -->
            <div class="mt-6 flex justify-end">
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500"
                    @click="closeModal"
                >
                    Close
                </button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import axios from 'axios';

const props = defineProps({
    show: Boolean
});

const emit = defineEmits(['close']);

const searchQuery = ref('');
const searchResults = ref([]);
const searching = ref(false);
const importing = ref(false);
const error = ref(null);

const closeModal = () => {
    searchQuery.value = '';
    searchResults.value = [];
    error.value = null;
    emit('close');
};

const performSearch = async () => {
    if (!searchQuery.value) {
        searchResults.value = [];
        return;
    }

    searching.value = true;
    error.value = null;
    
    try {
        const response = await axios.post(route('artists.search'), {
            query: searchQuery.value
        });
        
        if (response.data.error) {
            error.value = response.data.error;
            searchResults.value = [];
        } else {
            searchResults.value = response.data.results;
        }
    } catch (e) {
        error.value = 'Failed to search Spotify. Please try again.';
        searchResults.value = [];
        console.error('Search error:', e);
    } finally {
        searching.value = false;
    }
};

const debounceSearch = debounce(() => {
    performSearch();
}, 300);

const importArtist = (artist) => {
    importing.value = true;
    error.value = null;
    
    router.post(route('artists.import'), {
        name: artist.name,
        spotify_id: artist.spotify_id,
        spotify_uri: artist.spotify_uri,
        spotify_image_url: artist.spotify_image_url
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
</script> 