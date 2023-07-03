import { ref } from "vue";
import { shouldDeleteConfirmationModalBeShown } from "../helpers/Preferences";
import { useForm } from "@inertiajs/vue3";
import { notify } from "../helpers/NotificationHelper";

const isModalOpen = ref(false);
const timeEntryDeleteId = ref(null);
const deleteForm = useForm({});

export default function useDeletionModal(props) {
    const deleteEntry = (id) => {
        deleteForm.delete(route(props.routeName, timeEntryDeleteId.value ?? id), {
            preserveScroll: true,
            onSuccess: () => {
                isModalOpen.value = false;
                timeEntryDeleteId.value = null;

                notify().success(props.successMessage ?? 'Usuwanie przeszło pomyślnie');
            },
            onError: () => {
                notify().error(props.errorMessage ?? 'Wystąpił nieoczekiwany błąd');
            }
        });
    };

    const showModal = (id) => {
        if (shouldDeleteConfirmationModalBeShown(props.settings)) {
            deleteEntry(id);
            return;
        }

        isModalOpen.value = true;
        timeEntryDeleteId.value = id;
    };


    return [
        isModalOpen,
        timeEntryDeleteId,
        showModal,
        deleteForm,
        deleteEntry,
    ];
}
