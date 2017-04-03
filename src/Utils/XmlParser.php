<?php

namespace Tour\Utils;

use Prewk\XmlStringStreamer;

class XmlParser
{
    const TAG_NAME = 'TOUR';

    private $xmlFile;

    /**
     * XmlParser constructor.
     *
     * @param $xmlFile string file to parse
     */
    public function __construct($xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }

    /**
     * does the actual conversion of the XML and saving
     */
    public function convert()
    {
        $streamer = XmlStringStreamer::createUniqueNodeParser(
            $this->xmlFile,
            ['uniqueNode' => self::TAG_NAME]
        );

        $this->saveData([
            'Title',
            'Code',
            'Duration',
            'Inclusions',
            'MinPrice'
        ]);

        while ($node = $streamer->getNode()) {
            $xmlNode = simplexml_load_string($node);
            $data = $this->processNode($xmlNode);
            $this->saveData($data);
        }
    }

    /**
     * processes the SimpleXMLElement $node and converts it to
     * an array of required information
     *
     * @param \SimpleXMLElement $node
     *
     * @return array
     */
    public function processNode(\SimpleXMLElement $node)
    {
        $data = [];
        $data['Title'] = html_entity_decode((string)$node->Title);
        $data['Code'] = (string)$node->Code;
        $data['Duration'] = (int)$node->Duration;
        $data['Inclusions'] = $this->cleanText((string)$node->Inclusions);

        $minPrice = PHP_INT_MAX;
        foreach ($node->DEP as $dep) {
            $price = floatval($dep['EUR']);
            if (isset($dep['DISCOUNT'])) {
                $price -= $price * floatval($dep['DISCOUNT']) / 100;
            }
            $minPrice = min($minPrice, $price);
        }
        $data['MinPrice'] = number_format($minPrice, 2, '.', '');

        return $data;
    }

    /**
     * ouputs the info to the console
     *
     * @param array $data info to output
     */
    public function saveData(array $data)
    {
        echo implode('|', $data).PHP_EOL;
    }

    /**
     * cleans text and prepares for saving
     *
     * @param $text
     *
     * @return string
     */
    private function cleanText($text)
    {
        $text = strip_tags($text);
        $text = html_entity_decode($text);
        $text = preg_replace('!\s+!u', ' ', $text);

        return trim($text);
    }
}