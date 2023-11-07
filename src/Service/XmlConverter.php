<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlConverter
{
    private $serializer;

    public function __construct()
    {
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new XmlEncoder()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function convertToXml($data): string
    {
        return $this->serializer->serialize($data, 'xml');
    }
}
