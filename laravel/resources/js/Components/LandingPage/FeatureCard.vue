<script setup>
defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <div class="text-center">
        <div class="mb-4 mx-auto w-fit">
            <slot name="icon"></slot>
        </div>
        <h3 class="text-xl font-bold mb-2">{{ title }}</h3>
        <p class="text-gray-600">{{ description }}</p>
    </div>
</template>
