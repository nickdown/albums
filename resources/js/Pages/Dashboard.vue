<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">Recent Activity</h2>
                        
                        <div v-if="recentActivity.length === 0" class="text-gray-500 text-center py-8">
                            No recent activity to show
                        </div>

                        <div v-else class="space-y-6">
                            <div v-for="activity in recentActivity" :key="activity.type + activity.id" class="flex items-center gap-6">
                                <!-- Activity Image -->
                                <div class="flex-shrink-0">
                                    <button 
                                        v-if="!activity.already_added"
                                        @click="quickAdd(activity)"
                                        class="relative group"
                                        :disabled="importing === activity.id"
                                    >
                                        <img 
                                            :src="activity.image_url" 
                                            :alt="activity.name"
                                            :class="{
                                                'w-16 h-16 rounded-full': activity.type === 'artist',
                                                'w-16 h-16 rounded-lg': activity.type === 'album'
                                            }"
                                            class="shadow-lg transition-all duration-200 group-hover:opacity-75"
                                        >
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <span class="bg-green-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-xl font-medium shadow-lg">
                                                {{ importing === activity.id ? '...' : '+' }}
                                            </span>
                                        </div>
                                    </button>
                                    <Link 
                                        v-else 
                                        :href="route(activity.type + 's.show', activity.id)"
                                        class="block"
                                    >
                                        <img 
                                            :src="activity.image_url" 
                                            :alt="activity.name"
                                            :class="{
                                                'w-16 h-16 rounded-full': activity.type === 'artist',
                                                'w-16 h-16 rounded-lg': activity.type === 'album'
                                            }"
                                            class="shadow-lg"
                                        >
                                    </Link>
                                </div>

                                <!-- Activity Details -->
                                <div class="flex-grow">
                                    <div class="font-medium">
                                        <Link 
                                            :href="route('users.show', activity.user_id)"
                                            class="text-gray-900 hover:text-gray-600"
                                        >
                                            {{ activity.user_name }}
                                        </Link>
                                        added 
                                        <span v-if="activity.type === 'album'">
                                            the album "{{ activity.name }}" by {{ activity.artist_name }}
                                        </span>
                                        <span v-else>
                                            the artist {{ activity.name }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ formatDate(activity.added_at) }}
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div v-if="!activity.already_added" class="flex-shrink-0">
                                    <button
                                        @click="quickAdd(activity)"
                                        class="text-green-600 hover:text-green-700 text-sm font-medium"
                                        :disabled="importing === activity.id"
                                    >
                                        {{ importing === activity.id ? 'Adding...' : (activity.type === 'artist' ? 'Add Artist' : 'Add Album') }}
                                    </button>
                                </div>
                                <div v-else class="flex-shrink-0">
                                    <Link
                                        :href="route(activity.type + 's.show', activity.id)"
                                        class="text-gray-600 hover:text-gray-700 text-sm font-medium"
                                    >
                                        View Details
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
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    recentActivity: {
        type: Array,
        required: true
    }
});

const importing = ref(null);

const formatDate = (isoString) => {
    const date = new Date(isoString);
    const now = new Date();
    const diffInHours = (now - date) / (1000 * 60 * 60);

    // If less than 24 hours ago, show relative time
    if (diffInHours < 24) {
        if (diffInHours < 1) {
            const minutes = Math.floor((now - date) / (1000 * 60));
            return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
        }
        const hours = Math.floor(diffInHours);
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
    }

    // Otherwise show the full date
    return date.toLocaleString('en-US', {
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
};

const quickAdd = (activity) => {
    importing.value = activity.id;
    
    if (activity.type === 'artist') {
        router.post(route('artists.import'), {
            spotify_id: activity.spotify_id
        }, {
            preserveScroll: true,
            onFinish: () => {
                importing.value = null;
            }
        });
    } else {
        router.post(route('albums.import'), {
            albums: [{
                spotify_id: activity.spotify_id,
                artist_id: activity.artist_id
            }]
        }, {
            preserveScroll: true,
            onFinish: () => {
                importing.value = null;
            }
        });
    }
};
</script>
