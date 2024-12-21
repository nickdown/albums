<template>
    <Head :title="profile.name" />

    <AuthenticatedLayout v-if="$page.props.auth.user">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ profile.name }}'s Collection</h2>
            </div>
        </template>

        <UserProfile :profile="profile" />
    </AuthenticatedLayout>

    <GuestProfile v-else :profile="profile" />
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestProfile from './Partials/GuestProfile.vue';
import UserProfile from './Partials/UserProfile.vue';

defineProps({
    profile: {
        type: Object,
        required: true
    }
});
</script> 