import type { Account } from '@/types'

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

                alert(data.message);
            })
    }
}

export const api = new Api('http://localhost:8083/api')
