<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 2/12/2018
 * Time: 10:49 AM
 */

include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');


$db = new dboptions();
$db->truncateTable("response");

