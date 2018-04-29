[insert_php]
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
    if ($noErr){
       global $wpdb;
       $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM traveler_post  WHERE DepartureCity = %s AND ArrivalCity = %s AND AvailableSpace = %d AND DepartureDate = %s AND ArrivalDate = %s",$departureCity,$arrivalCity,$size,$departureDate, $arrivalDate));

      echo "<table border='1'>

      <tr>
      <th>UID</th>
      <th>DepartureCity</th>
      <th>ArrivalCity</th>
      <th>DepartureDate</th>
      <th>ArrivalDate</th>
      </tr>";
      //$result = $_SESSION['searchResult'];
      foreach($result as $value){
        echo"<tr>";
        echo "<td>".$value->UID."</td>";
        echo "<td>".$value->DepartureCity."</td>";
        echo "<td>".$value->ArrivalCity."</td>";
        echo "<td>".$value->DepartureDate."</td>";
        echo "<td>".$value->ArrivalDate."</td>";
        echo"</tr>";
      }
      echo "</table>";
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
