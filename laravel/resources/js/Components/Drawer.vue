<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <slot name="trigger" @click="show = true"></slot>

    <div
        :class="{ 'transform translate-x-0': show, '-translate-x-full': !show }"
        class="z-10 fixed inset-y-0 left-0 sm:w-[100vw] lg:w-1/5 border overflow-auto bg-white transition-transform duration-200 ease-in-out"
    >
        <div class="mt-10 px-4 py-2">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                <slot name="title"></slot>
            </h2>

            <slot />
        </div>
    </div>
</template>
