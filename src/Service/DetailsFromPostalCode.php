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
        if (!isset($content['features'][0]))
            return [
                "postalCode" => $postalCode,
                "department" => '',
                "region" => ''
            ];
        $props = $content['features'][0]['properties'];

        $context = array_map(function ($string) {
            return trim($string);
        }, explode(',', $props['context']));

        $dep = "$context[1] ($context[0])";
        $region = $context[2];
        return [
            "postalCode" => $postalCode,
            "department" => $dep,
            "region" => $region
        ];
    }
}
