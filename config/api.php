<?php

return [
    'models' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'persbericht'   => [
            'fields' => [
                'connected'    => OWC\Persberichten\RestAPI\ItemFields\ConnectedField::class,
                'internal_info' => OWC\Persberichten\RestAPI\ItemFields\InternalField::class,
                'mailinglists' => OWC\Persberichten\RestAPI\ItemFields\TypeField::class,
                'spokesperson' => OWC\Persberichten\RestAPI\ItemFields\SpokespersonField::class,
                'subtitle' => OWC\Persberichten\RestAPI\ItemFields\SubtitleField::class,
            ],
        ]
    ],
];
