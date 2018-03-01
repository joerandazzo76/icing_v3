<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 2/13/2018
 * Time: 10:28 AM
 */

class managerReport
{
	
	
	public $account_manager_name = '';
	
	public $totalPaid      = '';
	public $rip            = '0';
	public $commission     = '0';
	public $tire2Commision = '0';
	
	private $offerTag = '';
	public  $tier     = '';
	public  $affArray = array();
	private $totalPerTag;
	private $totalSalesByEndDate;
	private $totalPaidDollarAmount;
	
	
	/**
	 * managerReport constructor.
	 */
	public function __construct($managerName)
	{
		$this->account_manager_name = $managerName;
		
		
	}
	
	public static function getAffSalesTotal()
	{
	
		
	}
	
	public function setTier()
	{
		$tier2Managers = explode(',', getenv('tier2Managers'));
		$tier3Managers = explode(',', getenv('tier3Managers'));
		$this->tier    = '1';
		if (in_array($this->account_manager_name, $tier2Managers)) {
			$this->tier = '2';
		}
		if (in_array($this->account_manager_name, $tier3Managers)) {
			$this->tier = '3';
		}
		
	}
	
	public function printManagerReport()
	{
		print_x($this);
		
	}
	
	public	function getAffiliatesSalesByOfferTag()
	{
		$db  = DB::getInstance();
		$sql = "SELECT `source_affiliate_name`,`total_paid`FROM `response` WHERE `account_manager_name` = :account_manager_name AND `offer_tag` = :offer_tag";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		$stmt->bindParam(':offer_tag', $this->offerTag, PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function getAffiliatesSalesByManager()
	{
		$db  = DB::getInstance();
		$sql = "SELECT `source_affiliate_name`,`total_paid`FROM `response` WHERE `account_manager_name` = :account_manager_name";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function setOffer()
	{
		$report    = new report();
		$offerTags = explode(',', getenv('offerTags'));
		
		foreach ($this->getManagersAff() as $affKey => $affValue) {
			$this->totalPaidDollarAmount = '0';
			$this->affArray[$affKey]     = $affValue;
			$this->tire2Commision        = 0;
			if ($this->account_manager_name == "070-Jorayn Salamera"){
				
				$this->special070();
			}
			if ($this->account_manager_name == "093-Jaydee Cruz"){
				
				$this->special093();
			}
			
			foreach ($offerTags as $offerTag) {
				
				$this->affArray[$affKey]->sales[$offerTag] = $this->getSalesByAff($affValue->source_affiliate_name, $offerTag);
				
				if ($this->tier == '3' && $offerTag == "30") {
					$this->tire2Commision = $this->tire2Commision + ($this->setTotalPerOfferTag($offerTag) * 2);
					
				}
				if ((($this->tier == '2') || ($this->tier == '3')) && ($offerTag == "35")) {
					$this->tire2Commision = $this->tire2Commision + ($this->setTotalPerOfferTag($offerTag) * 2);
					
				}
				if ((($this->tier == '2') || ($this->tier == '3')) && ($offerTag == "40")) {
					$this->tire2Commision = $this->tire2Commision + ($this->setTotalPerOfferTag($offerTag) * 2);
					
				}
				
				
			}
			
		}
		
		foreach ($offerTags as $offerTag) {
			$this->setTotalPerOfferTag($offerTag);
			$this->commission = $this->commission + $this->getCommissionByOfferTag($offerTag);
			
		}
		
		$this->setTotalPaid();
		//$this->getCommission();
		$this->getRip();


//		print_x($this);
		//$report->printManagerHTMLTable($this->account_manager_name, $this->affArray);
		$report->printManagerMasterReport($this->account_manager_name, $this);
		
		
	}
	
	private	function getCommissionByOfferTag($offerTag)
	{
		
		
		$db = DB::getInstance();
		switch ($this->account_manager_name) {
			case "070-Jorayn Salamera":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"074-Jayson Tuazon\",\"074-2 Jayson Tuazon\",\"074-3-Jayson Tuazon\",\"074-4-Jayson Tuazon\",\"075-John Paul Ramirez\",\"076-Reynaldo I-1\",\"077-Reynaldo I-2\",\"078-Bruno\",\"089-Roman E\",\"094-Ludacris\", \"081-Bernard S\",\"075-4 ang\",\"075-2 - JPR Hubweb2\",\"075-3 anj\",\"075-5 pc\") AND `offer_tag` = :offerTag";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
				$stmt->execute();
				
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				
				
				if ($response != null) {
					if ($offerTag <= '45') {
						$response = $response * 2;
						
						return $response;
					} else {
						$response = $response * 3;
						
						return $response;
					}
					
				} else {
					return '0';
				}
				break;
			
			case "074-Jayson Tuazon":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"076-Reynaldo I-1\",\"077-Reynaldo I-2\") AND `offer_tag` = :offerTag";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
				$stmt->execute();
				
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				
				
				if ($response != null) {
					if ($offerTag <= '45') {
						$response = $response * 2;
						
						return $response;
					} else {
						$response = $response * 3;
						
						return $response;
					}
					
				} else {
					return '0';
				}
				break;
			
			case "081-Bernard S":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"076-Reynaldo I-1\",\"077-Reynaldo I-2\") AND `offer_tag` = :offerTag";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
				$stmt->execute();
				
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				
				
				if ($response != null) {
					if ($offerTag <= '45') {
						$response = $response * 2;
						
						return $response;
					} else {
						$response = $response * 3;
						
						return $response;
					}
					
				} else {
					return '0';
				}
				break;
			case "093-Jaydee Cruz":
				$sql  =
					"SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"074-Jayson Tuazon\",\"074-2 Jayson Tuazon\",\"074-3-Jayson Tuazon\",\"074-4-Jayson Tuazon\",\"075-John Paul Ramirez\",\"076-Reynaldo I-1\",\"077-Reynaldo I-2\",\"078-Bruno\",\"089-Roman E\",\"094-Ludacris\", \"081-Bernard S\",\"075-4 ang\",\"075-2 - JPR Hubweb2\",\"075-3 anj\",\"075-5 pc\",\"070-Jorayn Salamera\") AND `offer_tag` = :offerTag";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
				$stmt->execute();
				
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				
				
				if ($response != null) {
					return $response;
					
					
				} else {
					return '0';
				}
				break;
			
			
		}
		
		
	}
	
	private	function getRip()
	{
		
		$db = DB::getInstance();
		
		switch ($this->account_manager_name) {
			case "093-Jaydee Cruz":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"074-Jayson Tuazon\",\"075-John Paul Ramirez\",\"076-Reynaldo I-1\",\"077-Reynaldo I-2\",\"078-Bruno\",\"089-Roman E\",
\"094-Ludacris\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				if ($response != null) {
					$this->rip = $response;
				} else {
					$this->rip = '0';
				}
				
				break;
			
		}
	}
	
	private	function getManagersAff()
	{
		$db  = DB::getInstance();
		$sql = "SELECT DISTINCT `source_affiliate_name` FROM `response` WHERE `account_manager_name` = :account_manager_name";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
		
		
	}
	
	private	function getSalesByAff($source_affiliate_name, $offerTag)
	{
		
		
		$db  = DB::getInstance();
		$sql = "SELECT `total_paid` FROM `response` WHERE `source_affiliate_name` = :source_affiliate_name AND `offer_tag` = :offerTag";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':source_affiliate_name', $source_affiliate_name, PDO::PARAM_STR);
		$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
		
		
		$stmt->execute();
		$response = $stmt->fetch(PDO::FETCH_COLUMN);
		
		if (!empty($response)) {
			return $response;
		} else {
			return '0';
		}
		
		
	}
	
	private	function setTotalPaid()
	{
		$db  = DB::getInstance();
		$sql = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` = :account_manager_name";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		
		$stmt->execute();
		
		
		$this->totalPaid = $stmt->fetch(PDO::FETCH_COLUMN);
		
	}
	
	private	function setTotalPerOfferTag($offerTag)
	{
		$db  = DB::getInstance();
		$sql = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` = :account_manager_name AND `offer_tag` = :offerTag";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		$stmt->bindParam(':offerTag', $offerTag, PDO::PARAM_STR);
		$stmt->execute();
		
		
		return $stmt->fetch(PDO::FETCH_COLUMN);
		
	}
	
	public function special070(){
		$db  = DB::getInstance();
		$sql = "SELECT sum(`total_paid`) FROM `response` WHERE `source_affiliate_name` IN (\"070-dreamcatcher\", \"070-opher1\") AND `offer_tag` = \"30\"";
		
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		$special = $stmt->fetch(PDO::FETCH_COLUMN);
		
		
		
		$this->tire2Commision = $this->tire2Commision + ($special * 2);
		
		
	}
	public function special093(){
		$db  = DB::getInstance();
		$sql = "SELECT sum(`total_paid`) FROM `response` WHERE `source_affiliate_name` IN (\"zz-317-Anderson-ChattersPayout\", \"zz-326-OysOffice\", \"zz-326-OysMarketing-chattingbucks.com\")";
		
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		$special = $stmt->fetch(PDO::FETCH_COLUMN);
		
		
		
		$this->tire2Commision = $this->tire2Commision + $special ;
		
		
	}
	private	function setTotalDollarAmount()
	{
		$db  = DB::getInstance();
		$sql = "SELECT `total_paid` * `offer_tag` AS totalDollarArmout FROM `response` WHERE `account_manager_name` = :account_manager_name";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		
		$stmt->execute();
		
		
		return $stmt->fetch(PDO::FETCH_COLUMN);
		
	}
	
	private	function getCountByOfferTag($offerTag)
	{
	
	}
	
	private function getTotalPaidByOfferTag()
	{
		
		
		$db  = DB::getInstance();
		$sql = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` = :account_manager_name AND `offer_tag` = :offerTag";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		$stmt->bindParam(':offerTag', $this->offerTag, PDO::PARAM_STR);
		$stmt->execute();
		
		
		return $stmt->fetch(PDO::FETCH_COLUMN);
	}
	
	private function getTotalPaidByManager()
	{
		
		
		$db  = DB::getInstance();
		$sql = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` = :account_manager_name";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':account_manager_name', $this->account_manager_name, PDO::PARAM_STR);
		$stmt->execute();
		
		
		return $stmt->fetch(PDO::FETCH_COLUMN);
	}
	
	private function processResponse($getTotalPaidByOfferTag)
	{
		if ($getTotalPaidByOfferTag == null) {
			return '0';
		} else {
			return $getTotalPaidByOfferTag;
		}
	}
	
	private function getCommission()
	{
		
		
		$db = DB::getInstance();
		
		switch ($this->account_manager_name) {
			case "070-Jorayn Salamera":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"074-Jayson Tuazon\",\"075-John Paul Ramirez\",\"075-4 ang\",\"076-Reynaldo I-1\",\"077-Reynaldo I-2\",\"078-Bruno\",\"089-Roman E\",\"094-Ludacris\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				
				if ($response != null) {
					$this->commission = $response;
				} else {
					$this->commission = '0';
				}
				break;
			
			case "074-Jayson Tuazon":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"076-Reynaldo I-1\",\"077-Reynaldo I-2\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				if ($response != null) {
					$this->commission = $response;
				} else {
					$this->commission = '0';
				}
				
				break;
			
			case "081-Bernard S":
				$sql  = "SELECT SUM(total_paid) FROM `response` WHERE `account_manager_name` IN (\"076-Reynaldo I-1\",\"077-Reynaldo I-2\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				$response = $stmt->fetch(PDO::FETCH_COLUMN);
				if ($response != null) {
					$this->commission = $response;
				} else {
					$this->commission = '0';
				}
				
				break;
			
			
		}
		
		
	}
}