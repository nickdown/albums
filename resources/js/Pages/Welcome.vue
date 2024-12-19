<template>
    <Head title="Welcome to Albums" />

    <div class="min-h-screen bg-gray-100">
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
                                v-if="$page.props.auth?.user"
                                :href="route('dashboard')"
                                class="text-gray-600 hover:text-gray-900"
                            >
                                Dashboard
                            </Link>
                            <template v-else>
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
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden">
            <div class="mx-auto max-w-7xl px-6 pb-24 pt-16 sm:pb-32 lg:px-8">
                <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                    <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Share your music collection with friends
                        </h1>
                        <p class="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">
                            Albums is a social network for music lovers. Build your collection, discover new music through friends, and share your favorite albums with the world.
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <template v-if="$page.props.auth?.user">
                                <Link
                                    :href="route('albums')"
                                    class="rounded-md bg-gray-800 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                                >
                                    View Your Collection
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="rounded-md bg-gray-800 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                                >
                                    Start your collection
                                </Link>
                                <Link
                                    :href="route('login')"
                                    class="text-sm font-semibold leading-6 text-gray-900"
                                >
                                    Log in <span aria-hidden="true">→</span>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Albums Section -->
        <div class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Recently Added Albums</h2>
                    <p class="mt-2 text-lg leading-8 text-gray-600">
                        See what the community is listening to
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    <Link 
                        v-for="album in recentAlbums" 
                        :key="album.id" 
                        :href="route('albums.preview', album.id)"
                        class="flex flex-col group"
                    >
                        <div class="relative">
                            <img 
                                :src="album.image_url" 
                                :alt="album.name"
                                class="aspect-square w-full rounded-lg object-cover shadow-lg transition-transform duration-200 group-hover:scale-105"
                            >
                        </div>
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                            {{ album.name }}
                        </h3>
                        <p class="text-sm text-gray-600">by {{ album.artist_name }}</p>
                        <p class="mt-1 text-sm text-gray-500">
                            Added by {{ album.added_by }}
                        </p>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    recentAlbums: {
        type: Array,
        default: () => [],
    },
});
</script>
