<script setup>
defineProps({
    content: {
        type: String,
        required: true
    },
    userName: {
        type: String,
        required: true
    }
});
</script>

<template>
    <div class="p-8 bg-white rounded shadow">
        <p class="text-gray-600 mb-4">{{ content }}</p>
        <h3 class="text-xl font-bold">{{ userName }}</h3>
    </div>
</template>
