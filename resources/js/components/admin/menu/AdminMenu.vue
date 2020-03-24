<template>
    <ul class="nav flex-column">
        <AdminMenuItem path-name="admin-news" name="News" :current-page="currentPage"/>
        <AdminMenuItem path-name="admin-photo" name="Photo" :current-page="currentPage"/>
    </ul>
</template>

<script>
    import AdminMenuItem from './AdminMenuItem';

    export default {
        name: "AdminMenu",
        components: {
            AdminMenuItem
        },
        computed: {
            currentPage() {
                return this.$route.name;
            },
        },
    }
</script>

<style scoped>

</style>
