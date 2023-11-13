<?php

use Symfony\Component\HttpClient\HttpClient;

class PostalCodeTools
{

    public static function fetchDetails(string $postalCode): array
    {

        $client = HttpClient::create();

        $apiRoot = "https://api-adresse.data.gouv.fr/search/?q=";
        $response = $client->request(
            'GET',
            $apiRoot . $postalCode
        );
        $content = $response->toArray();
        $props = $content['features'][0]['properties'];
        $context = trim(explode(',', $props['context']));
        $dep = "$context[1] ($context[0])";
        $region = $context[2];
        return [
            "postalCode" => $postalCode,
            "department" => $dep,
            "region" => $region
        ];
    }
}