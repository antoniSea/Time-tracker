<template>
    <div class="flex flex-col items-center justify-center bg-gray-100 p-5">
        <div class="flex flex-col bg-white shadow-md rounded-lg p-5">
            <div v-if="csvData" class="overflow-auto">
                <table class="w-full table-auto">
                    <tr
                        v-for="(row, rowIndex) in csvData"
                        :key="rowIndex"
                        class="border-t border-gray-200"
                    >
                        <td
                            v-for="(item, index) in row"
                            :key="index"
                            class="p-2 border-l border-gray-200"
                        >
                            <input
                                v-model="csvData[rowIndex][index]"
                                class="w-full px-2 py-1 border-0 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </td>
                    </tr>
                </table>

                <PrimaryButton @click="handleFileDownload">
                    Pobierz plik
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import Papa from 'papaparse'
import PrimaryButton from "../PrimaryButton.vue";
import fileDownloader from "../../helpers/FileDownloader";

const props = defineProps({
    'fileUrl': String,
});

const csvData = ref(null);

onMounted(() => {
    fetch(props.fileUrl)
        .then(res => res.text())
        .then(res => {
            const results = Papa.parse(res, {
                complete: (results) => {
                    csvData.value = results.data
                },
            })

            csvData.value = results.data
        })
})

const handleFileDownload = () => {
    fileDownloader.downloadFile(
        csvData.value,
        'Raport-godzinowy.csv'
    );
}
</script>
