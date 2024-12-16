<template>
    <Head title="Albums" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Albums</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                            <div v-for="album in albums" :key="album.id" class="flex flex-col items-center">
                                <div class="relative group">
                                    <img :src="album.spotify_image_url" :alt="album.name" class="w-full h-auto rounded-lg shadow-lg transition-transform duration-200 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-colors duration-200">
                                                Play
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-center font-medium">{{ album.name }}</h3>
                                <p class="text-sm text-gray-600 text-center">{{ album.artist.name }}</p>
                                <p class="text-xs text-gray-500 text-center">{{ new Date(album.release_date).getFullYear() }}</p>
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
import { Head } from '@inertiajs/vue3';

defineProps({
    albums: {
        type: Array,
        required: true
    }
});
</script> 