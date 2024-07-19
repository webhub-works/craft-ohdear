<?php

namespace webhubworks\ohdear\plugin;

use craft\elements\User;
use craft\events\RegisterUrlRulesEvent;

class CpRoutes
{
    public static function handle(RegisterUrlRulesEvent $event): void
    {
        /** @var User|null $currentUser */
        $currentUser = \Craft::$app->getUser()->getIdentity();

        if (is_null($currentUser)) {
            return;
        }

        if ($currentUser->can('ohdear:view-overview')) {
            $event->rules['ohdear'] = ['template' => 'ohdear/overview'];
            $event->rules['ohdear/overview'] = ['template' => 'ohdear/overview'];
        }
        if ($currentUser->can('ohdear:view-uptime')) {
            $event->rules['ohdear/uptime'] = ['template' => 'ohdear/uptime'];
        }
        if ($currentUser->can('ohdear:view-broken-links')) {
            $event->rules['ohdear/broken-links'] = ['template' => 'ohdear/broken-links'];
        }
        if ($currentUser->can('ohdear:view-mixed-content')) {
            $event->rules['ohdear/mixed-content'] = ['template' => 'ohdear/mixed-content'];
        }
        if ($currentUser->can('ohdear:view-certificate-health')) {
            $event->rules['ohdear/certificate-health'] = ['template' => 'ohdear/certificate-health'];
        }
        if ($currentUser->can('ohdear:view-lighthouse')) {
            $event->rules['ohdear/lighthouse'] = ['template' => 'ohdear/lighthouse'];
        }
        if ($currentUser->can('ohdear:view-application-health')) {
            $event->rules['ohdear/application-health'] = ['template' => 'ohdear/application-health'];
        }
        if ($currentUser->can('ohdear:view-performance')) {
            $event->rules['ohdear/performance'] = ['template' => 'ohdear/performance'];
        }
}
}
