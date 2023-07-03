<template>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Informacje o rachunku</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Wprowadź informacje o rachunku.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submit(bill.id)">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="name">Nazwa</InputLabel>
                                        <TextInput type="text" v-model="form.name" autocomplete="name" class="w-full" />
                                        <InputError :message="form.errors.name" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="hours">Ilość godzin</InputLabel>
                                        <TextInput type="number" v-model="form.hours" autocomplete="hours" class="w-full" />
                                        <InputError :message="form.errors.hours" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="rate">Stawka godzinowa</InputLabel>
                                        <TextInput type="number" v-model="form.rate" autocomplete="rate" class="w-full" />
                                        <InputError :message="form.errors.rate" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="amount">Cena zlecenia</InputLabel>
                                        <TextInput type="number" v-model="form.amount" autocomplete="amount" class="w-full" />
                                        <InputError :message="form.errors.amount" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="date">Date</InputLabel>
                                        <TextInput type="date" v-model="form.date" autocomplete="date" class="w-full" />
                                        <InputError :message="form.errors.date" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="description" class="block text-sm font-medium text-gray-700">Description</InputLabel>
                                        <textarea v-model="form.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                        <InputError :message="form.errors.description" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <InputLabel for="principal_id">Zleceniodawca</InputLabel>
                                        <select v-model="form.principal_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Wybierz zleceniodawcę</option>
                                            <option v-for="principal in principals" :key="principal.id" :value="principal.id">
                                                @{{ principal.name }}
                                            </option>
                                        </select>
                                        <InputError :message="form.errors.principal_id" />
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <PrimaryButton :disabled="form.processing">
                                    Zapisz
                                </PrimaryButton>

                                <SecondaryButton class="ml-4" @click.prevent="previewForm">
                                    Pokaż preview
                                </SecondaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import TextInput from "../../Components/TextInput.vue";
import InputLabel from "../../Components/InputLabel.vue";
import InputError from "../../Components/InputError.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { notify } from "../../helpers/NotificationHelper";

const props = defineProps({
    principals: Array,
    bill: Object,
});

const form = useForm({
    name: props.bill.name,
    hours: props.bill.hours,
    rate: props.bill.rate,
    amount: props.bill.amount,
    date: props.bill.date,
    description: props.bill.description,
    principal_id: props.bill.principal_id,
});

const submit = (id) => {
    form.put(route('billing.update', id), {
        onSuccess: () => {
            notify().success('Pomyślnie zapisano dokument');
        }
    });
};

const previewForm = () => {
    const url = route("billing.preview") + "?" + new URLSearchParams(form.valueOf());

    window.open(url, '_blank');
};
</script>
