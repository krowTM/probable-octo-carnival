<?php

require(__DIR__.'/../vendor/autoload.php');

$file = 'data.xml';
$xmlParser = new \Tour\Utils\XmlParser($file);
echo PHP_EOL;
$xmlParser->convert();
echo PHP_EOL;