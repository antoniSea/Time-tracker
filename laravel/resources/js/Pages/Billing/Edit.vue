<template>
    <AppLayout>
        <template #header>
            <LayoutHeader>
                Edytuj dokument
            </LayoutHeader>
        </template>

        <template #default>
            <LayoutContainer>
                <EditBillingForm
                    :bill="bill"
                    :principals="principals"
                    v-if="bill"
                />
            </LayoutContainer>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import LayoutHeader from "../../Components/LayoutHeader.vue";
import LayoutContainer from "../../Components/LayoutContainer.vue";
import EditBillingForm from "../../Components/Billing/EditBillingForm.vue";

defineProps({
    bill: Object,
    principals: Array,
});
</script>
