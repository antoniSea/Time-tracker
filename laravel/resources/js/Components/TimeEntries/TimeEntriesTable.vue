<script setup lang="ts">
import { defineProps } from 'vue'
import PrimaryButton from "../PrimaryButton.vue";
import DangerButton from "../DangerButton.vue";
import { Link } from "@inertiajs/vue3";
import Table from "../Table.vue";
import TableThead from "../TableThead.vue";
import TableHeader from "../TableColumn.vue";
import TableColumn from "../TableColumn.vue";
import TableDataCell from "../TableDataCell.vue";
import TableDataContainer from "../TableDataContainer.vue";
import TableBody from "../TableBody.vue";

interface props {
    timeEntries: Array<any>
}
const props = defineProps<props>()

const emit = defineEmits(['delete-entry']);

const showModalDeleteEntry = (id: number) => {
    emit('delete-entry', id);
};
</script>

<template>
    <Table>
        <TableThead>
            <TableColumn>
                ID
            </TableColumn>
            <TableColumn>
                Czas rozpoczęcia
            </TableColumn>
            <TableColumn>
                Czas zakończenia
            </TableColumn>
            <TableColumn>
                Nazwa zleceniodawcy
            </TableColumn>
            <TableColumn>
                Akcje
            </TableColumn>
        </TableThead>

        <TableBody>
            <TableDataContainer v-if="timeEntries.length === 0">
                <TableDataCell colspan="5">
                    Brak wpisów czasu
                </TableDataCell>
            </TableDataContainer>

            <TableDataContainer v-for="timeEntry in timeEntries">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ timeEntry.id }}
                </th>

                <TableDataCell>
                    {{ timeEntry.start_time }}
                </TableDataCell>

                <TableDataCell>
                    {{ timeEntry.end_time }}
                </TableDataCell>

                <TableDataCell>
                    {{ timeEntry.principal.name }}
                </TableDataCell>

                <TableDataCell>
                    <Link :href="route('time-entries.edit', {'id': timeEntry.id})">
                        <PrimaryButton>
                            Edytuj
                        </PrimaryButton>
                    </Link>

                    <DangerButton class="ml-2" @click="showModalDeleteEntry(timeEntry.id)">
                        Usuń
                    </DangerButton>
                </TableDataCell>
            </TableDataContainer>
        </TableBody>
    </Table>
</template>
