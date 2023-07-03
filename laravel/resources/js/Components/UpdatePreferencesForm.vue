<script setup>
import FormSection from "./FormSection.vue";
import InputLabel from "./InputLabel.vue";
import InputError from "./InputError.vue";
import PrimaryButton from "./PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "./ActionMessage.vue";
import TextInput from "./TextInput.vue";

const props = defineProps({
    settings: Object,
});

const form = useForm( [
    {
        name: 'alertAboutDelete',
        value: props.settings.alertAboutDelete ?? ''
    },
    {
        name: 'searchKey',
        value: props.settings.searchKey ?? ''
    },
]);

const updatePassword = () => {
    form.put(route('user-settings'), {
        preserveScroll: true,
    });
}
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="current_password" value="Alert usuwania" />

                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        v-model="form[0].value">
                    <option value="1">Tak</option>
                    <option value="0">Nie</option>
                </select>

                <InputError class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="current_password" value="Przycisk wyszukiwania" />
                <TextInput type="text" class="w-full" v-model="form[1].value" />
                <InputError class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </ActionMessage>

            <PrimaryButton @click="updatePassword" :disabled="form.processing" type="button" class="mr-3">
                Zapisz
            </PrimaryButton>
        </template>
    </FormSection>
</template>
