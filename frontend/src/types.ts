/**
 * Информация о счете пользователя
 */
export interface Account {
    /**
     * Сумма на счету
     */
    value: number
}

export interface Transaction {
    /**
     * Уникальный идентификатор транзакции
     */
    id: number
    /**
     * Краткое описание транзакции
     */
    description: string
    /**
     * Сумма транзакции
     */
    value: number
    /**
     * Дата добавления транзакции
     */
    createdAt: Date
    /**
     * Дата обновления транзакции
     */
    updatedAt: Date
}
