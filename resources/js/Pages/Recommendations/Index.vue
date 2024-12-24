<template>
    <Head title="Recommendations" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Recommendations</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash?.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="recommendations.length === 0" class="text-center py-12 text-gray-500">
                            No recommendations yet
                        </div>
                        <div v-else class="space-y-6">
                            <div v-for="recommendation in recommendations" :key="recommendation.id" class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                <Link :href="recommendation.url" class="shrink-0">
                                    <img 
                                        :src="recommendation.image_url" 
                                        :alt="recommendation.name"
                                        :class="{
                                            'rounded-full': recommendation.type === 'artist',
                                            'rounded-lg': recommendation.type === 'album'
                                        }"
                                        class="w-16 h-16 shadow-lg"
                                    >
                                </Link>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-x-4">
                                        <div>
                                            <Link 
                                                :href="recommendation.url"
                                                class="text-lg font-medium hover:text-gray-600"
                                            >
                                                {{ recommendation.name }}
                                            </Link>
                                            <div class="text-sm text-gray-500">
                                                Recommended by {{ recommendation.from_user.name }} · {{ recommendation.created_at }}
                                            </div>
                                            <div v-if="recommendation.note" class="mt-2 text-gray-700">
                                                {{ recommendation.note }}
                                            </div>
                                        </div>
                                        <button
                                            @click="removeRecommendation(recommendation.id)"
                                            class="shrink-0 text-gray-400 hover:text-gray-600"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
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

defineProps({
    recommendations: {
        type: Array,
        required: true
    }
});

const removeRecommendation = (id) => {
    if (confirm('Are you sure you want to remove this recommendation?')) {
        router.delete(route('recommendations.destroy', id), {
            preserveScroll: true
        });
    }
};
</script> 