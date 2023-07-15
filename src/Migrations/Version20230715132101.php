<?php

declare(strict_types=1);

namespace Hemonugi\FinanceManager\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230715132101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляет таблицу с транзакциями';
    }

    public function up(Schema $schema): void
    {
        $baseQuery = <<<SQL
            create table transactions
            (
                id          serial
                    constraint transactions_pk
                        primary key,
                description varchar(255)                        not null,
                value       double precision                    not null,
                created_at  timestamp default CURRENT_TIMESTAMP not null,
                updated_at  timestamp default CURRENT_TIMESTAMP not null
            );
            
            comment on table transactions is 'Расходы и доходы';
            comment on column transactions.description is 'Краткое описание транзакции';
            comment on column transactions.value is 'Сумма транзакции';
        SQL;

        $queries = array_filter(explode(';', $baseQuery));
        foreach ($queries as $query) {
            $this->addSql($query);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE transactions");
    }
}
