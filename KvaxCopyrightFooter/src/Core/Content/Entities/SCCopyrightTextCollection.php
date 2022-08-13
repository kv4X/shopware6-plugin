<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(SCCopyrightTextEntity $entity)
 * @method void              set(string $key, SCCopyrightTextEntity $entity)
 * @method SCCopyrightTextEntity[]    getIterator()
 * @method SCCopyrightTextEntity[]    getElements()
 * @method SCCopyrightTextEntity|null get(string $key)
 * @method SCCopyrightTextEntity|null first()
 * @method SCCopyrightTextEntity|null last()
 */
class SCCopyrightTextCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SCCopyrightTextEntity::class;
    }
}
