<template>
    <Head :title="album.name" />

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
                        <template v-if="canLogin">
                            <Link
                                :href="route('login')"
                                class="text-gray-600 hover:text-gray-900"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                            >
                                Get started
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

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
                                <div class="text-xl text-gray-600 mb-4">
                                    {{ album.artist.name }}
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-600">Released: {{ formatDate(album.release_date) }}</p>
                                </div>

                                <!-- Registration Prompt -->
                                <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-2">Start Your Collection</h3>
                                    <p class="text-gray-600 mb-4">
                                        Join Albums to add this and other music to your collection, discover new albums through friends, and share your musical journey.
                                    </p>
                                    <div class="flex gap-4">
                                        <Link
                                            v-if="canRegister"
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

                                <!-- Community Info -->
                                <div class="mt-8">
                                    <h3 class="text-sm font-medium text-gray-500">In Collections</h3>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span v-for="user in album.users" :key="user.id" class="inline-flex items-center rounded-full bg-gray-100 px-3 py-0.5 text-sm font-medium text-gray-800">
                                            {{ user.name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    album: {
        type: Object,
        required: true
    },
    canLogin: {
        type: Boolean,
        default: false
    },
    canRegister: {
        type: Boolean,
        default: false
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