<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 2/13/2018
 * Time: 1:06 PM
 */

class report
{
	
	/**
	 * report constructor.
	 */
	public function __construct()
	{
	}
	
	
	public function printManagerHTMLTable(string $managerName, array $salesArray)
	{
		
		echo "<table class = \"table table-bordered\">
			<tr><h1>$managerName</h1> </tr><thead>
			  <tr> <th>affiliate</th>";
		
		$offerTags = explode(',', getenv('offerTags'));
		foreach ($offerTags as $offerTag) {
			echo "<th>$offerTag</th>";
			
		};
		echo "</thead> <tbody>";
		echo "<tr>";
		echo "<td>TOTAL</td>";
		
		foreach ($salesArray as $item) {
			$offferTagTotal = $item['offerTagTotal'];
			echo "<td> $offferTagTotal </td>";
			
		}
		
		echo "</tbody> </table>";
		
	}
	
	public function printManagerMasterReport(string $managerName, $managerData)
	{
		
		
		$affArray = $managerData->affArray;

//		print_x($managerData);
		
		$offerTags = explode(',', getenv('offerTags'));
		
		$managerMasterTable = new displayTable();
		if ($managerData->totalPaid > 0) {
			
			$managerMasterTable->startBootStrap();
			$managerMasterTable->openTableStripes()->tHeadStart()->rowStart();
			
			$managerMasterTable->tdCustom('<h1>' . $managerName . '</h1>', 5);
			$managerMasterTable->tdVal('<h3>' . $managerData->totalPaid . '</h3>');
			$managerMasterTable->rowEnd()->rowStart();
			
			$managerMasterTable->tdVal('affiliate');
			foreach ($offerTags as $offerTag) {
				
				$managerMasterTable->tdVal($offerTag);
			}
			$managerMasterTable->tdVal("TOTAL");
			$managerMasterTable->rowEnd()->tHeadEnd()->tBodyStart();
			
			$totalDollarAmountByManager = 0;
			foreach ($affArray as $salesObject) {
				foreach ($salesObject->sales as $offerTagValue => $amountSold) {
					$math                       = $offerTagValue * $amountSold;
					$totalDollarAmountByManager = $totalDollarAmountByManager + $math;
					
				}
				
				$managerMasterTable->rowStart();
				$managerMasterTable->tdVal($salesObject->source_affiliate_name);
				$total               = 0;
				$totalSalesByManager = 0;
				foreach ($salesObject->sales as $offerTagSalesKey => $offerTagSalesValue) {
					$managerMasterTable->tdVal($offerTagSalesValue);
					$total               = $total + $offerTagSalesValue;
					$totalSalesByManager = $totalSalesByManager + $total;
				}
				$managerMasterTable->tdVal($total);
				
				
				$managerMasterTable->rowEnd();
				
			}
			$managerMasterTable->rowStart();
			$managerMasterTable->tdVal("");
			$managerMasterTable->rowEnd();
			
			$managerMasterTable->rowStart();
			$managerMasterTable->tdVal("TOTAL SALES");
			$managerMasterTable->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("");
			$managerMasterTable->tdVal("$" . $totalDollarAmountByManager);
			$managerMasterTable->rowEnd();
			
			$managerMasterTable->rowStart();
			$managerMasterTable->tdVal("COMMISSIONS");
			$managerMasterTable->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("");
			$managerMasterTable->tdVal("$" . $managerData->commission);
			$managerMasterTable->rowEnd();
			
			$managerMasterTable->rowStart();
			$managerMasterTable->tdVal("teir2commission");
			$managerMasterTable->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("");
			$managerMasterTable->tdVal("$" . $managerData->tire2Commision);
			$managerMasterTable->rowEnd();
			
			$managerMasterTable->rowStart();
			$managerMasterTable->tdVal("TOTAL");
			$managerMasterTable->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("")->tdVal("");
			$managerMasterTable->tdValBold("$" . ($totalDollarAmountByManager + $managerData->commission + $managerData->tire2Commision));
			$managerMasterTable->rowEnd();
			$managerMasterTable->tBodyEnd()->closeTable();
			
			$managerMasterTable->endBootStrap();
		}
	}
}