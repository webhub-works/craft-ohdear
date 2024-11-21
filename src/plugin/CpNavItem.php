<?php

namespace webhubworks\ohdear\plugin;

use craft\elements\User;
use webhubworks\ohdear\models\Settings;
use webhubworks\ohdear\services\BadgeCountService;

class CpNavItem
{
    public static function get(array &$cpNavItem, Settings $settings, BadgeCountService $badgeCountService): ?array
    {
        if ($settings->showNavBadges) {
            $cpNavItem['badgeCount'] = $badgeCountService->getTotalCount();
        }

        /** @var User|null $currentUser */
        $currentUser = \Craft::$app->getUser()->getIdentity();

        if ($currentUser === null) {
            return $cpNavItem;
        }

        if (! $currentUser->can('ohdear:view-overview')) {
            return null;
        }

        if (! $settings->hasApiCredentials()) {
            return $cpNavItem;
        }

        if (! $currentUser->can('accessPlugin-ohdear')) {
            return $cpNavItem;
        }

        if ($currentUser->can('ohdear:view-overview')) {
            $cpNavItem['subnav']['overview'] = [
                'url' => 'ohdear/overview',
                'label' => \Craft::t('ohdear', 'Overview'),
            ];
        }

        if ($currentUser->can('ohdear:view-uptime')) {
            $cpNavItem['subnav']['uptime'] = [
                'url' => 'ohdear/uptime',
                'label' => \Craft::t('ohdear', 'Uptime'),
            ];
        }

        if ($currentUser->can('ohdear:view-broken-links')) {
            $cpNavItem['subnav']['broken-links'] = [
                'url' => 'ohdear/broken-links',
                'label' => \Craft::t('ohdear', 'Broken Links'),
            ];
            if ($settings->showNavBadges) {
                $cpNavItem['subnav']['broken-links']['badgeCount'] = $badgeCountService->getBrokenLinksCount();
            }
        }

        if ($currentUser->can('ohdear:view-mixed-content')) {
            $cpNavItem['subnav']['mixed-content'] = [
                'url' => 'ohdear/mixed-content',
                'label' => \Craft::t('ohdear', 'Mixed Content'),
            ];
            if ($settings->showNavBadges) {
                $cpNavItem['subnav']['mixed-content']['badgeCount'] = $badgeCountService->getMixedContentCount();
            }
        }

//        if ($currentUser->can('ohdear:view-lighthouse')) {
//            $cpNavItem['subnav']['lighthouse'] = [
//                'url' => 'ohdear/lighthouse',
//                'label' => \Craft::t('ohdear', 'Lighthouse'),
//            ];
//        }

        if ($currentUser->can('ohdear:view-certificate-health')) {
            $cpNavItem['subnav']['certificate-health'] = [
                'url' => 'ohdear/certificate-health',
                'label' => \Craft::t('ohdear', 'Certificate Health'),
            ];
        }

        if ($currentUser->can('ohdear:view-application-health')) {
            $cpNavItem['subnav']['application-health'] = [
                'url' => 'ohdear/application-health',
                'label' => \Craft::t('ohdear', 'Application Health'),
            ];
        }

        if ($currentUser->can('ohdear:view-performance')) {
            $cpNavItem['subnav']['performance'] = [
                'url' => 'ohdear/performance',
                'label' => \Craft::t('ohdear', 'Performance'),
            ];
        }

        return $cpNavItem;
}
}
