<script setup>
import Calendar from "../../Components/Calendar.vue";
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
</script>

<template>
    <AppLayout>
        <template #header>
            <LayoutHeader>
                Kalendarz
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <Calendar />
        </LayoutContainer>
    </AppLayout>
</template>
