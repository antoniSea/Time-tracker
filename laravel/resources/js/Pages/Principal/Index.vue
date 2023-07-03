<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Table from "../../Components/Table.vue";
import TableThead from "../../Components/TableThead.vue";
import TableColumn from "../../Components/TableColumn.vue";
import TableBody from "../../Components/TableBody.vue";
import TableDataContainer from "../../Components/TableDataContainer.vue";
import TableDataCell from "../../Components/TableDataCell.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import DangerButton from "../../Components/DangerButton.vue";
import useDeletionModal from "../../Composables/UseDeletionModal";
import PrincipalDeleteConfirmationModal from "../../Components/Principals/PrincipalDeleteConfirmationModal.vue";
import formData from "../../helpers/FormOptionsHelper.js";
import SearchBar from "../../Components/SearchBar.vue";

const props = defineProps({
    principals: Array,
    settings: Array,
});

const form = useForm({});

const [ isModalOpen, deletingId, showModal, principalDeleteForm, deletePrincipal ] = useDeletionModal({
    settings: props.settings,
    routeName: 'principals.destroy',
    successMessage: 'Pomyślnie usunięto zleceniodawcę',
});

const markPrincipalAsMain = (id) => {
    form.post(route('principals.mark-as-main', id), formData());
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <LayoutHeader>
                Lista zleceniodawców
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <div class="flex justify-between items-center mb-4">
                <Link :href="route('principals.create')" class="block">
                    <PrimaryButton class="mb-4">
                        Stwórz zleceniodawcę
                    </PrimaryButton>
                </Link>

                <SearchBar
                    route-name-space="principals"
                    :settings="settings"
                />
            </div>

            <Table>
                <TableThead>
                    <TableColumn>
                        ID
                    </TableColumn>
                    <TableColumn>
                        Nazwa
                    </TableColumn>
                    <TableColumn>
                        Nip
                    </TableColumn>
                    <TableColumn>
                        Adres
                    </TableColumn>
                    <TableColumn>
                        Akcje
                    </TableColumn>
                </TableThead>

                <TableBody>
                    <TableDataContainer v-if="principals.length === 0">
                        <TableDataCell colspan="5">
                            Brak wpisów czasu
                        </TableDataCell>
                    </TableDataContainer>

                    <TableDataContainer v-for="principal in principals.data">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ principal.id }}
                        </th>

                        <TableDataCell>
                            {{ principal.name }}
                        </TableDataCell>

                        <TableDataCell>
                            {{ principal.nip }}
                        </TableDataCell>

                        <TableDataCell>
                            {{ principal.address }}
                        </TableDataCell>

                        <TableDataCell>
                            <PrimaryButton @click="markPrincipalAsMain(principal.id)" :disabled="principal.selected_main">
                                <span v-if="!principal.selected_main">
                                    Wybierz jako główny
                                </span>

                                <span v-else>
                                    Wybrano jako główny
                                </span>
                            </PrimaryButton>

                            <Link :href="route('principals.edit', {principal: principal.id})">
                                <SecondaryButton class="ml-4">
                                    Edytuj
                                </SecondaryButton>
                            </Link>

                            <DangerButton
                                @click="showModal(principal.id)"
                                :disabled="principalDeleteForm.processing"
                                class="ml-4"
                            >
                                Usuń
                            </DangerButton>
                        </TableDataCell>
                    </TableDataContainer>
                </TableBody>
            </Table>
        </LayoutContainer>
    </AppLayout>

    <PrincipalDeleteConfirmationModal
        :is-modal-open="isModalOpen"
        :time-entry-delete-form="principalDeleteForm"
        :time-entry-id="deletingId"
        @delete-entry="deletePrincipal"
    />
</template>
