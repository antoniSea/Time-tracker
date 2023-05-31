<script setup>
import DangerButton from "../DangerButton.vue";
import SecondaryButton from "../SecondaryButton.vue";
import { ref } from "vue";
import DialogModal from "../DialogModal.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "../PrimaryButton.vue";

const showFilters = ref(false);
const deletedTimeEntries = ref([]);
const form = useForm({});

const showModal = async () => {
    const { data: response } = await axios.get(route('time-entries.deleted'));

    showFilters.value = !showFilters.value;
    deletedTimeEntries.value = await response.data;
};

const reverseDeletion = (id) => {
    form.post(route('time-entries.reverse-deletion', id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            showFilters.value = false;
        },
    });
};

const reverseDeletionForAllEntries = () => {
    form.post(route('time-entries.reverse-deletion-for-all-entries'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            showFilters.value = false;
        },
    });
}

const hardDeleteEntry = (id) => {
    form.delete(route('time-entries.hard-delete', id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            showFilters.value = false;
        },
    });
};
</script>

<template>
    <DangerButton class="m-2" @click="showModal">Usunięte wpisy czasu</DangerButton>

    <DialogModal :show="showFilters">
        <template #title>
            Przywróć usunięte wpisy czasu
        </template>

        <template #content>
            <div class="mt-5">
                <div v-if="deletedTimeEntries.length === 0">
                    <div class="text-center mt-4">
                        Brak usuniętych wpisów czasu
                    </div>
                </div>

                <div v-for="entry in deletedTimeEntries">
                    <div class="flex w-[100%] mx-auto justify-between">
                        {{ entry.start_time }}

                        <div class="flex">
                            <SecondaryButton
                                @click="reverseDeletion(entry.id)"
                                class="m-2"
                                :disabled="form.processing"
                            >
                                Przywróć
                            </SecondaryButton>

                            <DangerButton class="m-2" @click="hardDeleteEntry(entry.id)">Usuń</DangerButton>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="showFilters = false">
                Anuuj
            </SecondaryButton>

            <PrimaryButton class="ml-4" @click="reverseDeletionForAllEntries">
                Przywróć Wszystkie
            </PrimaryButton>
        </template>

    </DialogModal>
</template>
