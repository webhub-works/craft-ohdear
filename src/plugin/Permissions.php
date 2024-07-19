<?php

namespace webhubworks\ohdear\plugin;

use craft\events\RegisterUserPermissionsEvent;

class Permissions
{
    public static function handle(RegisterUserPermissionsEvent $event)
    {
        $event->permissions['Oh Dear'] = [
            'heading' => 'Oh Dear',
            'permissions' => [
                'ohdear:plugin-settings' => [
                    'label' => \Craft::t('ohdear', 'Manage plugin settings'),
                ],
                'ohdear:view-overview' => [
                    'label' => \Craft::t('ohdear', 'View overview page'),
                ],
                'ohdear:view-uptime' => [
                    'label' => \Craft::t('ohdear', 'View uptime'),
                    'nested' => [
                        'ohdear:toggle-uptime-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle uptime check'),
                        ],
                        'ohdear:request-uptime-check' => [
                            'label' => \Craft::t('ohdear', 'Request uptime check'),
                        ],
                    ],
                ],
                'ohdear:view-broken-links' => [
                    'label' => \Craft::t('ohdear', 'View broken links'),
                    'nested' => [
                        'ohdear:toggle-broken-links-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle broken links check'),
                        ],
                        'ohdear:request-broken-links-check' => [
                            'label' => \Craft::t('ohdear', 'Request broken links check'),
                        ],
                    ],
                ],
                'ohdear:view-mixed-content' => [
                    'label' => \Craft::t('ohdear', 'View mixed content'),
                    'nested' => [
                        'ohdear:toggle-mixed-content-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle mixed content check'),
                        ],
                        'ohdear:request-mixed-content-check' => [
                            'label' => \Craft::t('ohdear', 'Request mixed content check'),
                        ],
                    ],
                ],
                'ohdear:view-certificate-health' => [
                    'label' => \Craft::t('ohdear', 'View certificate health'),
                    'nested' => [
                        'ohdear:toggle-certificate-health-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle certificate health check'),
                        ],
                        'ohdear:request-certificate-health-check' => [
                            'label' => \Craft::t('ohdear', 'Request certificate health check'),
                        ],
                    ],
                ],
                'ohdear:view-lighthouse' => [
                    'label' => \Craft::t('ohdear', 'View Lighthouse'),
                    'nested' => [
                        'ohdear:toggle-lighthouse-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle lighthouse check'),
                        ],
                        'ohdear:request-lighthouse-check' => [
                            'label' => \Craft::t('ohdear', 'Request lighthouse check'),
                        ],
                    ],
                ],
                'ohdear:view-application-health' => [
                    'label' => \Craft::t('ohdear', 'View application health'),
                    'nested' => [
                        'ohdear:toggle-application-health-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle application health check'),
                        ],
                        'ohdear:request-application-health-check' => [
                            'label' => \Craft::t('ohdear', 'Request application health check'),
                        ],
                    ],
                ],
                'ohdear:view-performance' => [
                    'label' => \Craft::t('ohdear', 'View performance'),
                    'nested' => [
                        'ohdear:toggle-performance-check' => [
                            'label' => \Craft::t('ohdear', 'Toggle performance check'),
                        ],
                        'ohdear:request-performance-check' => [
                            'label' => \Craft::t('ohdear', 'Request performance check'),
                        ],
                    ],
                ],
                'ohdear:view-utility' => [
                    'label' => \Craft::t('ohdear', 'View application health utility'),
                ]
            ],
        ];
}
}
