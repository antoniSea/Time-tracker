<script setup lang="ts">
import ConfirmationModal from "../ConfirmationModal.vue";
import SecondaryButton from "../SecondaryButton.vue";
import DangerButton from "../DangerButton.vue";

interface props {
    isModalOpen: boolean;
    timeEntryId: number;
    timeEntryDeleteForm: any;
}

const props = defineProps<props>();

const emit = defineEmits(["delete-entry"]);

const deleteEntry = (id: number) => {
    emit("delete-entry", id);
};
</script>

<template>
    <ConfirmationModal :show="isModalOpen">
        <template #title>
            Usuwanie wpisu czasu
        </template>

        <template #content>
            Czy na pewno chcesz usunąć tego zleceniodawcę?
        </template>

        <template #footer>
            <SecondaryButton @click="isModalOpen = false">
                Anuuj
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': timeEntryDeleteForm.processing }"
                :disabled="timeEntryDeleteForm.processing"
                @click="deleteEntry(timeEntryId)"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
