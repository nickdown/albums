<template>
    <Head title="Albums" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Albums</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash?.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <!-- My Albums Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">My Albums</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            <div v-for="album in myAlbums" :key="album.id" class="flex flex-col">
                                <div class="relative group">
                                    <Link :href="route('albums.show', album.id)">
                                        <img :src="album.spotify_image_url" :alt="album.name" class="w-full h-auto rounded-lg shadow-lg transition-transform duration-200 group-hover:scale-105">
                                    </Link>
                                </div>
                                <Link 
                                    :href="route('albums.show', album.id)"
                                    class="mt-2 text-center font-medium hover:text-gray-600 transition-colors duration-200"
                                >
                                    {{ album.name }}
                                </Link>
                                <p class="text-sm text-gray-600 text-center">{{ album.artist.name }}</p>
                                <p class="text-xs text-gray-500 text-center">{{ new Date(album.release_date).getFullYear() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Albums Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">Other Albums You Might Like</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            <div v-for="album in otherAlbums" :key="album.id" class="flex flex-col">
                                <div class="relative group">
                                    <button 
                                        @click="quickAddAlbum(album)"
                                        class="block relative w-full"
                                        :disabled="importing === album.id"
                                    >
                                        <img 
                                            :src="album.spotify_image_url" 
                                            :alt="album.name" 
                                            class="w-full h-auto rounded-lg shadow-lg transition-all duration-200 group-hover:opacity-75"
                                        >
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <span class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center text-2xl font-medium shadow-lg">
                                                {{ importing === album.id ? '...' : '+' }}
                                            </span>
                                        </div>
                                    </button>
                                </div>
                                <h3 class="mt-2 text-center font-medium">{{ album.name }}</h3>
                                <p class="text-sm text-gray-600 text-center">{{ album.artist.name }}</p>
                                <p class="text-xs text-gray-500 text-center">
                                    Added by {{ album.users[0].name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    myAlbums: {
        type: Array,
        required: true
    },
    otherAlbums: {
        type: Array,
        required: true
    }
});

const importing = ref(null);

const quickAddAlbum = (album) => {
    importing.value = album.id;
    
    router.post(route('albums.import'), {
        albums: [{
            name: album.name,
            artist_id: album.artist.id,
            spotify_id: album.spotify_id,
            spotify_uri: album.spotify_uri,
            spotify_image_url: album.spotify_image_url,
            release_date: album.release_date
        }]
    }, {
        preserveScroll: true,
        onFinish: () => {
            importing.value = null;
        }
    });
};
</script> 