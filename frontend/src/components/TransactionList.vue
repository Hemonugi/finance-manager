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
    <div class="transactions">
        <div class="transaction" v-for="transaction in transactions" :key="transaction.id">
            <div class="transaction__description">
                {{ transaction.description }}
            </div>
            <div class="transaction__value">
                {{ transaction.value }}
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.transaction {
    display: flex;
    justify-content: space-between;
    margin-top: 1em;
    margin-bottom: 1em;
    border-bottom: 1px dotted    var(--border-color);
}
</style>