<script setup>
import { inject } from 'vue'

const itens = inject('menuItens');
</script>

<template>
    <ul class="navbar-nav ms-auto" v-for="item in itens" :key="item.to">
        <li class="nav-item mx-0 mx-lg-1"><RouterLink class="nav-link py-3 px-0 px-lg-3 rounded" :to="item.to">{{item.label}}</RouterLink></li>
    </ul>
</template>

<style scoped>

</style>
