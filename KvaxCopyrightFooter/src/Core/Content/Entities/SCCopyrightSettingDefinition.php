<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class SCCopyrightSettingDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'sales_channel_copyright_settings';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return SCCopyrightSettingCollection::class;
    }

    public function getEntityClass(): string
    {
        return SCCopyrightSettingEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('sales_channel_id', 'salesChannelId', SalesChannelDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('color', 'color'))->addFlags(new Required()),
            new OneToOneAssociationField('sales_channel', 'sales_channel_id', 'id', SalesChannelDefinition::class, false),
            new CreatedAtField(),
        ]);
    }
}