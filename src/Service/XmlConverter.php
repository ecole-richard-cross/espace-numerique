<?php

namespace App\Service;

use DOMDocument;
use Exception;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlConverter
{
    /**
     * Converts an object to an XML
     *
     * @param array $data
     * Data to serialize
     * 
     * @param string $rootName
     * Root level tagname
     * 
     * @return string
     * XML string
     */
    public function convertToXml(array $data, string $rootName = null, array $rootAttributes = []): string
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            }
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $xmlOptions = [
            'xml_format_output' => true,
            'xml_root_node_name' => $rootName,
            'as_collection' => true
        ];
        $encoders = [new XmlEncoder($xmlOptions)];

        $serializer = new Serializer([$normalizer, new ArrayDenormalizer()], $encoders);

        $rootNode = [
            ...$rootAttributes,
            '#' => CpfFormat($data)
        ];
        return $serializer->serialize(
            $rootNode,
            'xml'
        );
    }

    /**
     * Checks whether the provided $xml is valid against the provided $xsd
     *
     * @param string $xml
     * XML string to validate
     * @param string $xsd
     * XSD schema to validate against
     * @return boolean
     */
    public function validateXml(string $xml, string $xsd): bool
    {
        $xmlDocument = new DOMDocument();
        $xmlDocument->loadXML($xml);
        try {
            $xmlDocument->schemaValidate($xsd);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
