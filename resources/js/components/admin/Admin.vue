<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 sidebar">
                <AdminMenu/>
            </div>
            <div class="col-10 ml-auto">
                <router-view/>
            </div>
        </div>
    </div>
</template>

<script>
    import VueRouter from 'vue-router';
    import AdminMenu from './menu/AdminMenu';
    import NewsIndex from './crud/news/Index';
    import NewsEdit from './crud/news/Edit';
    import PhotoIndex from './crud/photo/Index';
    import PhotoEdit from './crud/photo/Edit';

    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/admin/news',
                name: 'admin-news',
                component: NewsIndex,
            },
            {
                path: '/admin/news/edit',
                name: 'admin-news-edit',
                component: NewsEdit,
                props(route) {
                    return {  id: route.query.id }
                }
            },
            {
                path: '/admin/photo',
                name: 'admin-photo',
                component: PhotoIndex,
            },
            {
                path: '/admin/photo/edit',
                name: 'admin-photo-edit',
                component: PhotoEdit,
                props(route) {
                    return {  id: route.query.id }
                }
            },
        ]
    });

    export default {
        name: "Admin",
        components: {
            AdminMenu,
        },
        router,
        mounted() {
        }
    }
</script>

<style scoped>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }
</style>
