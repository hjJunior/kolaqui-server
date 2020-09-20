<?php declare(strict_types=1);

return [
    'hosts' => [
        env('ELASTIC_HOST', env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')),
    ]
];
