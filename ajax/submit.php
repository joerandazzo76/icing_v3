<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 1/30/2018
 * Time: 12:18 PM
 */

include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$cakeObject = new cake();
$cakeObject->setDateRange($_GET);
$cakeObject->processOfferTags();



