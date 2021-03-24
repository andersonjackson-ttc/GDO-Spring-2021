<?php session_start();?>
<?php

    require('../mysqli_connect_admin_table.php');

    include_once("includes/header.php");
    
	$page_title = 'Send a Message'; 
	include_once ('includes/frame.html');
?>

<div class="row justify-content-center">            
    <h1>Send a Message</h1>
</div>

    <form class="form-inline row justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="GET">
        <div class="form-group  px-2">
        <label for="app_stat_selection" style="padding-right: 1em">Application Status</label>
            <select class="form-control" id="app_stat_selection" name="type">
                <option value="none" selected disabled>Select an Option</option>
                <option value="All">All</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Denied">Denied</option>
                <?php $type = $_GET['type'];?>
            </select>

        </div> 
        <td><label for="message" style="padding-right: 1em">Message</label>
        <textarea name="message" id="message" cols="80" rows="10" style="border:none" required></textarea>
        </td>
        <button type="submit" class="btn btn-primary">Submit</button> 
    </form>
   
            
<?php


<?php include_once("includes/footer.html");?>