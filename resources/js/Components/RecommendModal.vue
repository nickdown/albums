<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Recommend {{ type === 'artist' ? 'Artist' : 'Album' }}
            </h2>

            <div class="mt-6">
                <div class="flex items-center gap-4 mb-6">
                    <img
                        :src="item.spotify_image_url"
                        :alt="item.name"
                        :class="{
                            'rounded-full': type === 'artist',
                            'rounded-lg': type === 'album'
                        }"
                        class="w-16 h-16 shadow-lg"
                    >
                    <div>
                        <div class="font-medium">{{ item.name }}</div>
                        <div v-if="type === 'album'" class="text-sm text-gray-500">
                            {{ item.artist.name }}
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Recommend to
                    </label>
                    <select
                        v-model="form.to_user_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                        <option value="">Select a user</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Add a note (optional)
                    </label>
                    <textarea
                        v-model="form.note"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                        placeholder="Why are you recommending this?"
                    ></textarea>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        @click="$emit('close')"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700"
                        :disabled="!form.to_user_id"
                        @click="submit"
                    >
                        Send Recommendation
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    show: Boolean,
    type: {
        type: String,
        required: true,
        validator: (value) => ['artist', 'album'].includes(value)
    },
    item: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['close']);

const form = ref({
    to_user_id: '',
    note: '',
    recommendable_type: props.type === 'artist' ? 'App\\Models\\Artist' : 'App\\Models\\Album',
    recommendable_id: props.item.id
});

const resetForm = () => {
    form.value = {
        to_user_id: '',
        note: '',
        recommendable_type: props.type === 'artist' ? 'App\\Models\\Artist' : 'App\\Models\\Album',
        recommendable_id: props.item.id
    };
};

const submit = () => {
    console.log('Submitting recommendation:', form.value);
    router.post(route('recommendations.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Recommendation submitted successfully');
            resetForm();
            emit('close');
        },
        onError: (errors) => {
            console.error('Failed to submit recommendation:', errors);
        }
    });
};

// Reset form when modal is closed
watch(() => props.show, (newValue) => {
    if (!newValue) {
        resetForm();
    }
});
</script>
