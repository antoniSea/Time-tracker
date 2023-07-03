<template>
    <Navbar
        :user="user"
        v-once
    />

    <div class="w-[70%] mx-auto mt-8 p-4">
        okej
    </div>
</template>

<script setup>
import Navbar from "../Components/LandingPage/Navbar.vue";

defineProps({
    'user': Object,
});
</script>
