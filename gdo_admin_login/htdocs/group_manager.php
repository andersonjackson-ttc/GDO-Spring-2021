<?php session_start();?>
<?php
    //connect to the database
    require('../mysqli_connect_admin_table.php');
    include_once("includes/header.php");
	$page_title = 'Manage Groups'; 
	include_once ('includes/frame.html');
	$year = date("Y");
	$currentapplicantquery = mysqli_query($dbc, "SELECT COUNT(*) AS 'count' FROM applicant WHERE year_submitted = '$year' AND application_status = 'Approved'");
    $applicantfetch = mysqli_fetch_assoc($currentapplicantquery);
    $currentyearappcount = $applicantfetch['count'];
    $groupquery = mysqli_query($dbc, "SELECT COUNT(*) AS 'groupcount' FROM group_names");
    $groupcountfetch = mysqli_fetch_assoc($groupquery);
    $groupcount = $groupcountfetch['groupcount'];
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
			if(($currentyearappcount/$groupcount) > $_POST["maxgroupsize"]){
				echo 'Unable to assign groups: Please add more groups or change the maximum members per group.';
			}
			else{
    			//pull array of group NAMES
				$gnamesquery = "SELECT group_name FROM group_names";
    			$gnameset = mysqli_query($dbc, $gnamesquery);
    			$groupnamesarray = array();
    			while ($gnamearray = mysqli_fetch_array($gnameset, MYSQLI_ASSOC)){
			        $groupnamesarray[] = $gnamearray['group_name'];
			    }
				//pull array of current year approved applicant IDS
				$appidquery = "SELECT id FROM applicant WHERE application_status = 'Approved'";
    			$appidset = mysqli_query($dbc, $appidquery);
    			$appidarray = array();
    			while ($aidarray = mysqli_fetch_array($appidset, MYSQLI_ASSOC)){
			        $appidarray[] = $aidarray['id'];
			    }
				//WHILE we still have IDS in ID array to go through
				$groupindex = 0;
				$idindex = 0;
				$assignindex = 0;
				while($assignindex < count($appidarray)){
					$tempgname = $groupnamesarray[$groupindex];
					$tempaid = $appidarray[$idindex];
					$groupmassassignquery = "UPDATE applicant SET camp_group = '$tempgname' WHERE id = '$tempaid'";
					$idindex+=count($groupnamesarray);
					$assignindex++;

					while($idindex < count($appidarray)){
						$tempaid = $appidarray[$idindex];
						$groupmassassignquery .= " OR id = '$tempaid'";
						$idindex+=count($groupnamesarray);
						$assignindex++;
					}
					$groupmassassignquery .= ";";
		            $assigngroupset = mysqli_query($dbc, $groupmassassignquery);
		            mysqli_query($dbc, $assigngroupset);
					$groupindex++;
					$idindex = $groupindex;
				}
			}
		//Add function to features below or figure out a better way to implement features
		}
		

	}
    $groupquery = mysqli_query($dbc, "SELECT COUNT(*) AS 'groupcount' FROM group_names");
    $groupcountfetch = mysqli_fetch_assoc($groupquery);
    $groupcount = $groupcountfetch['groupcount'];
?>	
	<div class="col" align="center">
				<h3>Group Management</h3>
				<p>Approved Applicants: <?php echo $currentyearappcount;?></p>
				<p>Number of Groups: <?php echo $groupcount;?></p>
			</div>
	<div class="col" align="center">
				<h3>Remove a Group</h3>
			</div>
	<!-- Group removal form -->
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
    <!-- end of  group removal html content -->
    <!-- Group adding form -->
    <div class="col" align="center">
				<h3>Add a Group</h3>
			</div>
    <form class="form-inline row justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">

    	Group Name: <input type="text" name="newgroup" size=35 maxlength=40>
    	<button class="btn btn-primary mx-1" type="submit">Add New Group</button> 
    </form>
    <!-- end of group adding feature -->
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

