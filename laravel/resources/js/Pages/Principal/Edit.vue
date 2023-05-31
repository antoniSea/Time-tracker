<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import PrincipalEditForm from "../../Components/Principals/PrincipalEditForm.vue";

const props = defineProps({
    principal: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <LayoutHeader>
                Edytuj zleceniodawcę
            </LayoutHeader>
        </template>

        <LayoutContainer>
            <PrincipalEditForm :principal="principal" />
        </LayoutContainer>
    </AppLayout>
</template>
