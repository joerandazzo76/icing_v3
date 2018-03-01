<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 1/29/2018
 * Time: 4:35 PM
 */

class factory
{
	public  $responseArray = array();
	public  $dateRange     = array();
	private $cakeObject;
	private $enddate;
	private $startdate;
	
	/**
	 * factory constructor.
	 */
	public function __construct()
	{
		$this->responseArray = new cake();
	}
	
	public function insertResponse2DataBaseIfThereIsAConversion()
	{
		
		
		if ($this->responseArray->getDataCount() > 0) {
			
			foreach ($this->responseArray->returnArraySourceAffiliateSummary() as $dataValue) {
				$this->responseArray->set(array_flatten($dataValue));
				if ($this->responseArray->total_paid > 0) {
					$this->responseArray->insert();
				}
				
			}
			
		}
		
		
	}
	
	public function setDateRange($dateRange)
	{
		
		$this->startdate = $dateRange['startdate'];
		$this->enddate   = $dateRange['enddate'];
		
	}
	
	public function processOfferTags()
	{
		$offerTags        = explode(',', getenv('offerTags'));
		$this->cakeObject = new cake();
		foreach ($offerTags as $offerTagKey => $offerTagValue) {
			print_x($offerTagValue);
			print_x($this->cakeObject->returnArraySourceAffiliateSummary($this->startdate, $this->enddate, $offerTagValue));
			$this->insertResponse2DataBaseIfThereIsAConversion();
		}
		
	}
	
	public function setEndDate($enddate)
	{
		$this->enddate = $enddate;
	}
	
	public function setStartDate($startdate)
	{
		$this->startdate = $startdate;
	}
}