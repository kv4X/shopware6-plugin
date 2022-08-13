<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Doctrine\DBAL\Connection;

class KvaxCopyrightFooter extends Plugin
{
    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);

        if ($context->keepUserData()) {
            return;
        }

        $connection = $this->container->get(Connection::class);
        $connection->executeUpdate('DROP TABLE IF EXISTS `sales_channel_copyright_texts`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `sales_channel_copyright_settings`');
        $connection->executeUpdate('ALTER TABLE `sales_channel` DROP COLUMN `copyRightTexts`');
        $connection->executeUpdate('ALTER TABLE `sales_channel` DROP COLUMN `copyRightSettings`');
    }
}