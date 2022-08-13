<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Language\LanguageEntity;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class SCCopyrightSettingEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $sales_channel_id;

    /**
     * @var string
     */
    protected $color;

    public function getSalesChannel(): ?SalesChannelEntity
    {
        return $this->sales_channel_id;
    }

    public function setSalesChannel(SalesChannelEntity $sales_channel_id): void
    {
        $this->sales_channel_id = $sales_channel_id;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}