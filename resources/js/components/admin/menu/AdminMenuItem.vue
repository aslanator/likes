<template>
    <li class="nav-link" :class="[currentPage && currentPage.includes(pathName) ? 'active' : '']">
        <router-link :to="{ name: pathName }" class="nav-link">{{name}}</router-link>
    </li>
</template>

<script>
    export default {
        name: "AdminMenuItem",
        props: ['pathName', 'name', 'currentPage'],
    }
</script>

<style scoped>
    li.nav-link{
        background: darkgray;
        color: white;
        border-bottom: 1px solid black;
    }
    li.nav-link.active, li.nav-link:hover{
        background: gray;
    }
    .router-link-active{
        cursor: default;
    }
    .nav-link{
        color: white;
    }
</style>
