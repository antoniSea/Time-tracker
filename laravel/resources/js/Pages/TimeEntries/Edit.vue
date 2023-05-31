<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import TextInput from "../../Components/TextInput.vue";
import { defineProps } from 'vue';
import {useForm} from "@inertiajs/vue3";
import InputLabel from "../../Components/InputLabel.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import InputError from "../../Components/InputError.vue";

const props = defineProps({
    'timeEntry': Object,
});

const form = useForm({
    'timeEntry': props.timeEntry,
});

const submitForm = () => {
    form.post(route('time-entries.update', props.timeEntry.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edytuj Wpis Czasu: {{ timeEntry.id }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <form>
                        <div>
                            <InputLabel class="w-full">Czas rozpoczęcia</InputLabel>
                            <TextInput id="start_time" type="datetime-local" class="w-full" v-model="form.timeEntry.start_time" />
                            <InputError :message="form.errors.start_time" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="w-full">Czas zakończenia</InputLabel>
                            <TextInput type="datetime-local" class="w-full" v-model="form.timeEntry.end_time" />
                            <InputError :message="form.errors.end_time" />
                        </div>

                        <PrimaryButton class="mt-4" :disabled="form.processing" @click="submitForm">Zapisz</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
