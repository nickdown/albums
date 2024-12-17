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
                            <div v-for="artist in artists" :key="artist.id" class="flex flex-col items-center">
                                <div class="relative group">
                                    <Link :href="route('artists.show', artist.id)">
                                        <img :src="artist.image_url" :alt="artist.name" class="w-32 h-32 rounded-full shadow-lg transition-transform duration-200 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-200 rounded-full flex items-center justify-center">
                                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-colors duration-200">
                                                    Play
                                                </button>
                                            </div>
                                        </div>
                                    </Link>
                                </div>
                                <Link 
                                    :href="route('artists.show', artist.id)"
                                    class="mt-4 text-xl font-medium hover:text-gray-600 transition-colors duration-200"
                                >
                                    {{ artist.name }}
                                </Link>
                                <p class="text-sm text-gray-500">{{ artist.albums_count }} albums</p>
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
import { Link } from '@inertiajs/vue3';

defineProps({
    artists: {
        type: Array,
        required: true
    }
});
</script> 