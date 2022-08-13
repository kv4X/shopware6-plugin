<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Core\Content\Entities;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Language\LanguageEntity;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class SCCopyrightTextEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $sales_channel_id;

    /**
     * @var string
     */
    protected $language_id;

    /**
     * @var string
     */
    protected $text;

    public function getSalesChannel(): ?SalesChannelEntity
    {
        return $this->sales_channel_id;
    }

    public function setSalesChannel(SalesChannelEntity $sales_channel_id): void
    {
        $this->sales_channel_id = $sales_channel_id;
    }

    public function getLanguage(): ?LanguageEntity
    {
        return $this->language_id;
    }

    public function setLanguage(LanguageEntity $language_id): void
    {
        $this->language_id = $language_id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}