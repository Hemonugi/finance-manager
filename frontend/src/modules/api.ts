import type { Account, Transaction, AddTransactionDto } from '@/types'
import { Exception } from 'sass'

class Api {
    private baseApiUrl: string

    constructor(url: string) {
        this.baseApiUrl = url
    }

    /**
     * Возвращает информацию о счете пользователя
     */
    getAccount(): Promise<Account> {
        return fetch(this.baseApiUrl + '/account/')
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    return data.data
                }

                alert(data.message)
            })
    }

    getTransactions(): Promise<Transaction[]> {
        return fetch(this.baseApiUrl + '/transactions/')
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    return data.data.map((transaction: any) => ({
                        id: transaction.id,
                        description: transaction.description,
                        value: transaction.value,
                        createdAt: new Date(transaction.createdAt),
                        updatedAt: new Date(transaction.updatedAt),
                    }));
                }

                alert(data.message)
            })
    }

    addTransaction(transactionDto: AddTransactionDto): Promise<Transaction> {
        return fetch(this.baseApiUrl + '/transactions/add/', {
            method: "POST",
            body: JSON.stringify(transactionDto)
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const transactionViewDto = data.data;
                    return {
                        id: transactionViewDto.id,
                        description: transactionViewDto.description,
                        value: transactionViewDto.value,
                        createdAt: new Date(transactionViewDto.createdAt),
                        updatedAt: new Date(transactionViewDto.updatedAt),
                    };
                }

                alert(data.message);

                throw new Error('Add transaction failed');
            })
    }
}

export const api = new Api('http://localhost:8083/api')
