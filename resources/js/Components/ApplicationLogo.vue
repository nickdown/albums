<template>
    <svg 
        :class="class" 
        viewBox="0 0 24 24" 
        fill="none" 
        stroke="currentColor" 
        stroke-width="2" 
        stroke-linecap="round" 
        stroke-linejoin="round"
    >
        <path d="M9 18V5l12-2v13" />
        <circle cx="6" cy="18" r="3" />
        <circle cx="18" cy="16" r="3" />
    </svg>
</template>

<script setup>
defineProps({
    class: {
        type: String,
        default: 'w-8 h-8 text-gray-800'
    }
});
</script>
