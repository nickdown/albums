<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Confirm Delete
            </h2>

            <div class="mb-6">
                <p class="text-gray-600">
                    Are you sure you want to delete <span class="font-semibold">{{ itemName }}</span>? This action cannot be undone.
                </p>
            </div>

            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500"
                    @click="$emit('close')"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                    :disabled="processing"
                    @click="confirmDelete"
                >
                    {{ processing ? 'Deleting...' : 'Delete' }}
                </button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    show: Boolean,
    itemName: String,
});

const emit = defineEmits(['close', 'confirm']);

const processing = ref(false);

const confirmDelete = () => {
    processing.value = true;
    emit('confirm');
};
</script> 