<?php

/**
 * Created by PhpStorm.
 * User: joera
 * Date: 1/29/2018
 * Time: 3:46 PM
 */
class cake
{
	
	public  $startdate;
	public  $enddate;
	public  $source_affiliate_id;
	public  $source_affiliate_name;
	public  $account_manager_id;
	public  $account_manager_name;
	public  $views;
	public  $clicks;
	public  $click_thru_percentage;
	public  $macro_event_conversions;
	public  $paid;
	public  $sellable;
	public  $micro_events;
	public  $macro_event_conversion_percentage;
	public  $cost;
	public  $average_cost;
	public  $epc;
	public  $revenue;
	public  $revenue_per_transaction;
	public  $margin;
	public  $profit;
	public  $pending;
	public  $rejected;
	public  $approved;
	public  $returned;
	public  $orders;
	public  $order_total;
	public  $average_order_value;
	public  $average_macro_event_conversion_score;
	public  $paid_events;
	public  $total_paid;
	public  $offerTag;
	private $reportArray = array();
	
	
	public function __construct()
	{
	
	}
	
	public function set($array)
	{
		
		foreach ($array as $arrayKey => $arrayKeyValue) {
			$this->$arrayKey = $arrayKeyValue;
		}
	}
	
	public function setDateRange($dateRange)
	{
		if (!isset($dateRange['startdate']) && !isset($dateRange['enddate'])) {
			throw new Exception("No date range set.");
		} else {
			$this->startdate = $dateRange['startdate'];
			$this->enddate   = $dateRange['enddate'];
		}
		
		
	}
	
	public function setEndDate($endDate)
	{
		if (!isset($endDate['enddate'])) {
			throw new Exception("No enddate set. \"enddate=yyyy-mm-dd\"");
		} else {
			$this->enddate = $endDate['enddate'];
		}
		
		
	}
	
	public function getData($offerTag)
	{
		$convertedOfferTag = cake::convertOfferTag($offerTag);
		$cakeApiKey        = getenv('cakeApiKey');
		echo_space("http://affiliate.moneylovers.com/api/3/reports.asmx/SourceAffiliateSummary?api_key=$cakeApiKey&start_date=$this->startdate&end_date=$this->enddate&source_affiliate_id=0&source_affiliate_manager_id=0&source_affiliate_tag_id=0&event_id=0&event_type=all&site_offer_tag_id=$convertedOfferTag");
		$xml_object =	simplexml_load_file("http://affiliate.moneylovers.com/api/3/reports.asmx/SourceAffiliateSummary?api_key=$cakeApiKey&start_date=$this->startdate&end_date=$this->enddate&source_affiliate_id=0&source_affiliate_manager_id=0&source_affiliate_tag_id=0&event_id=0&event_type=all&site_offer_tag_id=$convertedOfferTag");
		$json = json_encode($xml_object);
		
		if (json_decode($json, true)['row_count'] > 0) {
			
			
			return (json_decode($json, true)['source_affiliates']['source_affiliate_summary']);
		}
		
		return false;
	}
	
	public function getDataCount()
	{
		
		
		$xml_object =
			simplexml_load_file("http://affiliate.moneylovers.com/api/3/reports.asmx/SourceAffiliateSummary?api_key=$this->cakeApiKey&start_date=$this->startdate&end_date=$this->enddate&source_affiliate_id=0&source_affiliate_manager_id=0&source_affiliate_tag_id=0&event_id=0&event_type=all&site_offer_tag_id=0");
		
		$json = json_encode($xml_object);
		
		return json_decode($json, true)['row_count'];
		
	}
	
