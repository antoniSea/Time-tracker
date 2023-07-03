<template>
    <hr class="mt-4">
    <div class="block border p-4 rounded mt-4 shadow-sm" v-for="result in results">
        <Link :href="route('billing.edit', result.id)" class="block">
            {{ result.name }}
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    results: Object,
});
</script>
