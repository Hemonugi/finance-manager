<script setup lang="ts">
import { onMounted, ref } from 'vue'
import type { Account } from '@/types'
import { api } from '@/modules/api'

const account = ref<Account>({
    value: 0
})

onMounted(() => {
    api.getAccount()
        .then((response) => (account.value = response))
})
</script>

<template>
    <div>Баланс: {{ account.value }}</div>
</template>

<style scoped></style>