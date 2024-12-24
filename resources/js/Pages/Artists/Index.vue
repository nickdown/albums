<template>
    <Head title="Artists" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Artists</h2>
                <button
                    @click="showImportModal = true"
                    class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors duration-200 flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Artist
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash?.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <!-- My Artists Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">My Artists</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <div v-for="artist in myArtists" :key="artist.id" class="flex flex-col items-center text-center">
                                <div class="relative group w-24 h-24">
                                    <Link :href="route('artists.show', artist.id)">
                                        <img :src="artist.spotify_image_url" :alt="artist.name" class="w-full h-full rounded-full shadow-lg transition-transform duration-200 group-hover:scale-105 object-cover">
                                    </Link>
                                </div>
                                <Link 
                                    :href="route('artists.show', artist.id)"
                                    class="mt-3 text-base font-medium hover:text-gray-600 transition-colors duration-200"
                                >
                                    {{ artist.name }}
                                </Link>
                                <p class="text-sm text-gray-500">{{ artist.albums_count }} albums</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Artists Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">Artists Your Friends Like</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <div v-for="artist in otherArtists" :key="artist.id" class="flex flex-col items-center text-center">
                                <div class="relative group w-24 h-24">
                                    <Link 
                                        :href="route('artists.show', artist.id)"
                                        class="block relative w-full h-full"
                                    >
                                        <img 
                                            :src="artist.spotify_image_url" 
                                            :alt="artist.name" 
                                            class="w-full h-full rounded-full shadow-lg transition-all duration-200 group-hover:opacity-75 object-cover"
                                        >
                                    </Link>
                                </div>
                                <Link 
                                    :href="route('artists.show', artist.id)"
                                    class="mt-3 text-base font-medium hover:text-gray-600 transition-colors duration-200"
                                >
                                    {{ artist.name }}
                                </Link>
                                <p class="text-sm text-gray-500">
                                    Added by {{ artist.users[0].name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ImportArtistModal
            :show="showImportModal"
            @close="showImportModal = false"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ImportArtistModal from '@/Components/ImportArtistModal.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    myArtists: {
        type: Array,
        required: true
    },
    otherArtists: {
        type: Array,
        required: true
    }
});

const showImportModal = ref(false);
const importing = ref(null);

const quickAddArtist = (artist) => {
    importing.value = artist.id;
    
    router.post(route('artists.import'), {
        spotify_id: artist.spotify_id
    }, {
        preserveScroll: true,
        onFinish: () => {
            importing.value = null;
        }
    });
};
</script> 