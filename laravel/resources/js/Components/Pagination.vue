<template>
    <nav class="flex justify-center">
        <ul class="pagination">
            <li v-for="(link, index) in links" :key="index" class="page-item" :class="{ 'active': link.active, 'disabled': link.url === null }">
                <a class="page-link" :href="link.url" v-if="link.url" @click.prevent="setPage(link.url)" v-html="link.label"></a>
                <span v-else class="page-link" v-html="link.label"></span>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        links: {
            type: Array,
            required: true,
        },
    },
    methods: {
        setPage(url) {
            this.$inertia.visit(url);
        },
    },
};
</script>

<style scoped>
.pagination {
    display: flex;
    list-style: none;
}
.page-item:not(:last-child) {
    margin-right: .25rem;
}
.page-link {
    color: #3490dc;
    display: block;
    padding: .5rem .75rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}
.page-item.active .page-link {
    background: #3490dc;
    color: #fff;
}
.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
}
</style>
