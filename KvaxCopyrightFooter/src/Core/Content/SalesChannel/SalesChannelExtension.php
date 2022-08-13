<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\SalesChannel;
use Kvax\KvaxCopyrightFooter\Core\Content\Entities\SCCopyrightSettingDefinition;
use Kvax\KvaxCopyrightFooter\Core\Content\Entities\SCCopyrightTextDefinition;
use Kvax\KvaxCopyrightFooter\Core\Content\Entities\SCLanguageDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class SalesChannelExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new OneToManyAssociationField(
                'copyRightTexts',
                SCCopyrightTextDefinition::class,
                'sales_channel_id'
            ))->addFlags(new Inherited()),
        );

        $collection->add(
            (new OneToOneAssociationField(
                'copyRightSettings',
                'id',
                'sales_channel_id',
                SCCopyrightSettingDefinition::class,
                true
            ))
        );
    }

    public function getDefinitionClass(): string
    {
        return SalesChannelDefinition::class;
    }
}