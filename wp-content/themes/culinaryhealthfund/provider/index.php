<?php
include_once($_SERVER['DOC_ROOT_CHF'] . '/wp-content/themes/culinaryhealthfund/includes/init.inc.php');

$drTypes	= $provider->getDoctorTypes();
array_unshift($drTypes, "ALL");

$languages  = $provider->getLanguages();
$states     = $provider->getAvailableStates();
$distances  = $provider->getDistances();
$centerOfTownZip = Provider::HOME_ZIP;

$_REQUEST['directorycomments']     = (ISSET($_REQUEST['directorycomments'])) ? $_REQUEST['directorycomments'] : "ALL";
$_REQUEST['practice']     = (ISSET($_REQUEST['practice'])) ? $_REQUEST['practice'] : "";
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
		$providerListing = $provider->searchProviders($_REQUEST['facility'],
		$_REQUEST['type'],
		$_REQUEST['language'],
		$_REQUEST['address'],
		$_REQUEST['city'],
		$_REQUEST['state'],
		$_REQUEST['zip'],
		$_REQUEST['range'],
		$pageVal, $perPage);
	}

}

$totalPages = $providerListing['count'] / $perPage;
if (!is_int($totalPages)) {
	$totalPages = floor($totalPages) + 1;
}



?>

	<div class="container">

	<form class="provider" method="GET" action="<?php echo $_SERVER['REDIRECT_URL']; ?>">
		<input type="hidden" name="action" value="search">

	<div class="row provider-form-row">
		<div class="col-md-12">
				Doctor Type/Pharmacy Location<br>
				<select name="type"> <?php echo getFormOptions($drTypes, urldecode($_REQUEST['type']), false);?> </select>
		</div>
		<div class="col-md-12">
				Doctor Last Name/Facility<br>
				<input type="text" name="facility" value="<?php echo $_REQUEST['facility'];?>">

		</div>
	</div>
<hr>
	<div class="row provider-form-row">
		<div class="col-md-3">
			Street Address
			<input type="text" name="address" value="<?php echo $_REQUEST['address'];?>">
		</div>

		<div class="col-md-3">
			City<br>
			<input type="text" name="city" value="<?php echo $_REQUEST['city'];?>">
		</div>

		<div class="col-md-2">
			State<br>
			<select name="state"> <?php echo getFormOptions($states, $_REQUEST['state']);?> </select>
		</div>

	</div>

	<div class="row provider-form-row">
		<div class="col-md-3">
			Zip Code<br>
			<input type="text" name="zip" value="<?php echo $_REQUEST['zip'];?>">
		</div>


	</div>
<hr>
	<div class="row provider-form-row">
		<div class="col-md-3">
			Search Area<br>
			<select name="range"> <?php echo getFormOptions($distances, $_REQUEST['range']);?> </select>
		</div>

		<div class="col-md-3">
				Language<br>
				<select name="language"> <?php echo getFormOptions($languages, $_REQUEST['language']);?> </select>

		</div>


	</div>

	<div class="row provider-form-row">
		<div class="col-md-3">
			<button type="submit" class="btn rounded btn-lg btn-warning">Search</button>
		</div>
	</div>
	</form>


		<?php

		echo '<br><strong>' . $providerListing['count'] . ' Results</strong> | <i class="fa fa-print"></i> <a href="/participants/print-provider-directory/?'.$_SERVER['QUERY_STRING'].'" target="_new">Print This Page</a> <br><br>';

		echo $errorText . "<br><br>";

		if ($providerListing['results']) {


		foreach ($providerListing['results'] as $p) {

		?>

		<div class="row provider-result">
			<div class="col-md-6">

			<?php

					$addressMapUrl = "http://maps.google.com/maps?f=q&source=s_q&hl=en&output=embed&q=".$p['address'].",+".$p['city']."+".$p['state']."+".$p['zip'];

					$address = '<a href="'.$addressMapUrl.'" target="_blank">';
					$address .= strlen($p['address']) ? $p['address'] . '<br>' : '';
					$address .= strlen($p['city']) ? $p['city'] . ', ' . $p['state']  . ' ' . $toZip . '<br>' : '';
					$address .= "</a>";

					echo strlen($p['name']) ? $p['name'] . '<br>' : '';
					echo strlen($p['practice']) ? $p['practice'] . '<br>' : '';
					echo strlen($p['type']) ? $p['type'] . '<br>' : '';
					echo strlen($p['address']) ? $address . ' ' : '';
					echo strlen($p['phone']) ? $p['phone'] . '<br><br>' : '';
					echo strlen($p['directorycomments']) ? $p['directorycomments'] . '' : '';

			?>

			</div>



			<div class="col-md-6">
			<?php echo number_format($p['distance'],2); ?> Miles
			</div>
		</div>


			<?php

		}

		?>

			<?php
				} else {
					//Only show this message if they've hit the search button
					if ( $_REQUEST['action'] == "search" && !strlen($errorText))  {

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

	<div class="row">

		<div class="col-md-12">
		<?php if ($providerListing['results']) {
		?>


		<?php

		  $paging = new Pagination($pageVal, $totalPages, $pageLinks, null, 'page_val', $argv[0]);
		  echo '<div class="pagination">' . $paging->getPages(true, true, false) . '</div>';

		}

		?>

		</div>
	</div>


	</div><!-- /.container -->
