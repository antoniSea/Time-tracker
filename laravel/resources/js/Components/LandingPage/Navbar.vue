<template>
    <div class="bg-gray-800">
        <div class="flex justify-between w-full w-[70%] mx-auto p-4 text-white">
            <div class="font-semibold">
                Tracker czasu
            </div>

            <div v-if="!user" class="flex space-x-8">
                <Link href="register">
                    Zarejestruj się
                </Link>

                <Link href="login">
                    Zaloguj się
                </Link>
            </div>

            <div v-else>
                <Link href="dashboard">
                    Panel użytkownika
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    user: Object,
})
</script>
