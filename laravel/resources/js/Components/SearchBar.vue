<template>
    <TextInput
        :placeholder="placeholder"
        class="h-10 p-1 mr-4"
        @focus="showModal"
        v-if="!isModalOpen"
    />

    <SearchModal
        :is-modal-open="isModalOpen"
        :columns="columns"
        @close="closeModal"
        :route-name-space="routeNameSpace"
    />
</template>

<script setup>
import TextInput from "./TextInput.vue";
import SearchModal from "./SerachModal.vue";
import { onMounted, ref } from "vue";

const props = defineProps({
    placeholder: {
       default: '',
       type: String,
    },
    routeNameSpace: {
        required: true,
        type: String,
    },
    settings: Object,
});

const placeholder = ref(props.placeholder);
const activateSearchButton = ref('');

onMounted(() => {
    activateSearchButton.value = props.settings.searchKey;

    if (!props.placeholder) {
        placeholder.value = `Wyszukaj (klawisz "${activateSearchButton.value}")`;
    }

    document.addEventListener('keypress', (event) => {
        if (event.key === activateSearchButton.value) {
            isModalOpen.value = true;
        }
    })
});

const isModalOpen = ref(false);
const columns = ref([]);

const showModal = async () => {
    if (columns.value.length === 0) {
        const {data: response} = await axios.get(route(`${props.routeNameSpace}.columns`));
        columns.value = response.columns;
    }

    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>
