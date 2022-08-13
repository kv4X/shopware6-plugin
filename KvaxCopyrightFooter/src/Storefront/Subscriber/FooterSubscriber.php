<?php declare(strict_types=1);

namespace Kvax\KvaxCopyrightFooter\Storefront\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FooterSubscriber implements EventSubscriberInterface
{

    /** @var SystemConfigService */
    private $systemConfigService;

    /** @var EntityRepositoryInterface */
    private $salesChannelRepository;

    /** @var EntityRepositoryInterface */
    private $salesChannelTextRepository;

    /** @var EntityRepositoryInterface */
    private $salesChannelSettingRepository;

    public function __construct(
        SystemConfigService $systemConfigService,
        EntityRepositoryInterface $salesChannelRepository,
        EntityRepositoryInterface $salesChannelSettingRepository,
        EntityRepositoryInterface $salesChannelTextRepository
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->salesChannelRepository = $salesChannelRepository;
        $this->salesChannelSettingRepository = $salesChannelSettingRepository;
        $this->salesChannelTextRepository = $salesChannelTextRepository;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            StorefrontRenderEvent::class => 'onStoreFrontRendered',
        ];
    }

    /**
     * @throws InconsistentCriteriaIdsException
     */
    public function onStoreFrontRendered(StorefrontRenderEvent $event): void
    {
        $context = $event->getContext();

        $salesChannelContext = $event->getSalesChannelContext();
        $salesChannelId = $salesChannelContext->getSalesChannel()->getId();
        $languageId = $salesChannelContext->getSalesChannel()->getLanguageId();


        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('salesChannelId', $salesChannelId));
        $criteria->addFilter(new EqualsFilter('languageId', $languageId));
        $checkIsTextsExists = $this->salesChannelTextRepository->search($criteria, $context)->first();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('salesChannelId', $salesChannelId));
        $checkIsSettingExists = $this->salesChannelSettingRepository->search($criteria, $context)->first();


        $text = 'Copyright © signundsinn GmbH';
        $color = '#eb4034';

        if($checkIsTextsExists) {
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('id', $salesChannelId));
            $criteria->addAssociation('languages');
            $criteria->addAssociation('copyRightTexts');

            if($checkIsSettingExists) {
                $criteria->addAssociation('copyRightSettings');
            }

            $salesChannel = $this->salesChannelRepository->search($criteria, $context)->first();

            $copyRightText = $salesChannel->extensions['copyRightTexts']->get($salesChannelId . '-' . $languageId);
            $copyRightSettings = isset($salesChannel->extensions['copyRightSettings']) ? $salesChannel->extensions['copyRightSettings'] : null;

            $text = $copyRightText->text;
            $color = $copyRightSettings->color;
        }

        $extensions = $salesChannelContext->getExtensions();
        $extensions['copyRightTexts']["config"] = [
            'text' => $text,
            'color' => $color,
        ];
        $salesChannelContext->setExtensions($extensions);
    }
}
