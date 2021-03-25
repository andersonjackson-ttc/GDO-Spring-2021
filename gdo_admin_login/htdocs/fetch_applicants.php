<?php session_start();?>

<?php
    //connect to the database
    require('../mysqli_connect_admin_table.php');
    include_once("includes/download_function.php"); 
    if (isset($_POST['download']) && isset($_SESSION['query'])) 
    {
        //Pass it the query, then the connection to the db, and finally whatever you want the output to be named
        downloadThings($_SESSION['query'], $dbc, "applicant_data");
    }

    include_once("includes/header.php");
    
	$page_title = 'Reports'; 
	include_once ('includes/frame.html');
?>
<div class="row justify-content-center">
			<div class="col" align="center">
				<h1>Reports</h1>
	<form class="justify-content-center" action="fetch_applicants.php" method="post">
	 	<label for="query">Query Type -></label>
		<select name="query" class="mx-3">
			<?php
			if(isset($_POST["query"]))
			{
				echo '<option value="basic"'; if (($_POST['query'])=='basic'){echo 'selected';} echo '>Basic</option>
				<option value="everything"'; if (($_POST['query'])=='everything'){echo 'selected';} echo '>Everything</option>
		 		<option value="groups"'; if (($_POST['query'])=='groups'){echo 'selected';} echo '>Group Assignment</option>
		 		<option value="contactInfo"'; if (($_POST['query'])=='contactInfo'){echo 'selected';} echo '>Contact Info</option>';
			}
			else
			{
				echo '<option value="basic">Basic</option>
				<option value="everything">Everything</option>
		 		<option value="groups">Group Assignment</option>
		 		<option value="contactInfo">Contact Info</option>';
			}
			?>
			<option></option>

	 	</select>
	 	<button type="submit" class="btn btn-primary mb-2">Submit</button>
 	
 <?php
if($_SERVER['REQUEST_METHOD']=='POST')
	{


	// Number of records to show per page:
	$display = 2500;

	// Calculate number of pages needed
	if (isset($_POST['p']) && is_numeric($_POST['p'])) 
	{ 
		$pages = $_POST['p'];
	} 
	else
	{ 
	 	// Count the number of records:
		$q = "SELECT COUNT(id) FROM applicant";
		$r = @mysqli_query ($dbc, $q);
		$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
		// $records = $row[0];
		// Calculate the number of pages.
		// if ($records > $display) 
		// { 
		// 	$pages = ceil ($records/$display);                 <---Not Working Page feature
		// } 
		// else 
		// {
		// 	$pages = 1;
		// }
	} // End of IF.

// Determine where to start returning records.
if (isset($_POST['s']) && is_numeric($_POST['s'])) 
{
	$start = $_POST['s'];
}
else 
{
	$start = 0;
}

// Determine the sort
//$sort = (isset($_POST['sort'])) ? $_POST['sort'] : 'fn';

// Determine the sorting order:
if (isset($_POST['sort'])==false)
{
	$order_by = '';
}
else
{
	$order_by = "ORDER BY ".$_POST['sort'];
}

	if($_POST['query'] == 'everything')
	{
		$q = "SELECT `a`.`last_name` AS 'Last Name', `a`.`first_name` AS 'First Name',`a`.`address` AS 'Address',`a`.`city` AS 'City',`a`.`state` AS 'State',`a`.`zip_code` AS 'Zip Code',`a`.`phone_number` AS 'Phone Number',`a`.`date_of_birth` AS 'DOB',`a`.`age` AS 'Age', `a`.`email` AS 'Email Address',`a`.`school_attending_in_fall` AS 'School', `a`.`college_of_interest` AS 'College of Interest', `a`.`shirt_size` AS 'T-Shirt Size',`p`.`primary_parent_first_name` AS 'Parent First Name', `p`.`primary_parent_last_name` AS 'Parent Last Name', `p`.`primary_parent_email` AS 'Parent Email', `p`.`primary_parent_address` AS 'Parent Address', `p`.`primary_parent_primary_phone` AS 'Parent Phone Number', `e`.`contact_name` AS 'Emergency Contact Name',`e`.`contact_relationship` AS 'Relationship to Child', `e`.`contact_address` AS 'Emergency Contact Address', `e`.`contact_primary_phone` AS 'Emergency Contact Phone', `a`.`allergies` AS 'Food Allergies'
			FROM `applicant` AS `a` 
			LEFT JOIN `emergency_contact` AS `e` ON `e`.`id` = `a`.`id` 
			LEFT JOIN `parent` AS `p` ON `p`.`id` = `a`.`id` $order_by LIMIT $start, $display";

	}
	elseif($_POST['query'] == 'basic')
	{
		$q = "SELECT last_name AS 'Last Name', first_name AS 'First Name',address AS 'Address',city AS 'City',state AS 'State',zip_code AS 'Zip Code',phone_number AS 'Phone Number',date_of_birth AS 'DOB',rising_grade_level AS 'Rising Grade Level' FROM applicant $order_by LIMIT $start, $display";
	}
	elseif($_POST['query'] == 'groups')
	{
		$q = "SELECT last_name AS 'Last Name', first_name AS 'First Name', camp_group AS 'Group Name' FROM applicant $order_by LIMIT $start, $display";
	}
	elseif($_POST['query'] == 'contactInfo')
	{
		$q = "SELECT last_name AS 'Last Name', first_name AS 'First Name', phone_number AS 'Phone Number' FROM applicant $order_by LIMIT $start, $display";
	//add the querys for parent or emergency contact info
	}
	else
	{
		$q = "SELECT last_name AS 'Last Name', first_name AS 'First Name',address AS 'Address',city AS 'City',state AS 'State',zip_code AS 'Zip Code',phone_number AS 'Phone Number',date_of_birth AS 'DOB',rising_grade_level AS 'Rising Grade Level' FROM applicant $order_by LIMIT $start, $display";	
	}
// Define the query for all records and fields sorted by the field chosen by the user

$_SESSION['query'] = $q;
//run the query	
$r = @mysqli_query ($dbc, $q); // Run the query.->
 
 	echo'<div class="table-responsive" style="overflow-x:auto ;">
		<table class="table-sm table-bordered border-default">
 		<tr class="h-100" >';
 		$x=0;
 		while ($fieldinfo = mysqli_fetch_field($r)) 
 		{
		    echo '<th class="p-0"><button class="btn-primary w-100" style="min-height:80px;" type="submit" name="sort" value="'.$fieldinfo -> orgname.'">'.$fieldinfo -> name.'</button></th>';
		 }
		echo'</tr>';
	$x=0;
	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) 
	{
		$i=0;
		if(($x % 2) == 0)
		{
			$color = "table-warning";
		}
		else
		{
			$color = "table-info";
		}

		echo '<tr class='.$color.'>';
		
		while($i < mysqli_field_count($dbc))
		{
			echo '<td>'.$row[$i].'</td>';
			$i++;
		}
		echo '</tr>';
		$x++;
	}

	echo '</table>		
	</div></form>';

?>
                <form class="form-inline row justify-content-center pt-4" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
                <div class="form-group">
                    <input class="btn btn-primary" name="download" type="submit" value="Export">
                </div>
                </form>
                

<?php
	
	mysqli_free_result ($r); // Free up the resources.
	mysqli_close($dbc); // Close the database connection.

	
}
else
{
	echo"<p>Press Submit to replace this with Data</p>";
}


echo' 	</div>
</div>';
include_once("includes/footer.html")?>