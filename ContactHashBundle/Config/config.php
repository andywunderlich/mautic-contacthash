<?php

// arguments
// // 'mautic.helper.integration',
//'mautic.helper.integration', 'service_container'

return [
    'name'        => 'ContactHash',
    'description' => 'A Mautic plugin to automatically update add a hash to a contact based on their email',
    'version'     => '1.0',
    'author'      => 'Ben Poulson',

    'services' => [
        'events' => [
            'mautic.plugin.contacthash.subscriber' => [
                'class'     => MauticPlugin\ContactHashBundle\EventListener\ContactListener::class,
                'arguments' => [
                    'mautic.lead.model.lead'
                ],
            ],
        ],
    ],

    'integrations' => [
        'mautic.integration.contacthash' => [
            'class'     => \MauticPlugin\ContactHashBundle\Integration\ContactHashIntegration::class,
            'arguments' => [],
        ],
    ],
];