	public function insert()
	{
		if ($this->total_paid > 0) {
			
			
			$db  = DB::getInstance();
			$sql = " INSERT IGNORE INTO response (startdate,enddate,source_affiliate_id,source_affiliate_name,account_manager_id,account_manager_name,views,clicks,click_thru_percentage,macro_event_conversions,paid,sellable,micro_events,macro_event_conversion_percentage,cost,average_cost,epc,revenue,
 revenue_per_transaction,margin,profit,pending,rejected,approved,returned,orders,order_total,average_order_value,average_macro_event_conversion_score,paid_events,total_paid,offer_tag) VALUES (
:startdate,:enddate,:source_affiliate_id,:source_affiliate_name,:account_manager_id,:account_manager_name,:views,:clicks,:click_thru_percentage,:macro_event_conversions,:paid,:sellable,:micro_events,:macro_event_conversion_percentage,:cost,:average_cost,:epc,:revenue,:revenue_per_transaction,:margin,:profit,:pending,:rejected,:approved,:returned,:orders,:order_total,:average_order_value,:average_macro_event_conversion_score,:paid_events,:total_paid,:offer_tag) ";
			
			$stmt = $db->prepare($sql);
			$stmt->bindparam(":startdate", $this->startdate);
			$stmt->bindparam(":enddate", $this->enddate);
			$stmt->bindparam(":source_affiliate_id", $this->source_affiliate_id);
			$stmt->bindparam(":source_affiliate_name", $this->source_affiliate_name);
			$stmt->bindparam(":account_manager_id", $this->account_manager_id);
			$stmt->bindparam(":account_manager_name", $this->account_manager_name);
			$stmt->bindparam(":views", $this->views);
			$stmt->bindparam(":clicks", $this->clicks);
			$stmt->bindparam(":click_thru_percentage", $this->click_thru_percentage);
			$stmt->bindparam(":macro_event_conversions", $this->macro_event_conversions);
			$stmt->bindparam(":paid", $this->paid);
			$stmt->bindparam(":sellable", $this->sellable);
			$stmt->bindparam(":micro_events", $this->micro_events);
			$stmt->bindparam(":macro_event_conversion_percentage", $this->macro_event_conversion_percentage);
			$stmt->bindparam(":cost", $this->cost);
			$stmt->bindparam(":average_cost", $this->average_cost);
			$stmt->bindparam(":epc", $this->epc);
			$stmt->bindparam(":revenue", $this->revenue);
			$stmt->bindparam(":revenue_per_transaction", $this->revenue_per_transaction);
			$stmt->bindparam(":margin", $this->margin);
			$stmt->bindparam(":profit", $this->profit);
			$stmt->bindparam(":pending", $this->pending);
			$stmt->bindparam(":rejected", $this->rejected);
			$stmt->bindparam(":approved", $this->approved);
			$stmt->bindparam(":returned", $this->returned);
			$stmt->bindparam(":orders", $this->orders);
			$stmt->bindparam(":order_total", $this->order_total);
			$stmt->bindparam(":average_order_value", $this->average_order_value);
			$stmt->bindparam(":average_macro_event_conversion_score", $this->average_macro_event_conversion_score);
			$stmt->bindparam(":paid_events", $this->paid_events);
			$stmt->bindparam(":total_paid", $this->total_paid);
			$stmt->bindparam(":offer_tag", $this->offerTag);
			$stmt->execute();
		}
		
	}
	
	private static function convertOfferTag($site_offer_tag_id)
	{
		//CONVERTS "site_offer_tag_id" TO REAL VALUE 89, 65, 142, 55, 120, 54, 7, 56
//89  = 	$20
//65  = 	$25
//142 =		$30
//55  = 	$35
//120 = 	$37
//54  =  	$40
//195 = 	$45
//57  =  	$50
//56  =   	$60
		switch ($site_offer_tag_id) {
			case 20:
				$site_offer_tag_id = 89;
				break;
			
			case 25:
				$site_offer_tag_id = 65;
				break;
			
			case 30:
				$site_offer_tag_id = 142;
				break;
				
			case 32:
				$site_offer_tag_id = 121;
				break;
		
			case 35:
				$site_offer_tag_id = 55;
				break;
			
			case 37:
				$site_offer_tag_id = 120;
				break;
			
			case 40:
				$site_offer_tag_id = 54;
				break;
			
			case 45:
				$site_offer_tag_id = 195;
				break;
			
			case 50:
				$site_offer_tag_id = 57;
				break;
			
			case 60:
				$site_offer_tag_id = 56;
				break;
			
			default:
				$site_offer_tag_id = null;
		}
		
		
		return $site_offer_tag_id;
	}
	
	public function processOfferTags()
	{
		
		$offerTags = explode(',', getenv('offerTags'));
		
		foreach ($offerTags as $offerTagKey => $offerTagValue) {
			$this->offerTag = $offerTagValue;
			$responseArray  = $this->getData($this->offerTag);
			$this->processResponse($responseArray);
			
		}
		
	}
	
	private function processResponse($responseArray)
	{
		if (is_array($responseArray)) {
			foreach ($responseArray as $responseKey => $responseValue) {
				$this->setResponse($responseValue);
				$this->insert();
			}
		} else {
			return false;
		}
		
		
	}
	
	private function setResponse($responseValue)
	{
		if (is_array($responseValue)) {
			foreach (array_flatten($responseValue) as $key => $value) {
				$this->$key = $value;
			}
			
			return true;
		} else {
			return false;
		}
		
		
	}
	
	public function processReport()
	{
		
		
		$managers = explode(',', getenv('managers'));
		
		foreach ($managers as $manager => $managerName) {
			
			$managerReport = new managerReport($managerName);
			
		
			
			$managerReport->setTier();
			$managerReport->setOffer();
			
		}
	}
	public function processReport2()
	{
		
		
		$managers = explode(',', getenv('managers'));
		
		foreach ($managers as $manager => $managerName) {
			
			$managerReport = new managerReport($managerName);
			$managerReport->setTier();
			$managerReport->setOffer();
			
		}
	}
	
	public function selectOfferTagByEndDate($endDate, $offerTag)
	{
		$db  = DB::getInstance();
		$sql = "SELECT `source_affiliate_name`, `account_manager_name`,`total_paid`FROM `response` WHERE `enddate` = :enddate AND `offer_tag` = :offerTag ";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':enddate', $endDate, PDO::PARAM_STR);
		$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	

	

	
}