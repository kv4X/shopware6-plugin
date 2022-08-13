<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1660323604 extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public function getCreationTimestamp(): int
    {
        return 1660323604;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `sales_channel_copyright_texts` (
              `sales_channel_id` BINARY(16) NOT NULL,
              `language_id` BINARY(16) NOT NULL,
              `text` VARCHAR(255),
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`sales_channel_id`, `language_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `sales_channel_copyright_settings` (
              `sales_channel_id` BINARY(16) NOT NULL,
              `color` VARCHAR(255),
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`sales_channel_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->updateInheritance($connection, 'sales_channel', 'copyRightTexts');
        $this->updateInheritance($connection, 'sales_channel', 'copyRightSettings');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
