<?php

namespace App\Service;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function indexLog(array $logEntry)
    {
        $params = [
            'index' => 'logs',
            'body' => $logEntry
        ];
        $this->client->index($params);
    }
}
