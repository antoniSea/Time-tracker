<template>
    <DialogModal :show="isModalOpen">
        <template #title>
            {{ title ?? 'Wyszukiwanie jednostki' }}
        </template>

        <template #content>
            <form @submit.prevent="performSearch">
                <div class="mt-4">
                    Wyszukaj
                    <TextInput
                        @input="fetchSearch"
                        placeholder="Wyszukaj"
                        type="text"
                        class="w-full"
                        autofocus
                        v-model="form.search"
                        :disabled="form.processing"
                    />
                </div>

                <div class="mt-4">
                    Sortuj po kolumnie
                    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" v-model="form.column" :disabled="form.processing">
                        <option v-for="column in columns" :value="column">
                            {{ column }}
                        </option>
                    </select>
                </div>

                <SearchResults :results="searchResults" />
            </form>
        </template>

        <template #footer>
            <PrimaryButton class="mr-4" :disabled="form.processing" @click="performSearch">
                Wyszukaj
            </PrimaryButton>

            <SecondaryButton @click="closeModal">
                Anuuj
            </SecondaryButton>
        </template>
    </DialogModal>
</template>

<script setup lang="ts">
import SecondaryButton from "./SecondaryButton.vue";
import DialogModal from "./DialogModal.vue";
import TextInput from "./TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import formOptions from "../helpers/FormOptionsHelper.js";
import PrimaryButton from "./PrimaryButton.vue";
import { ref } from "vue";
import axios from "axios";
import SearchResults from "./SearchResults.vue";

interface props {
    isModalOpen: boolean;
    columns: any[] | null;
    routeNameSpace: string;
    title: string | null;
}

const props = defineProps<props>();

const form = useForm({
    search: '',
    column: 'name',
});
const searchResults = ref([]);

const emit = defineEmits([
    'close',
]);

const fetchSearch = async () => {
    const getData = {
        search: form.search,
        column: form.column,
    };

    try {
        searchResults.value = (await axios.get(route(`${props.routeNameSpace}.search`, getData))).data;
    } catch (e: any) {
        console.log(e);
    }
};

const closeModal = () => {
    emit('close');
};

const performSearch = async () => {
    await form.get('', formOptions({
        successMessage: 'Wyświetlam wynikki wyszukiwania',
    }));
};
</script>
