<template>
    <AppLayout>
        <template #header>
            <LayoutHeader>
                Lista rachunków
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="route('billing.create')">
                        <PrimaryButton>
                            Dodaj rachunek
                        </PrimaryButton>
                    </Link>

                    <FiltersDrawer
                        :started-from-date="request.startedFromDate"
                        :started-to-date="request.startedToDate"
                    />
                </div>

                <SearchBar route-name-space="billing" :settings="settings" />
            </div>

            <Table class="mt-4">
                <TableThead>
                    <TableColumn>
                        Nazwa
                    </TableColumn>
                    <TableColumn>
                        Ilość godzin
                    </TableColumn>
                    <TableColumn>
                        Stawka godzinowa
                    </TableColumn>
                    <TableColumn>
                        Cena zlecenia
                    </TableColumn>
                    <TableColumn>
                        Zleceniodawca
                    </TableColumn>
                    <TableColumn>
                        Akcje
                    </TableColumn>
                </TableThead>

                <TableBody>
                    <TableDataContainer v-if="bills.data.length === 0">
                        <TableDataCell colspan="5">
                            Brak dokumentów do wyświetlenia
                        </TableDataCell>
                    </TableDataContainer>

                    <TableDataContainer v-for="bill in bills.data">
                        <TableDataCell>
                            {{ bill.name }}
                        </TableDataCell>
                        <TableDataCell>
                            {{ bill.hours }}
                        </TableDataCell>
                        <TableDataCell>
                            {{ bill.rate }}
                        </TableDataCell>
                        <TableDataCell>
                            {{ bill.amount }}
                        </TableDataCell>
                        <TableDataCell>
                            {{ bill.principal.name }}
                        </TableDataCell>
                        <TableDataCell>
                            <Link :href="route('billing.edit', bill.id)">
                                <PrimaryButton>
                                    Zobacz
                                </PrimaryButton>
                            </Link>

                            <SecondaryButton @click="copyPreviewLink(bill.url_token)" class="ml-4">
                                Skopiuj link do podglądu
                            </SecondaryButton>

                            <DangerButton @click="showModal(bill.id)" class="ml-4">
                                Usuń
                            </DangerButton>
                        </TableDataCell>
                    </TableDataContainer>
                </TableBody>
            </Table>

            <Pagination class="mt-4" :links="bills.links" />
        </LayoutContainer>
    </AppLayout>

    <BillingDeleteConfirmationModal
        :is-modal-open="isModalOpen"
        :time-entry-delete-form="deleteForm"
        :id="deletingId"
        @delete-entry="deleteBill"
    />
</template>

<script setup>
import Table from "../../Components/Table.vue";
import TableThead from "../../Components/TableThead.vue";
import TableColumn from "../../Components/TableColumn.vue";
import TableBody from "../../Components/TableBody.vue";
import TableDataCell from "../../Components/TableDataCell.vue";
import TableDataContainer from "../../Components/TableDataContainer.vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import Pagination from "../../Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { notify } from "../../helpers/NotificationHelper";
import DangerButton from "../../Components/DangerButton.vue";
import useDeletionModal from "../../Composables/UseDeletionModal.js";
import BillingDeleteConfirmationModal from "../../Components/Billing/BillingDeleteConfirmationModal.vue";
import FiltersDrawer from "../../Components/TimeEntries/FiltersDrawer.vue";
import SearchBar from "../../Components/SearchBar.vue";

const props = defineProps({
    bills: Array,
    settings: Array,
    request: Object,
});

const [ isModalOpen, deletingId, showModal, deleteForm, deleteBill ] = useDeletionModal({
    settings: props.settings,
    routeName: 'billing.destroy',
    successMessage: 'Pomyślnie usunięto dokument',
});

const copyPreviewLink = async (id) => {
    const text = route('billing.download', id);

    try {
        await navigator.clipboard.writeText(text);
        notify().success('Skopiowano link do podglądu');
    } catch {
        notify().error('Nie udało się skopiować linku do podglądu');
    }
};
</script>
