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
                            <h1 class="text-4xl font-bold mb-4">{{ artist.name }}</h1>
                            <p class="text-gray-600">{{ artist.albums.length }} Albums</p>
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