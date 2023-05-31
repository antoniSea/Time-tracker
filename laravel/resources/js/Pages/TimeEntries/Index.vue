<script setup>
import { ref } from 'vue';
import AppLayout from "../../Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import FiltersDrawer from "../../Components/TimeEntries/FiltersDrawer.vue";
import TimeEntriesTable from "../../Components/TimeEntries/TimeEntriesTable.vue";
import TimeEntriesDeleteConfirmationModal from "../../Components/TimeEntries/TimeEntriesDeleteConfirmationModal.vue";
import { shouldDeleteConfirmationModalBeShown } from '../../Helpers/Preferences';
import LayoutContainer from "../../Components/LayoutContainer.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import DeletedTimeEntries from "../../Components/TimeEntries/DeletedTimeEntries.vue";

const props = defineProps({
    timeEntries: Array,
    request: Object,
    settings: Object,
});

const isModalOpen = ref(false);
const timeEntryDeleteId = ref(null);
const timeEntryDeleteForm = useForm({});

const showModalDeleteEntry = (id) => {
    if (shouldDeleteConfirmationModalBeShown(props.settings)) {
        deleteEntry(id);
        return;
    }

    isModalOpen.value = true;
    timeEntryDeleteId.value = id;
};

const deleteEntry = (id) => {
    timeEntryDeleteForm.delete(route('time-entries.destroy', id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            isModalOpen.value = false;
            timeEntryDeleteId.value = null;
        },
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <LayoutHeader>
                Lista Wpisów Czasu
            </LayoutHeader>
        </template>


        <LayoutContainer>
            <FiltersDrawer
                :started-from-date="request.startedFromDate"
                :started-to-date="request.startedToDate"
            />

            <DeletedTimeEntries :time-entries="timeEntries.data" />

            <TimeEntriesTable
                :settings="settings"
                :time-entries="timeEntries.data"
                @delete-entry="showModalDeleteEntry"
            />

            <pagination class="mt-4" v-if="timeEntries.links.length > 1" :links="timeEntries.links"/>
        </LayoutContainer>

        <TimeEntriesDeleteConfirmationModal
            :is-modal-open="isModalOpen"
            :time-entry-id="timeEntryDeleteId"
            @delete-entry="deleteEntry"
            :time-entry-delete-form="timeEntryDeleteForm"
        />
    </AppLayout>
</template>
