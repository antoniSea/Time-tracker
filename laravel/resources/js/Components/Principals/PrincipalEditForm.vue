<script setup>
import TextInput from "../TextInput.vue";
import InputLabel from "../InputLabel.vue";
import InputError from "../InputError.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../PrimaryButton.vue";
import { notify } from "../../helpers/NotificationHelper";

const props = defineProps({
    principal: Object,
});

const form = useForm({
    name: props.principal.name,
    description: props.principal.description,
    nip: props.principal.nip,
    address: props.principal.address,
    email: props.principal.email,
    accounting_email: props.principal.accounting_email,
    website: props.principal.website,
    password: "",
    phone: props.principal.phone,
});

const submit = () => {
    form.put(route("principals.show", {principal: props.principal.id}), {
        onFinish: () => {
            notify().success('Pomyślnie zapisano zleceniodawcę');

            form.reset("password");
        },
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-6">
                <InputLabel for="name" value="Nazwa" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-6">
                <InputLabel for="description" value="Opis" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="description"
                />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-6">
                <InputLabel for="nip" value="NIP" />
                <TextInput
                    id="nip"
                    v-model="form.nip"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="nip"
                />
                <InputError class="mt-2" :message="form.errors.nip" />
            </div>

            <div class="mt-6">
                <InputLabel for="address" value="Adres" />
                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="address"
                />
                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-6">
                <InputLabel for="accounting_email" value="Email księgowości" />
                <TextInput
                    id="accounting_email"
                    v-model="form.accounting_email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="accounting_email"
                />
                <InputError class="mt-2" :message="form.errors.accounting_email" />
            </div>

            <div class="mt-6">
                <InputLabel for="website" value="Strona internetowa" />
                <TextInput
                    id="website"
                    v-model="form.website"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="website"
                />
                <InputError class="mt-2" :message="form.errors.website" />
            </div>

            <div class="mt-6">
                <InputLabel for="phone" value="Telefon" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <PrimaryButton
                type="submit"
                class="mt-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Zapisz
            </PrimaryButton>
        </form>
    </div>
</template>
