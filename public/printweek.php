<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 2/12/2018
 * Time: 12:41 PM
 */

include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
/*$offerTags  = explode(',', getenv('offerTags'));
$cakeObject = new cake();
foreach ($offerTags as $offerTagKey => $offerTagValue) {
	print_x($offerTagValue);
	print_x($cakeObject->printData("2018-02-11", "2018-02-12", $offerTagValue));
	
}*/

$db = new dboptions();
print_x($db->selectAllByStartDate("response", "2018-02-11"));




