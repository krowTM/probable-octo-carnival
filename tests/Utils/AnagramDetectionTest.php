<?php

namespace tests\Utils;

use PHPUnit_Framework_TestCase;
use Tour\Utils\AnagramDetection;

class AnagramDetectionTest extends PHPUnit_Framework_TestCase
{
    public function testIsAnagram1()
    {
        $ret = AnagramDetection::isAnagram('admirer', 'married');
        $this->assertTrue($ret);
    }

    public function testIsAnagram2()
    {
        $ret = AnagramDetection::isAnagram('AstroNomers', 'no more stars');
        $this->assertTrue($ret);
    }

    public function testIsAnagram3()
    {
        $ret = AnagramDetection::isAnagram('listen', 'silent');
        $this->assertTrue($ret);
    }

    public function testIsAnagram4()
    {
        $ret = AnagramDetection::isAnagram('THE EYES', 'THEY SEE');
        $this->assertTrue($ret);
    }

    public function testIsAnagram5()
    {
        $ret = AnagramDetection::isAnagram('THE EYES', 'THEY MEE');
        $this->assertFalse($ret);
    }
}