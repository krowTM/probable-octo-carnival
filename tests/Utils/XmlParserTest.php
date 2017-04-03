<?php

namespace tests\Utils;

use PHPUnit_Framework_TestCase;
use Tour\Utils\XmlParser;

class XmlParserTest extends PHPUnit_Framework_TestCase
{
    public function testProcessNode()
    {
        $xml = '<TOUR>
        <Title><![CDATA[Anzac &amp; Egypt Combo Tour]]></Title>
        <Code>AE-19</Code>
        <Duration>18</Duration>
        <Start>Istanbul</Start>
        <End>Cairo</End>
        <Inclusions>
            <![CDATA[<div style="margin: 1px 0px; padding: 1px 0px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; text-align: justify; line-height: 19px; color: rgb(6, 119, 179);">The tour price&nbsp; cover the following services: <b style="margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: baseline; background-color: transparent;">Accommodation</b>; 5, 4&nbsp;and&nbsp;3 star hotels&nbsp;&nbsp;</div>]]>
        </Inclusions>
        <DEP DepartureCode="AN-17" Starts="04/19/2015" GBP="1458" EUR="1724" USD="2350" DISCOUNT="15%" />
        <DEP DepartureCode="AN-18" Starts="04/22/2015" GBP="1558" EUR="1784" USD="2550" DISCOUNT="20%" />
        <DEP DepartureCode="AN-19" Starts="04/25/2015" GBP="1558" EUR="1784" USD="2550" />
    </TOUR>';

        $xmlNode = simplexml_load_string($xml);
        $xmlParser = new XmlParser(null);

        $data = $xmlParser->processNode($xmlNode);

        $this->assertEquals('Anzac & Egypt Combo Tour', $data['Title']);
        $this->assertEquals('AE-19', $data['Code']);
        $this->assertEquals(18, $data['Duration']);
        $this->assertEquals(
            'The tour price cover the following services: Accommodation; 5, 4 and 3 star hotels',
            $data['Inclusions']
        );
        $this->assertEquals(1427.20, $data['MinPrice']);
    }
}