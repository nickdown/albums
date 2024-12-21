<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <div class="flex items-center">
                        <ApplicationLogo class="w-8 h-8 text-gray-800" />
                        <span class="ml-3 text-xl font-semibold text-gray-800">Albums</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link
                            :href="route('login')"
                            class="text-gray-600 hover:text-gray-900"
                        >
                            Log in
                        </Link>

                        <Link
                            :href="route('register')"
                            class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                        >
                            Get started
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

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

                <!-- Registration Prompt -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-900">Join Albums</h2>
                            <p class="mt-2 text-gray-600">
                                Create an account to start your own collection and connect with other music lovers.
                            </p>
                            <div class="mt-6 flex justify-center gap-4">
                                <Link
                                    :href="route('register')"
                                    class="rounded-md bg-gray-800 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                                >
                                    Create Account
                                </Link>
                                <Link
                                    :href="route('login')"
                                    class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    Sign In
                                </Link>
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
                                <div class="relative">
                                    <img 
                                        :src="artist.spotify_image_url" 
                                        :alt="artist.name"
                                        class="w-24 h-24 rounded-full shadow-lg"
                                    >
                                </div>
                                <div class="mt-2 text-center">
                                    <h3 class="font-medium">{{ artist.name }}</h3>
                                    <p class="text-sm text-gray-500">{{ artist.albums_count }} albums</p>
                                </div>
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
                                <Link :href="route('albums.preview', album.id)" class="group">
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
                                        <p class="text-sm text-gray-500 text-center">
                                            {{ album.artist.name }}
                                        </p>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    profile: {
        type: Object,
        required: true
    }
});
</script> 