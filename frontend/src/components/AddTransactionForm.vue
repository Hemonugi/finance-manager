<script setup lang="ts">
import { ref } from 'vue'
import { AddTransactionDto, Transaction } from '@/types'
import { api } from '@/modules/api'

const emit = defineEmits<{
    addTransaction: Transaction
}>()

const newTransaction = ref<AddTransactionDto>({
    description: '',
    value: 0
})

const showForm = ref<boolean>(false)

function addTransaction() {
    let description = newTransaction.value.description.trim()
    let value = newTransaction.value.value
    if (description !== '' && value !== 0) {
        api.addTransaction(newTransaction.value).then((transaction: Transaction) => {
            emit('addTransaction', transaction)
        })

        newTransaction.value = {
            description: '',
            value: 0
        }
    }
}
</script>

<template>
    <button @click="showForm = true" v-show="!showForm">Новая транзакция</button>
    <form v-show="showForm" @submit.prevent="addTransaction">
        <input v-model="newTransaction.description" />
        <input v-model="newTransaction.value" />
        <button>Добавить</button>
        <button @click='showForm = false'>Отмена</button>
    </form>
</template>

<style scoped></style>