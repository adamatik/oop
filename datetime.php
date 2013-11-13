<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>DateTime Usage</title>
	<style type="text/css" media="screen">
	body {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		margin: 10px;
		}
		label {font-weight:bold;}
		.error { color:#F00;}
	</style>	
</head>
<body>
<?php # Script 16.5 - datetime.php

	//Set the start and end date as today tomorrow by default:
	$start = new DateTime();
	$end = new DateTime();
	$end->modify('+1 day');
	
	//Default format for displaying dates:
	$format = 'm/d/Y';
	
	//This function validates a provided date string.
	//The function returns an array -- month, day, year -- if valid.
	function validate)date($date){
		
		//Break up the string into its parts:
		$date_array = explode('/', $date);
		
		//Return FALSE if there aren't 3 items:
		if (count($date_array) !=3) return false;
		
		//Return FALSE if it's not a valid date:
		if (!checkdate($date_array[0], $date_array[1], $date_array[2])) return false;
		
		//Return the array:
		return $date_array;
	
	} //End of validate_date() function
	
	//Check for a form submission:
	if (isset($_POST['start'], $_POST['end'])){
	
		//Call the validation function on both dates:
		if ((list($sm, $sd, $sy) = validate_date($_POST['start'])) && (list($em, $ed, $ey) = validate_date($_POST['end']))){
			
			//If it's okay, adjust the DateTime objects:
			$start->setDate($sy, $sm, $sd);
			$end->setDate($ey, $em, $ed);
			
			//The start date must come first:
			if ($start < $end) {
			
				//Determine the interval:
				$interval = $start->diff($end);
				
				//Print the results:
				echo "<p>The event has been planned starting on {$start->format($format)}, and ending on {$end->format($format)}, which is a period of $interval->days day(s).</p>";
			
			} else{ //End date must be later!
				echo '<p class="error">The starting date must precede the ending date.</p>';
			}
			
		}else { //An invalid date:
			echo '<p class="error">One or both of the submitted dates was invalid.</p>';
		}
	} //End of the form submission
?>
<h2>Set the Start and End Dates for the Thing</h2>
<form action="datetime.php" method="post">

	<p><label for="start_date">Start Date:</label> <input type="text" name="start_date" value="<?php echo $start->format($format);?>" /> (MM/DD/YYYY)</p>
	<p><label for="end_date">End Date:</label> <input type="text" name="end_date" value="<?php echo $start->format($format);?>" /> (MM/DD/YYYY)</p>

	<p><input type="submit" value="Submit" /></p>
</form>
</body>
</html>
