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

<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import FiltersDrawer from "../../Components/TimeEntries/FiltersDrawer.vue";
import TimeEntriesTable from "../../Components/TimeEntries/TimeEntriesTable.vue";
import TimeEntriesDeleteConfirmationModal from "../../Components/TimeEntries/TimeEntriesDeleteConfirmationModal.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import DeletedTimeEntries from "../../Components/TimeEntries/DeletedTimeEntries.vue";
import useDeletionModal from "../../Composables/UseDeletionModal";
import SearchBar from "../../Components/SearchBar.vue";

const props = defineProps({
    timeEntries: Array,
    request: Object,
    settings: Object,
});

const [ isModalOpen, timeEntryDeleteId, showModalDeleteEntry, timeEntryDeleteForm, deleteEntry ] = useDeletionModal({
    settings: props.settings,
    routeName: 'time-entries.destroy',
});
</script>

