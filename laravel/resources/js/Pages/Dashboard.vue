<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StopWatch from '@/Components/StopWatch.vue';
import { defineProps, ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import CreatePrincipal from '@/Components/CreatePrincipal.vue';
import LayoutContainer from "../Components/LayoutContainer.vue";
import LayoutHeader from "../Components/LayoutHeader.vue";

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
            <LayoutHeader>
                <span v-if="doesUserHavePrincipal">
                    Nie posiadasz żadnego zleceniodawcy! Aby kożystać z trackera stwórz nowego
                </span>
                <span v-else>
                    Liczenie czasu pracy
                </span>
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <CreatePrincipal
                v-if="principals.length === 0"
            />

            <div v-else>
                <StopWatch
                    @reload="reloadPage"
                    v-if="!reloadInprogress"
                    :time-entries="props.timeEntries"
                />

                <div class="mt-4 text-2xl">
                    Pracujesz dla: {{ props.principals.filter(principal => principal.selected_main)[0].name }}

                    <Link class="text-blue-500" :href="route('principals.index')">
                        Zmień
                    </Link>
                </div>
            </div>
        </LayoutContainer>
    </AppLayout>
</template>
