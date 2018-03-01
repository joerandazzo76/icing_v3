<?php
/**
 * Created by PhpStorm.
 * User: joera
 * Date: 1/29/2018
 * Time: 2:48 PM
 */


include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$today     = strtotime('today 00:00:00');
$endDate   = date("Y-m-d", strtotime('-1 week sunday 00:00:00'));
$startDate = date("Y-m-d", strtotime('-2 week sunday 00:00:00'));

?>
<!doctype html>
<html lang = "en">
<head>
	<meta charset = "UTF-8">
	<meta name = "viewport"
		  content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
	<title>Document</title>
	
	<script src = "https://code.jquery.com/jquery-3.2.1.js"
			integrity = "sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
			crossorigin = "anonymous"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
			integrity = "sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
			crossorigin = "anonymous"></script>
	
	<script type = "text/javascript" src = "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
			integrity = "sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
			crossorigin = "anonymous"></script>
	<script type = "text/javascript" src = "/js/main.js"></script>
	<link href = "/css/main.css" rel = "stylesheet" type = "text/css"/>
	<style>
		body {
			margin-top: 50px;
			margin-left: 50px;
			
		}
	</style>

</head>
<body>
<form method = "post" action = "<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
	<div class = "form-group">
		
		start_date: <input type = "date" id = "startDate" name = "startDate" value =<?= $startDate ?> required><br><br>
		end_date: <input type = "date" id = "endDate" name = "endDate" value =<?= $endDate ?> required> ADD ONE DAY <br><br><br>
	
	
	</div>
	
	
	<div class = "form-actions">
		<input type = "button" name = "action" id = "updateDB" class = "btn btn-primary btn-large" value = "updateDB">
	</div>
</form>

<form method = "post" action = "<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<br>
	<div class = "form-actions">
		<div>
			<input type = "button" name = "truncate" id = "truncate" class = "btn btn-primary btn-large" value = "Truncate">
		</div>
	</div>
</form>

</body>

<div class = "spinner activate" id = "spinner" hidden>
	<div class = "loader"></div>
</div>

</html>
<script type = "text/javascript">
	$(document).ready(function () {
			
			console.log("ready!");
			
			$("#updateDB").click(function () {
				var startDate = document.getElementById("startDate").value;
				var endDate = document.getElementById("endDate").value;
				var dateRange = [{"startDate": startDate},
					{"endDate": endDate}
				];
				processOffers(dateRange);
				
			});
			
			$("#truncate").click(function () {
				
				truncate();
				
			});
			
			console.log("Done");
		}
	);
	
	function truncate() {
		
		$.ajax({
			beforeSend: function () {
				console.log("processOffers");
				$('#spinner').attr('hidden', false);
			},
			url: '/ajax/truncate.php',
			type: 'POST',
			
			success: function (response) {
				console.log(response);
			},
			complete: function () {
				$('#spinner').attr('hidden', true);
				console.log("DONE");
			}
		});
		
	}
	
	function processOffers(dateRange) {
		
		var dateRangeJson = JSON.stringify(dateRange);
		var startDate = document.getElementById("startDate").value;
		var endDate = document.getElementById("endDate").value;
		$.ajax({
			beforeSend: function () {
				console.log("processOffers");
				$('#spinner').attr('hidden', false);
			},
			url: '/ajax/submit.php',
			type: 'GET',
			data: {
				"startdate": startDate,
				"enddate": endDate
			},
			
			success: function (response) {
				//console.log($.trim(response));
				console.log(response);
			},
			complete: function () {
				$('#spinner').attr('hidden', true);
				window.location = "/report.php?enddate=" + endDate;
				console.log("DONE");
				
			}
		});
	}


</script>











