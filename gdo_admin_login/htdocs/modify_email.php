<?php session_start();?>

<?php
    //connect to the database
    require('../mysqli_connect_admin_table.php');
    include_once("includes/download_function.php"); 

    include_once("includes/header.php");
    
	$page_title = 'Update Emails'; 
	include_once ('includes/frame.html');
?>
<div class="row justify-content-center">
			<div class="col" align="center">
				<h1>Change Contents of Emails</h1>
                <!-- dropdown for types of emails that can be modified -->
	<form class="justify-content-center" action="modify_email.php" method="post">
	 	<label for="query">Type of Email to Update</label>
		<select name="query" class="mx-3">
			<?php
            $dropdownquery = "SELECT type FROM emails";
                    
            $dropdownrow = mysqli_query($dbc, $dropdownquery); 
                   
            // Fetch and print all the records:
            while ($dropdown = mysqli_fetch_array($dropdownrow, MYSQLI_ASSOC)) 
            {
                echo '<option>'. @$dropdown['type'] .'</option>';
            }
			?>


	 	</select>
	 	<button type="submit" class="btn btn-primary mb-2">Submit</button>
 	
 <?php
if($_SERVER['REQUEST_METHOD']=='POST')
	{

// Determine where to start returning records.
if (isset($_POST['s']) && is_numeric($_POST['s'])) 
{
	$start = $_POST['s'];
}
else 
{
	$start = 0;
}
    //stores the type of email to be modified
    $typeholder = $_POST['query'];
    if($_POST['query'].is_null()){
        $q = "SELECT * FROM emails WHERE type='$typeholder'";
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
    if (isset($_POST['change'])) 
    {
        //Collects contents of text fields to update email database with.
        if(!empty($_POST['subject']) && !empty($_POST['contents'])){
            $subject = $_POST['subject'];
            $contents = $_POST['contents'];
            $subject = addslashes($subject);
            $contents = addslashes($contents);
            $testquery = $_POST['testquery'];
            $updateEmail = mysqli_query($dbc, "UPDATE emails SET subject='$subject', contents='$contents' WHERE type='$testquery'");
            mysqli_query($dbc, $updateEmail);
            echo 'Update submitted.';
        }
        else{
            echo 'Please fill out the form completely';
        }
    }
    else
    {
        //stores the query value for use when the form is submit for modification
        $testingQuery = $_POST['query'];
        echo '<form class="form-inline row justify-content-center pt-4" method="post" action="modify_email.php">
                <input type="hidden" name="testquery" value="'.$testingQuery.'">
                <section class "row">
                <div class="col-8 text-left">Subject: <input type="text" name="subject" size=70 maxlength=70></div>
                <div class="col-8 text-left">Contents: <textarea name="contents" rows="8" cols="70"></textarea></div>
                <div class="form-group col-8">
                    <input class="btn btn-primary" name="change" type="submit" value="Update">
                </div>
                </section>
                </form>';
    }

?>
                
                

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