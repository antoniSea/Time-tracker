<script setup lang="ts">
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { onMounted, ref } from 'vue';
import PrimaryButton from "./PrimaryButton.vue";
import ConfirmationModal from "./ConfirmationModal.vue";
import SecondaryButton from "./SecondaryButton.vue";
import DangerButton from "./DangerButton.vue";
import DialogModal from "./DialogModal.vue";
import TextInput from "./TextInput.vue";
import { notify } from "../helpers/NotificationHelper.js";

const calendarOptions = ref({
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    events: [],
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth dayGridWeek dayGridDay'
    },
    editable: true,
    dateClick: async (info: any) => {
        showCreationModal.value = true;
        creationDate.value = info.dateStr;
    },
    eventClick: (info: any) => {
        showDeletionModal.value = true;
        deletionInfo.value = info;
    },
    eventDrop: async (info: any) => {
        const {data: response} = await axios.put(`/calendar/${info.event.id}`, {
            start_time: info.event.startStr,
        });
    },
});

const creationDate = ref<any>();
const creationName = ref<string>('')
const showDeletionModal = ref<boolean>(false);
const deletionInfo = ref<any>();
const showCreationModal = ref<boolean>(false);
const tasks = ref([
    {
        date: '2023-09-20', // Date in YYYY-MM-DD format
        task: 'Task 1',
        completed: false,
    },
    // Add more tasks here
]);

onMounted(async () => {
    await init();
});

const init = async () => {
    const {data: response} = await axios.get('/calendar');
    calendarOptions.value.events = response.events.map((item) => {
        return {
            title: item.title,
            duration: '02:00',
            date: item.start_time.split(' ')[0],
            id: item.id,
        }
    });
};
const submitForm = async () => {
    const id = Math.floor(Math.random() * 1000);
    calendarOptions.value.events.push({
        title: creationName.value,
        date: creationDate.value,
        id: id,
    });

    showCreationModal.value = false;

    await axios.post('/calendar', {
        title: creationName.value,
        start_time: creationDate.value,
    });

    notify().success('Pomyślnie dodano wydarzenie');

    creationName.value = '';

    init();
}

const confirmDeltion = () => {
    calendarOptions.value.events = calendarOptions.value.events.filter((event) => event.id != deletionInfo.value.event.id);
    showDeletionModal.value = false;

    axios.delete(`/calendar/${deletionInfo.value.event.id}`);

    notify().success('Pomyślnie usunięto wydarzenie');
}
</script>

<template>
    <div class="w-[50%] mx-auto">
        <div class="h-[50%] p-4">
            <FullCalendar :options="calendarOptions" />
        </div>

        <!--- Confirmation modal -->
        <ConfirmationModal :show="showDeletionModal">
            <template #title>
                Usuń wydarzenie
            </template>

            <template #content>
                Czy na pewno chcesz usunąć wydarzenie?
            </template>

            <template #footer>
                <SecondaryButton @click="showDeletionModal = null">
                    Anulluj
                </SecondaryButton>

                <DangerButton @click="confirmDeltion">
                    Usuń
                </DangerButton>
            </template>
        </ConfirmationModal>

        <DialogModal :show="showCreationModal">
            <template #title>
                    Stwórz wydarzenie
            </template>

            <template #content>
                <form @submit.prevent="submitForm" class="flex flex-col gap-4 mt-5" id="form">
                    <TextInput class="w-[100%]" type="text" v-model="creationName" placeholder="Wpisz nazwę wydażenia" />
                </form>
            </template>

            <template #footer>
                    <SecondaryButton @click="showCreationModal = null">
                        Anuluj
                    </SecondaryButton>

                    <PrimaryButton
                        @click="confirmDeltion"
                        form="form"
                    >
                        Zapisz
                    </PrimaryButton>
            </template>
        </DialogModal>
    </div>

</template>
