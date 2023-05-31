<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
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

const props = defineProps({
    principals: Array,
});

const form = useForm({});

const markPrincipalAsMain = (id) => {
    form.post(route('principals.mark-as-main', {'principal': id}));
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
            <Link :href="route('principals.create')">
                <PrimaryButton class="mb-4">
                    Stwórz zleceniodawcę
                </PrimaryButton>
            </Link>

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
                                Wybierz jako główny
                            </PrimaryButton>

                            <Link :href="route('principals.edit', {principal: principal.id})">
                                <SecondaryButton class="ml-4">
                                    Edytuj
                                </SecondaryButton>
                            </Link>
                        </TableDataCell>
                    </TableDataContainer>
                </TableBody>
            </Table>
        </LayoutContainer>
    </AppLayout>
</template>
