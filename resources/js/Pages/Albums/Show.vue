<template>
    <Head :title="album.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ album.name }}</h2>
                <Link :href="route('albums')" class="text-sm text-gray-600 hover:text-gray-900">← Back to Albums</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Album Cover -->
                            <div class="w-full md:w-1/3">
                                <img :src="album.spotify_image_url" :alt="album.name" class="w-full rounded-lg shadow-lg">
                            </div>

                            <!-- Album Details -->
                            <div class="w-full md:w-2/3">
                                <h1 class="text-3xl font-bold mb-2">{{ album.name }}</h1>
                                <Link 
                                    :href="route('artists.show', album.artist.id)" 
                                    class="text-xl text-gray-600 hover:text-gray-900 mb-4 block"
                                >
                                    {{ album.artist.name }}
                                </Link>
                                <div class="mt-4">
                                    <p class="text-gray-600">Released: {{ formatDate(album.release_date) }}</p>
                                </div>
                                <div class="mt-6">
                                    <button class="bg-green-500 text-white px-6 py-3 rounded-full hover:bg-green-600 transition-colors duration-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        Play Album
                                    </button>
                                </div>
                                <div class="mt-6">
                                    <a :href="album.spotify_uri" target="_blank" class="text-green-500 hover:text-green-600 flex items-center gap-2">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                                        </svg>
                                        Open in Spotify
                                    </a>
                                </div>
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
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    album: {
        type: Object,
        required: true
    }
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script> 