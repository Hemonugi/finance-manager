<script setup lang="ts">
import { RouterView } from 'vue-router'
import AccountInfo from '@/components/AccountInfo.vue'
</script>

<template>
    <header>
        <AccountInfo />
    </header>
    <main>
        <RouterView />
    </main>
</template>

<style scoped>
header, main {
    padding: 1em;
}

header {
    text-align: center;
    border-bottom: 1px solid var(--border-color);
}
</style>
