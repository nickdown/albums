<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ profile.name }}</h1>
                            <p class="text-sm text-gray-500">Joined {{ profile.joined }}</p>
                        </div>
                        <div class="flex gap-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ profile.artists_count }}</div>
                                <div class="text-sm text-gray-500">Artists</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ profile.albums_count }}</div>
                                <div class="text-sm text-gray-500">Albums</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artists Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Artists</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        <div v-for="artist in profile.artists" :key="artist.id" class="flex flex-col items-center">
                            <Link :href="route('artists.show', artist.id)" class="group">
                                <div class="relative">
                                    <img 
                                        :src="artist.spotify_image_url" 
                                        :alt="artist.name"
                                        class="w-24 h-24 rounded-full shadow-lg transition-transform duration-200 group-hover:scale-105"
                                    >
                                </div>
                                <div class="mt-2 text-center">
                                    <h3 class="font-medium group-hover:text-gray-600 transition-colors duration-200">
                                        {{ artist.name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ artist.albums_count }} albums</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Albums Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Albums</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        <div v-for="album in profile.albums" :key="album.id" class="flex flex-col">
                            <Link :href="route('albums.show', album.id)" class="group">
                                <div class="relative">
                                    <img 
                                        :src="album.spotify_image_url" 
                                        :alt="album.name"
                                        class="w-full aspect-square rounded-lg shadow-lg transition-transform duration-200 group-hover:scale-105"
                                    >
                                </div>
                                <div class="mt-2">
                                    <h3 class="font-medium text-center group-hover:text-gray-600 transition-colors duration-200">
                                        {{ album.name }}
                                    </h3>
                                    <Link 
                                        :href="route('artists.show', album.artist.id)"
                                        class="block text-sm text-gray-500 text-center hover:text-gray-900"
                                    >
                                        {{ album.artist.name }}
                                    </Link>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    profile: {
        type: Object,
        required: true
    }
});
</script> 