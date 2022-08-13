<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities\Aggregate;

use Shopware\Core\System\Language\LanguageDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;

class SalesChannelCopyrightTextDefinition extends MappingEntityDefinition
{
    public function getEntityName(): string
    {
        return 'sales_channel_copyright_texts';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('sales_channel_id', 'salesChannelId', SalesChannelDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('language_id', 'languageId', LanguageDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('language', 'language_id', LanguageDefinition::class),
            new ManyToOneAssociationField('sales_channel', 'sales_channel_id', SalesChannelDefinition::class),
            new CreatedAtField(),
        ]);
    }
}
