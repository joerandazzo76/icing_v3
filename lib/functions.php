<?php
/*
HEZECOM CMS PRO v1.0
http://hezecom.com
info@hezecom.com
COPYRIGHT 2012 ALL RIGHTS RESERVED
*/
//post
function post($var)
{
	if (isset($_POST[$var])) {
		return $_POST[$var];
	}
}

function get($var)
{
	if (isset($_GET[$var])) {
		return $_GET[$var];
	}
}

function array_flatten($array) {
	if (!is_array($array)) {
		return FALSE;
	}
	$result = array();
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$result = array_merge($result, array_flatten($value));
		}
		else {
			$result[$key] = $value;
		}
	}
	return $result;
}

function send_to($direction)
{
	if (!headers_sent()) {
		header('Location: ' . $direction);
		exit;
	} else {
		print '<script type="text/javascript">';
	}
	print 'window.location.href="' . $direction . '";';
	print '</script>';
	print '<noscript>';
	print '<meta http-equiv="refresh" content="0;url=' . $direction . '" />';
	print '</noscript>';
}

function sanitize($value)
{
	$sanitz = mysql_real_escape_string(filter_var($value, FILTER_SANITIZE_STRING));
	
	return $sanitz;
}

function print_x($value)
{
	echo '<pre style="text-align:left;"><hr />';
	print_r($value);
	echo '</pre><hr />';
}
function print_x_LARGE($value)
{
	echo '<pre style="text-align:left; font-size: 20pt"><hr />';
	print_r($value);
	echo '</pre><hr />';
}

function print_xJson($value)
{
	echo '<pre style="text-align:left;"><hr />';
	print_r(json_decode($value));
	echo '</pre><hr />';
}

function dd($value)
{
	echo '<pre style="text-align:left;"><hr />';
	print_r($value);
	echo '</pre><hr />';
	die();
}

function echoJson($data)
{
	echo json_decode($data);
}

function echo_space($data)
{
	echo "\n" . $data . "\n";
	
}

function echo_break($data)
{
	echo "<br>" . $data ;
	
}

