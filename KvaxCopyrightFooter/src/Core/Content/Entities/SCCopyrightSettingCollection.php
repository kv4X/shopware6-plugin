<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(SCCopyrightSettingEntity $entity)
 * @method void              set(string $key, SCCopyrightSettingEntity $entity)
 * @method SCCopyrightSettingEntity[]    getIterator()
 * @method SCCopyrightSettingEntity[]    getElements()
 * @method SCCopyrightSettingEntity|null get(string $key)
 * @method SCCopyrightSettingEntity|null first()
 * @method SCCopyrightSettingEntity|null last()
 */
class SCCopyrightSettingCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SCCopyrightSettingEntity::class;
    }
}
