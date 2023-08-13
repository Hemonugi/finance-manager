import type { Account, Transaction } from '@/types'

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
}

export const api = new Api('http://localhost:8083/api')
