<!DOCYPE HTML>
<style>
.error {color: #FF0000;}<br /></style>
<head>
<h1>Search For Travelers: </h1>
</head>

<strong> NOTE: You need to fill out * field.</strong>
[insert_php]
function ur_theme_start_session()
{
    if (!session_id())
        session_start();
}
add_action("init", "ur_theme_start_session", 1);
session_start();
// define variables and set to empty values
$departureCity = $arrivalCity = $departureDate = $arrivalDate = $size = "";
$departureCityErr = $arrivalCityErr = $departureDateErr = $arrivalDateErr = $sizeErr = "";
$noErr = True;

if($_SERVER["REQUEST_METHOD"] == "POST") {
      if (is_user_logged_in()) {
	// departure city test
	if (empty($_POST["departureCity"])) {
		$departureCityErr = "Please enter object departure location.";
                $noErr = False;
	}
	else {
		$departureCity = test_city($_POST["departureCity"]);
	}
	// arrival city test
	if (empty($_POST["arrivalCity"])) {
		$arrivalCityErr = "Please enter object destination.";
                $noErr = False;
	}
	else {
		$arrivalCity = test_city($_POST["arrivalCity"]);
	}

	// departure date test
	if (empty($_POST["departureDate"])) {
		$departureDateErr = "Please enter object departure date.";
                $noErr = False;
	}
	else {
		$departureDate = test_date($_POST["departureDate"]);
	}

	// arrival date test
	if (empty($_POST["arrivalDate"])){
		$arrivalDateErr = "Please enter object arrival date.";
                $noErr = False;
	}
	else{
		$arrivalDate = test_date($_POST["arrivalDate"]);
	}

	// size test
	if (empty($_POST["size"])) {
		$sizeErr = "Please choose your object size. ";
                $noErr = False;
	}
	else{
		$size = test_size($_POST["size"]);
	}
    if (noErr){
       global $wpdb;
       $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM traveler_post  WHERE DepartureCity = %s AND ArrivalCity = %s AND AvailableSpace = %d AND DepartureDate = %s AND ArrivalDate = %s",$departureCity,$arrivalCity,$size,$departureDate, $arrivalDate));
       $_SESSION['searchResult'] = $result;
       echo print_r($result);
    }
    }
    else{
         echo '<span style="color: red; font-size: 20px;"><strong>Please log in first!</strong></span>';
   }

}
function test_city($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_date($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_size($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}




[/insert_php]


<form method="post" action="http://13.229.92.196/resultpage/">
<strong>Departure City：</strong><input name="departureCity" type="text" />
<span class="error">*[insert_php] echo $departureCityErr;[/insert_php] </span>

<strong>Arrival City：</strong><input name="arrivalCity" type="text" />
<span class="error">* [insert_php] echo $arrivalCityErr;[/insert_php] </span>

<strong>Departure Date：</strong><input name="departureDate" type="date" min=<?php echo date('Y-m-d'); />
<span class="error">* [insert_php] echo $departureDateErr;[/insert_php] </span>

<strong>Arrival Date：</strong><input name="arrivalDate" type="date" min=<?php echo date('Y-m-d'); />
<span class="error">* [insert_php] echo $arrivalDateErr;[/insert_php] </span>

<strong>Object Size：</strong>
<input name="size" type="radio" value="2" /> Large
<input name="size" type="radio" value="1" /> Medium
<input name="size" type="radio" value="0" /> Small
<span class="error">* [insert_php] echo $sizeErr;[/insert_php] </span>

<input name="submit" type="submit" value="Submit" />

</form>
