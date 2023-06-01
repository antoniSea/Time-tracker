<script setup>
    import PreviewCsvReport from "../../Components/CsvReports/PreviewCsvReport.vue";
    import LayoutContainer from "../../Components/LayoutContainer.vue";

    const props = defineProps({
        fileName: Object,
    });
</script>

<template>
        <LayoutContainer>
            <PreviewCsvReport :file-url="fileName" />
        </LayoutContainer>
</template>
