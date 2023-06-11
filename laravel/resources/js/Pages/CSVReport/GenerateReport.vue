<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "../../Components/SecondaryButton.vue";

const props = defineProps({
    principals: Object,
});

const form = useForm({
    fromDate: "",
    toDate: "",
    principal: props?.principals[0]?.id,
    fileFormat: 1,
});

const submitForm = () => {
    const url = route("csv-reports.store") + "?" + new URLSearchParams({
        fromDate: form.fromDate,
        toDate: form.toDate,
        principal: form.principal,
        fileFormat: form.fileFormat,
    });

    const headers = {
        'Accept': 'application/csv',
        'Content-Type': 'application/csv',
    };

    axios.post(url, {}, headers).then((file) => {
        const url = window.URL.createObjectURL(new Blob([file.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', file.headers['content-disposition'].split('filename=')[1].split('.csv')[0] + '.csv');
        document.body.appendChild(link);
        link.click();
    });
};

const previewFile = () => {
    let url = route("csv-reports.preview") + "?" + new URLSearchParams({
        fromDate: form.fromDate,
        toDate: form.toDate,
        principal: form.principal,
        fileFormat: form.fileFormat,
    });

    let width = 600;
    let height = 700;

    let left = window.innerWidth / 2 - width / 2 + window.screenX;
    let top = window.innerHeight / 2 - height / 2 + window.screenY;

    let windowFeatures = `menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=${width},height=${height},left=${left},top=${top}`;

    window.open(url, "_blank", windowFeatures);

};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <LayoutHeader>
                Stwórz raport CSV
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <form @submit.prevent="submitForm">
                <div>
                    <InputLabel value="Od" />
                    <TextInput type="date" class="w-full" v-model="form.fromDate" />
                </div>

                <div class="mt-2">
                    <InputLabel value="Do" />
                    <TextInput type="date" class="w-full" v-model="form.toDate" />
                </div>

                <div class="mt-2">
                    <InputLabel value="Zleceniodawca" />
                    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-2" v-model="form.principal">
                        <option value="0">-- Wybierz zleceniodawcę --</option>
                        <option v-for="principal in props.principals" :key="principal.id" :value="principal.id">
                            {{ principal.name }}
                        </option>
                    </select>
                </div>

                <div class="mt-2">
                    <InputLabel value="Format pliku" />
                    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-2" v-model="form.fileFormat">
                        <option value="0">-- Wybierz format pliku --</option>
                        <option value="1">Dzienne wpisy</option>
                        <option value="2">Lista wpisów</option>
                    </select>
                </div>

                <PrimaryButton class="mt-4" :disabled="form.processing">
                    Pobierz raport
                </PrimaryButton>

                <SecondaryButton class="ml-4" @click="previewFile">
                    Przeglądnij plik
                </SecondaryButton>
            </form>

        </LayoutContainer>
    </AppLayout>
</template>
