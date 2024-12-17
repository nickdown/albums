<template>
    <Head :title="artist.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ artist.name }}</h2>
                <Link :href="route('artists')" class="text-sm text-gray-600 hover:text-gray-900">← Back to Artists</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Artist Header -->
                        <div class="flex flex-col items-center mb-8">
                            <div class="relative group mb-6">
                                <img 
                                    :src="artist.spotify_image_url" 
                                    :alt="artist.name"
                                    class="w-48 h-48 rounded-full shadow-lg transition-transform duration-200 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-200 rounded-full flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-colors duration-200">
                                            Play
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <h1 class="text-4xl font-bold mb-4">{{ artist.name }}</h1>
                            <p class="text-gray-600 mb-4">{{ artist.albums.length }} Albums</p>
                            <a :href="artist.spotify_uri" target="_blank" class="text-green-500 hover:text-green-600 flex items-center gap-2">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                                </svg>
                                Open in Spotify
                            </a>
                        </div>

                        <!-- Albums Grid -->
                        <div class="mt-8">
                            <h2 class="text-2xl font-semibold mb-4">Albums</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                                <div v-for="album in artist.albums" :key="album.id" class="flex flex-col">
                                    <Link :href="route('albums.show', album.id)" class="group">
                                        <div class="relative">
                                            <img 
                                                :src="album.spotify_image_url" 
                                                :alt="album.name"
                                                class="w-full aspect-square object-cover rounded-lg shadow-lg transition-transform duration-200 group-hover:scale-105"
                                            >
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-colors duration-200">
                                                        Play
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="mt-2 text-center font-medium group-hover:text-gray-600 transition-colors duration-200">
                                            {{ album.name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 text-center">
                                            {{ new Date(album.release_date).getFullYear() }}
                                        </p>
                                    </Link>
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
    artist: {
        type: Object,
        required: true
    }
});
</script> 