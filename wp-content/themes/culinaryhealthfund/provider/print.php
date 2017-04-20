<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/culinaryhealthfund/includes/init.inc.php');

$drTypes	= $provider->getDoctorTypes();
array_unshift($drTypes, "ALL");

$languages  = $provider->getLanguages();
$states     = $provider->getAvailableStates();
$distances  = $provider->getDistances();
$centerOfTownZip = Provider::HOME_ZIP;

$_REQUEST['action']     = (ISSET($_REQUEST['action'])) ? $_REQUEST['action'] : "";
$_REQUEST['type']       = (ISSET($_REQUEST['type'])) ? $_REQUEST['type'] : "ALL";
$_REQUEST['facility']   = (ISSET($_REQUEST['facility'])) ? $_REQUEST['facility'] : "";
$_REQUEST['city']       = (ISSET($_REQUEST['city'])) ? $_REQUEST['city'] : "";
$_REQUEST['state']      = (ISSET($_REQUEST['state'])) ? $_REQUEST['state'] : "NV";
$_REQUEST['zip']        = (ISSET($_REQUEST['zip'])) ? $_REQUEST['zip'] : "";
$_REQUEST['address']    = (ISSET($_REQUEST['address'])) ? $_REQUEST['address'] : "";
$_REQUEST['language']   = (ISSET($_REQUEST['language'])) ? $_REQUEST['language'] : "ALL";
$_REQUEST['range']      = (ISSET($_REQUEST['range'])) ? $_REQUEST['range'] : "2";

$pageLinks = 10;
$pageVal = ($_REQUEST['page_val']) ? (int)$_REQUEST['page_val'] : 1;
$perPage = 5;


if ($_REQUEST['action'] == "search") {
	if ( 
		(strlen(trim($_REQUEST['zip'])) && strlen(trim($_REQUEST['range']))) 
		|| (strlen(trim($_REQUEST['city'])) && strlen(trim($_REQUEST['state']))) 
		) {
		$errorText = "";
		
	} else {
		$errorText = "We need you to at least fill out:<br>";
		$errorText .= "<ul><li>A City and State</li><li>Or a Zip Code and Search Area</li></ul>";
	}
	
	if (!strlen($errorText)) {
		$print = 1;
		$providerListing = $provider->searchProviders($_REQUEST['facility'], $_REQUEST['type'], $_REQUEST['language'], $_REQUEST['address'], $_REQUEST['city'], $_REQUEST['state'], $_REQUEST['zip'], $_REQUEST['range'], $pageVal, $perPage, $print);	
	}
	
}

$totalPages = $providerListing['count'] / $perPage;
if (!is_int($totalPages)) {
	$totalPages = floor($totalPages) + 1;
}

?>
	
	
		
		<?php 
		
		echo '<br><strong>' . $providerListing['count'] . ' Results</strong><br><br>';
		
		
		
		if ($providerListing['results']) {
		?>
		
		<style>
			.provider-tbl {
				border: 0px;
			}
			
		</style>
		
		<table class="provider-tbl">
		<tr>
			<td class="tbl-header-row" valign="top"> # </td>
			<td class="tbl-header-row" valign="top" width="30%"> Facility/Doctor </td>
			<td class="tbl-header-row" valign="top"> Address </td>
			<td class="tbl-header-row" valign="top"> Phone </td>
		</tr>	
		
		<?php
			$xCnt = 0;
		foreach ($providerListing['results'] as $p) {
			$xCnt++;
			
			$addressMapUrl = "http://maps.google.com/maps?f=q&source=s_q&hl=en&output=embed&q=".$p['address'].",+".$p['city']."+".$p['state']."+".$p['zip'];
			
			$address = '<a href="'.$addressMapUrl.'" target="_blank">';
			$address .= strlen($p['address']) ? $p['address'] . '<br>' : '';
			$address .= strlen($p['city']) ? $p['city'] . ', ' . $p['state']  . ' ' . $toZip . '<br>' : '';
			$address .= "</a>";
			
		?>
		
		<tr>
			<td valign="top"> <?php echo $xCnt; ?> </td>
			<td valign="top"> 	
					<?php
					echo strlen($p['name']) ? $p['name'] . '<br>' : '';
					echo strlen($p['practice']) ? $p['practice'] . '<br>' : '';
					echo strlen($p['type']) ? $p['type'] . '<br>' : '';	
					?>
			</td>
			<td valign="top"> <?php echo strlen($p['address']) ? $address . '<br>' : ''; ?> </td>
			<td valign="top"> <?php echo strlen($p['phone']) ? $p['phone'] . '<br>' : ''; ?> </td>
		</tr>	
		
		
		<?php
		}	
		?>
		
	
		<?php
		} else {
			//Only show this message if they've hit the search button
			if ( $_REQUEST['action'] == "search")  {
		
				?>
				<div class="row provider-result">
					<div class="col-md-12">
					<br><br>
						There are no results matching your search. Perhaps try searching again being less specific...
					</div>
				</div>
				
				<?php	
				
					}
				
		}
		?>
				
	  