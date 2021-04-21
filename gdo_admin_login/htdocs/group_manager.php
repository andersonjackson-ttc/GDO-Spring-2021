<?php session_start();?>
<?php
    //connect to the database
    require('../mysqli_connect_admin_table.php');
    include_once("includes/header.php");
	$page_title = 'Manage Groups'; 
	include_once ('includes/frame.html');
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST["removalquery"])){
			$groupname = $_POST["removalquery"];
            $removeGroup = mysqli_query($dbc, "DELETE FROM group_names WHERE group_name='$groupname'");
            mysqli_query($dbc, $removeGroup);
            echo 'Group Removed.';
		}
		if(isset($_POST["newgroup"])){
			$groupname = $_POST["newgroup"];
            $addGroup = mysqli_query($dbc, "INSERT INTO group_names (group_name) VALUES ('$groupname')");
            mysqli_query($dbc, $addGroup);
            echo 'Group Added.';
		}
		if(isset($_POST["maxgroupsize"])){
			echo 'Functionality of group mass assignment is a work in progress';
		//Add function to features below or figure out a better way to implement features
		}
		

	}
?>
	<!-- Unfinished, to be implemented -->
	<div class="col" align="center">
				<h3>Remove a Group</h3>
			</div>
    <form class="form-inline row justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group  px-2">
            <label for="group_removal" style="padding-right: 1em">Remove</label>
            <select class="form-control" id="group_removal" name="removalquery">
                <option value="none" selected disabled hidden>Select an Option</option>
<?php

    $q = "SELECT group_name FROM group_names";
            
    $r = mysqli_query($dbc, $q); 
           
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
    {
        echo '<option>'. @$row['group_name'] .'</option>';
    }
         
?>
         
            </select>
        </div> 
        <button class="btn btn-primary mx-1" type="submit">Remove Group</button>                 
    </form> 
    <!-- end of unfinished group removal html content -->
    <!-- Example work in progress group adding feature to be added later -->
    <div class="col" align="center">
				<h3>Add a Group</h3>
			</div>
    <form class="form-inline row justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">

    	Group Name: <input type="text" name="newgroup" size=35 maxlength=40>
    	<button class="btn btn-primary mx-1" type="submit">Add New Group</button> 
    </form>
    <!-- end of unfinished group adding feature -->
    <!-- Example work in progress automatic group assigning feature to be added later -->
    <div class="col" align="center">
				<h3>Automatic Group Assignment</h3>
			</div>
    <form class="form-inline row justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">

    	Group Member Maximum: <input type="number" name="maxgroupsize" size=3 maxlength=3>
    	<button class="btn btn-primary mx-1" type="submit">Automatically Assign Groups</button> 
    </form>
    <!-- end of unfinished automatic group assigning feature -->
    


<?php


include_once("includes/footer.html");
?>

