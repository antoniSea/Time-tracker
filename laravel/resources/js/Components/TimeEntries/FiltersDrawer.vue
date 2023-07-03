<template>
    <SecondaryButton class="m-2" @click="showFilters = !showFilters">Filtry</SecondaryButton>

    <Drawer :show="showFilters">
        <h3 class="text-2xl mb-4">
            Filtruj
        </h3>

        <DangerButton class="absolute top-0 right-0 m-2" @click="showFilters = !showFilters">X</DangerButton>

        <form @submit.prevent="filtersForm.get('')">
            Czas rozpoczęcia
            <div class="mt-2">
                <InputLabel class="w-full">Od</InputLabel>
                <TextInput type="date" class="w-full" v-model="filtersForm.startedToDate" />
                <InputError :message="filtersForm.errors.startedToDate" />
            </div>

            <div class="mt-2">
                <InputLabel class="w-full">Do</InputLabel>
                <TextInput type="date" class="w-full" v-model="filtersForm.startedFromDate" />
                <InputError :message="filtersForm.errors.startedFromDate" />
            </div>

            <PrimaryButton class="mt-4">Filtruj</PrimaryButton>
            <br>
            <SecondaryButton class="mt-4" @click="clearFilters">Wyczyść filtry</SecondaryButton>
        </form>
    </Drawer>
</template>

<script setup>
import Drawer from "../Drawer.vue";
import { ref } from "vue";
import InputLabel from "../../Components/InputLabel.vue";
import TextInput from "../../Components/TextInput.vue";
import InputError from "../../Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../PrimaryButton.vue";
import SecondaryButton from "../SecondaryButton.vue";
import DangerButton from "../DangerButton.vue";

const props = defineProps({
    'startedToDate': Object,
    'startedFromDate': Object,
});

const showFilters = ref(false);
const filtersForm = useForm({
    startedToDate: props.startedToDate,
    startedFromDate: props.startedToDate,
});

const clearFilters = () => {
    filtersForm.startedToDate = null;
    filtersForm.startedFromDate = null;
    filtersForm.get('');
};
</script>

