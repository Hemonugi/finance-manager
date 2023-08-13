<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { api } from '@/modules/api'
import { Transaction } from '@/types'

const transactions = ref<Transaction[]>([])

onMounted(() => {
    api.getTransactions().then((response) => (transactions.value = response))
})
</script>

<template>
    <div v-for="transaction in transactions" :key="transaction.id">
        <div>{{ transaction.description }}: {{ transaction.value }}</div>
    </div>
</template>

<style scoped></style>