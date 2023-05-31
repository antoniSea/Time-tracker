<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StopWatch from '@/Components/StopWatch.vue';
import { defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import CreatePrincipal from '@/Components/CreatePrincipal.vue';

const props = defineProps({
    'principals': Array,
    'timeEntries': Array,
});

const reloadInprogress = ref(false);

const doesUserHavePrincipal = () => {
    return props.principals.length === 0;
};

const reloadPage = async () => {
    reloadInprogress.value = true;
    await router.replace('/dashboard');
    reloadInprogress.value = false;
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="doesUserHavePrincipal">
                    Nie posiadasz żadnego zleceniodawcy! Aby kożystać z trackera stwórz nowego
                </span>
                <span v-else>
                    Liczenie czasu pracy
                </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <CreatePrincipal v-if="principals.length === 0" />

                    <div v-else>
                        <StopWatch @reload="reloadPage" v-if="!reloadInprogress" :time-entries="props.timeEntries" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
