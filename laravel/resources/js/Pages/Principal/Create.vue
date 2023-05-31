<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import CreatePrincipal from "../../Components/CreatePrincipal.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <LayoutHeader>
                Stwórz zleceniodawcę
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <CreatePrincipal />
        </LayoutContainer>
    </AppLayout>
</template>
