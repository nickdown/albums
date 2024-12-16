<template>
    <Head title="Artists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Artists
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <div v-for="artist in artists" :key="artist.id" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold mb-2">{{ artist.name }}</h3>
                                <a 
                                    :href="'https://open.spotify.com/artist/' + artist.spotify_id" 
                                    target="_blank"
                                    class="text-sm text-green-600 hover:text-green-800"
                                >
                                    View on Spotify
                                </a>
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
    artists: {
        type: Array,
        required: true
    }
});
</script> 