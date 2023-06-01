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

                <button
                    @click="handleFileDownload"
                    class="px-4 py-2 mt-5 text-white bg-green-600 rounded hover:bg-green-700"
                >
                    Pobierz plik
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import Papa from 'papaparse'

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
    const csv = Papa.unparse(csvData.value)
    const blob = new Blob([csv], { type: 'text/csv' })
    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = 'edited.csv'
    link.click()
    URL.revokeObjectURL(url)
}
</script>
