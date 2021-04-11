<?php session_start();?>
<?php
    //connect to the database
    require('../mysqli_connect_admin_table.php');

    include_once("includes/header.php");
    
    $page_title = 'Manage Applications'; 
    include_once ('includes/frame.html');


    // Check for a valid user ID
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) 
{ 
    $id = $_GET['id'];
} 
elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) 
{ // Form submission.
    $id = $_POST['id'];
} 
else 
{ // No valid ID, kill the script.

    echo '<div class="container bg-light p-3" style="margin: 5% auto; ">
    <a href="manage_applications.php"><button type="button" class="btn btn-primary"><-Back</button></a>';
    echo'<p class="text-danger">Something went wrong</p>';
    include ('includes/footer.html'); 
    exit();
}

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $errors = 0;
    
    if (isset($_POST['update'])) 
    {
        $pq = mysqli_query($dbc, "SELECT application_status AS app_status FROM applicant WHERE id=$id");
        $prevStatusArray = mysqli_fetch_assoc($pq);
        $prevStatus = $prevStatusArray['app_status'];
        $update = mysqli_real_escape_string($dbc, $_POST['update']);
        date_default_timezone_set("America/New_York");
        $logDate = date("m/d");
        $logTime = date("H:i");
        $logYear = date("Y");
    } 
    else 
    {
        $errors++;
    }

    if (empty($_POST['notes'])) 
    {
        $notes = NULL;
    }
    else
    {
        $notes = mysqli_real_escape_string($dbc, $_POST['notes']);
        date_default_timezone_set('US/Eastern');
        $date_from_timestamp = date("m/d/Y H:i:s",time());
        $notes = $notes . '<br>-Submit on: ' . $date_from_timestamp . ' by '.$_SESSION['username'].'<br>';
        
    } 



    if($errors == 0)
    {
        if (isset($_POST['optradio'])) 
        {
            $deny = mysqli_real_escape_string($dbc, $_POST['optradio']);
            if($notes != null)
            {
            $q = "UPDATE applicant SET application_status='$update', denied_reason='$deny',application_notes= CASE WHEN (application_notes IS NOT NULL) THEN CONCAT('$notes', CHAR(13), application_notes) ELSE '$notes' END WHERE id=$id";
            }
            else
            {
                $q = "UPDATE applicant SET application_status='$update', denied_reason='$deny' WHERE id=$id";
            }
        }
        else
        {
            $deny = NULL;
            if($notes != null)
            {
            $q = "UPDATE applicant SET application_status='$update', denied_reason='$deny',application_notes= CASE WHEN (application_notes IS NOT NULL) THEN CONCAT('$notes', CHAR(13), application_notes) ELSE '$notes' END WHERE id=$id";
            }
            else
            {
                $q = "UPDATE applicant SET application_status='$update', denied_reason='$deny' WHERE id=$id";
            }
        }

        if ($update == "Cancelled") {
            $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$id");
            $mail = mysqli_fetch_assoc($m);
            $studentemail = $mail['email'];
            $mailsubject = "Your Girl's Day Out 2021 application has been cancelled";
            $mailcontents = "Your application to Girl's Day Out 2021 has been cancelled by an administrator. If you believe this cancellation has been an error, please contact us through the website from the Contact Us page.";
            mail($studentemail,$mailsubject,$mailcontents);
            $log = "INSERT INTO log (id, type, changed_by, changed_to, changed_from, time_submitted, date_submitted, year_submitted) VALUES ('$id', 'status', 'Admin', '$update', '$prevStatus', '$logTime', '$logDate', '$logYear')";
            if(mysqli_query($dbc, $log)){

            }
            else{
                echo 'log not submitted';
            }

        }

        if ($update == "Denied") {
            $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$id");
            $mail = mysqli_fetch_assoc($m);
            $studentemail = $mail['email'];
            $mailsubject = "Your Girl's Day Out 2021 application has been denied";
            if ($deny != null) {
                $mailcontents = "Your application to Girl's Day Out 2021 has been denied by an administrator. \nReason: $deny \n\nWe appreciate your interest in Girl's Day Out.";
            }
            else{
                $mailcontents = "Your application to Girl's Day Out 2021 has been denied by an administrator. We appreciate your interest in Girl's Day Out.";
            }
            mail($studentemail,$mailsubject,$mailcontents);
            $log = "INSERT INTO log (id, type, changed_by, changed_to, changed_from, time_submitted, date_submitted, year_submitted) VALUES ('$id', 'status', 'Admin', '$update', '$prevStatus', '$logTime', '$logDate', '$logYear')";
            if(mysqli_query($dbc, $log)){

            }
            else{
                echo 'log not submitted';
            }

        }
         if ($update == "Approved") {
            $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$id");
            $mail = mysqli_fetch_assoc($m);
            $studentemail = $mail['email'];
            $mailsubject = "Your Girl's Day Out 2021 application has been approved";
            $mailcontents = "Your application to Girl's Day Out 2021 has been approved by an administrator. Congratulation We appreciate your interest in Girl's Day Out.";
            mail($studentemail,$mailsubject,$mailcontents);
            $log = "INSERT INTO log (id, type, changed_by, changed_to, changed_from, time_submitted, date_submitted, year_submitted) VALUES ('$id', 'status', 'Admin', '$update', '$prevStatus', '$logTime', '$logDate', '$logYear')";
            if(mysqli_query($dbc, $log)){

            }
            else{
                echo 'log not submitted';
            }

        }
        
        
        if(mysqli_query ($dbc, $q))
        {
            $s = mysqli_query($dbc, "SELECT count(*) as count FROM applicant WHERE application_status='Approved' OR application_status='Pending'");
            $t = mysqli_query($dbc, "SELECT max_applicants as max FROM max_applicants");
            $rs = mysqli_fetch_assoc($s);
            $rt = mysqli_fetch_assoc($t);
            if($rs['count'] < $rt['max'])
            {
            	$year = date("Y");
                $next = mysqli_query($dbc, "SELECT MIN(id) as minimum FROM applicant WHERE application_status='Waitlist' AND year_submitted='$year'");
                $nextresult = mysqli_fetch_assoc($next);
                $rnext = $nextresult['minimum'];
                
                $approved = mysqli_query($dbc, "SELECT MIN(id) as minimum FROM applicant WHERE application_status='Approved' AND year_submitted='$year'");
                $approvedResult = mysqli_fetch_assoc($approved);
                $approvedApp = $approvedResult['minimum'];
                
                if($approvedApp['minimum'] != 0)
                {
                    $s = mysqli_query($dbc, "UPDATE applicant SET application_status='Approved' WHERE id=$approvedApp");
                    mysqli_query($dbc, $s);
                }

                //sends an email to the student to notify them of their change in status from Pending to Approved
                $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$approvedApp");
                $mail = mysqli_fetch_assoc($m);
                $studentemail = $mail['email'];
                $mailsubject = "An update to your Girl's Day Out $year application status";
                $mailcontents = "To view your Girls Day Out $year application decision, log in to your application portal. If you need anything at all, just let us know. Thank you for applying to the Girls Day Out 2021!";
                if (mail($studentemail,$mailsubject,$mailcontents))
                {
                    echo 'An email has been sent to ', $studentemail;
                }
                else
                {
                    echo 'Email failed to send to ', $studentemail;
                }  
                       
                if($rnext['minimum'] != 0)
                {
                    $s = mysqli_query($dbc, "UPDATE applicant SET application_status='Pending' WHERE id=$rnext");
                    mysqli_query($dbc, $s);
                    //sends an email to the student to notify them of their change in status from Waitlist to Pending
                    $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$rnext");
                    $mail = mysqli_fetch_assoc($m);
                    $studentemail = $mail['email'];
                    $mailsubject = "An update to your Girl's Day Out $year application status";
                    $mailcontents = "Your application has moved from the wait list, and is now awaiting review by our approval staff.\n If you have any questions regarding this email, please contact us on the Girl's Day Out website contact page.";
                    if (mail($studentemail,$mailsubject,$mailcontents))
                    {
                        echo 'An email has been sent to ', $studentemail;
                    }
                    else
                    {
                        echo 'Email failed to send to ', $studentemail;
                    }
                }
            }
        }
        else
        {
            echo'<p class="text-danger">Something went wrong</p>';
        }
        $errors=0;
    }

    
}

// Retrieve the user's information:
$q = "SELECT `applicant`.*, `emergency_contact`.*, `parent`.* 
    FROM `applicant` 
    LEFT JOIN `emergency_contact` ON `emergency_contact`.`id` = `applicant`.`id` 
    LEFT JOIN `parent` ON `parent`.`id` = `applicant`.`id` 
    WHERE `applicant`.`id`=$id";        
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) 
{ // Valid user ID, show the form.

    // Get the user's information:
    $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
    $status = $row['application_status'];
    echo '
    <a href="manage_applications.php" class="btn btn-primary"><-Back</a>
    <div class="btn-group" role="group">
        <a id="applicationTogl" href="#" class="btn btn-primary">Application</a>
        <a id="waiverOneTogl" href="#" class="btn btn-primary">Bosch Waiver</a>
        <a id="waiverTwoTogl" href="#" class="btn btn-primary">Consent Waiver</a>
        <a id="waiverThreeTogl" href="#" class="btn btn-primary">CofC Waiver</a>
        <a id="notesTogl" href="#" class="btn btn-primary">Application Notes</a>

    </div>
    <div>
    <h2 class="row justify-content-between logo"><span class="col">'. @$row['first_name'] .' ' . @$row['last_name'] . '</span><span class="col text-right">Status: ' . $status . '</span></h2>
    </div>

    <iframe src="uploaded_waivers/test.pdf" width="100%" height="100%" class="d-none" id="waiver1"></iframe> 
    <iframe src="uploaded_waivers/Untitled.png" width="100%" height="100%" class="d-none" id="waiver2"></iframe> 

    <img class="d-none" id="waiver3">
    <div class="d-none" id="notes">
        <fieldset class="border border-dark p-2">
            <legend class="w-50">Application Notes</legend>
                <section class="row">
                <article class="col-12">
                    <div class="form-group row">
                        <label for="notes" class=" col-sm-2 col-form-label">Notes:</label>
                        <div class="col-sm-10">
                            <label class="form-control-plaintext" id="notes">'. nl2br(@$row['application_notes']) .'<br></label>
                        </div>
                    </div>
                </article>
                </section>
        </fieldset>
    </div>

    <form class="container" id="application">
    <fieldset class="border border-dark p-2">
        <legend class="w-50">Student Information</legend>
            <section class="row">
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="lName" class=" col-sm-4 col-form-label">Last Name:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="lName">'. @$row['last_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fName" class=" col-sm-4 col-form-label">First Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="fName">'. @$row['first_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class=" col-sm-4 col-form-label">Email Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="email">'. @$row['email'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="school" class=" col-sm-4 col-form-label">School: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="school">'. @$row['school_attending_in_fall'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dob" class=" col-sm-4 col-form-label">Date of Birth: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="dob">'. @$row['date_of_birth'] .'</label>
                        </div>
                    </div>
 
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="addr" class=" col-sm-4 col-form-label">Address:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="addr">'. @$row['address'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class=" col-sm-4 col-form-label">City:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="city">'. @$row['city'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="state" class=" col-sm-4 col-form-label">State:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="state">'. @$row['state'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="zip" class=" col-sm-4 col-form-label">Zip Code:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="zip">'. @$row['zip_code'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="risingGradeLevel" class=" col-sm-4 col-form-label">Rising Grade Level:</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="risingGradeLevel">'. @$row['rising_grade_level'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="college" class=" col-sm-4 col-form-label">College of Interest: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="college">'. @$row['college_of_interest'] .'</label>
                        </div>
                    </div>
                    
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="parentsCollege" class=" col-sm-4 col-form-label">Parents Attend College?</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="parentsCollege">'. @$row['parents_college'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allerList" class=" col-sm-4 col-form-label">List of Allergies: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="allerList">'. @$row['allergies'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="shirtSize" class=" col-sm-4 col-form-label">Participant T-Shirt Size: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="shirtSize">'. @$row['shirt_size'] .'</label>
                        </div>
                    </div>
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="militaryRelatives" class=" col-sm-4 col-form-label">Relatives in Military? </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="militaryRelatives">'. @$row['relatives_in_military'] . ', '. @$row['relatives_military_branch'] . '</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="meds" class=" col-sm-4 col-form-label">List of Medications: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="meds">'. @$row['medications'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stemInterest" class=" col-sm-4 col-form-label">Stem Interests</label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="stemInterest"></label>
                        </div>
                    </div>
                </article>  
            </section>
    </fieldset>
            
<fieldset class="border border-dark p-2">           
    <legend class="w-50">Parent/Guardian Information</legend>
            <section class="row"><!-- Beginning of parent 1 -->
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="pLName1" class=" col-sm-4 col-form-label">Last Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pLName1">'. @$row['primary_parent_last_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pFName1" class=" col-sm-4 col-form-label">First Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pFName1">'. @$row['primary_parent_first_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pEmail1" class=" col-sm-4 col-form-label">Email Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pEmail1">'. @$row['primary_parent_email'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="priPhone1" class=" col-sm-4 col-form-label">Primary Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="priPhone1">'. @$row['primary_parent_primary_phone'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="altPhone1" class=" col-sm-4 col-form-label">Alternate Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="altPhone1">'. @$row['primary_parent_alt_phone'] .'</label>
                        </div>
                    </div><br>
                    
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="pAddr1" class=" col-sm-4 col-form-label">Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pAddr1">'. @$row['primary_parent_address'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pCity1" class=" col-sm-4 col-form-label">City: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pCity1">'. @$row['primary_parent_city'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pState1" class=" col-sm-4 col-form-label">State: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pState1">'. @$row['primary_parent_state'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pZip1" class=" col-sm-4 col-form-label">Zip Code: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pZip1">'. @$row['primary_parent_zip_code'] .'</label>
                        </div>
                    </div>
                    
                </article><!-- End of parent 1-->
            </section>
            
            <strong>Parent/Guardian 2</strong>
            <section class="row">
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="pLName2" class=" col-sm-4 col-form-label">Last Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pLName2">'. @$row['alt_parent_last_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pFName2" class=" col-sm-4 col-form-label">First Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pFName2">'. @$row['alt_parent_first_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pEmail2" class=" col-sm-4 col-form-label">Email Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pEmail2">'. @$row['alt_parent_email'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="priPhone2" class=" col-sm-4 col-form-label">Primary Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="priPhone2">'. @$row['alt_parent_primary_phone'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="altPhone2" class=" col-sm-4 col-form-label">Alternate Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="altPhone2">'. @$row['alt_parent_alt_phone'] .'</label>
                        </div>
                    </div><br>
                    
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="pAddr2" class=" col-sm-4 col-form-label">Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pAddr2">'. @$row['alt_parent_address'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pCity2" class=" col-sm-4 col-form-label">City: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pCity2">'. @$row['alt_parent_city'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pState2" class=" col-sm-4 col-form-label">State: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pState2">'. @$row['alt_parent_state'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pZip2" class=" col-sm-4 col-form-label">Zip Code: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="pZip2">'. @$row['alt_parent_zip_code'] .'</label>
                        </div>
                    </div>              
                </article>
                
            </section>
        </fieldset>
        <fieldset class="border border-dark p-2">
            <legend class="w-50">Emergency Contact and Release Authorization</legend>
            <section class="row">
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="emName" class=" col-sm-4 col-form-label">Name: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emName">'. @$row['contact_name'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="relationship" class=" col-sm-4 col-form-label">Relationship to child: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="relationship">'. @$row['contact_relationship'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emPriPhone" class=" col-sm-4 col-form-label">Primary Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emPriPhone">'. @$row['contact_primary_phone'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emAltPhone" class=" col-sm-4 col-form-label">Alternate Phone #: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emAltPhone">'. @$row['contact_alt_phone'] .'</label>
                        </div>
                    </div>
                </article>
                <article class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="emAddr" class=" col-sm-4 col-form-label">Address: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emAddr">'. @$row['contact_address'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emCity" class=" col-sm-4 col-form-label">City: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emCity">'. @$row['contact_city'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emState" class=" col-sm-4 col-form-label">State: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emState">'. @$row['contact_state'] .'</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emZip" class=" col-sm-4 col-form-label">Zip Code: </label>
                        <div class="col-sm-8">
                            <label class="form-control-plaintext" style="color: #356f94; font-style: italic;" id="emZip">'. @$row['contact_zip_code'] .'</label>
                        </div>
                    </div>
                </article>
            </section>
            
            </fieldset>
            </form>


            <form class="fixed-bottom bg-secondary p-4 rounded" action="review_application.php" method="POST">
            <div class="form-group">
                <label for="update" class="text-center">Decision</label>
                <select id="statChanger" class="form-control" name="update">
                    <option selected disabled>Select an Option</option>
                    <option value="Approved"';
                    if($status == "Approved" )
                    { 
                        echo 'hidden';
                    }
                    echo' >Approved</option>
                
                    <option value="Denied"';
                    if($status == "Denied" )
                    { 
                        echo 'hidden';
                    }
                    echo' >Denied</option>

                    <option value="Pending"';
                    if($status == "Pending" )
                    { 
                        echo 'hidden';
                    }
                    echo' >Pending</option>

                    <option value="Cancelled"';
                    if($status == "Cancelled" )
                    { 
                        echo 'hidden';
                    }
                    echo' >Cancelled</option>
         
                </select>
            </div>
            <label for="notes" class="align-top">Notes:</label>
            <textarea name="notes"></textarea>
            <div id="denyOption" class="d-none" >
            <div class="radio">
                <label><input type="radio" name="optradio" value="Age over/under 12-14">Age over/under 12-14</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optradio" value="Over/under rising 8th and 9th">Over/under rising 8th and 9th</label>
            </div>
            </div>
            <div class="text-center"> 
                <button type="submit" class="btn btn-primary">Update</button> 
                <input type="hidden" name="id" value="' . $id . '" />
            </div>

            </form>

    ';

    

}
else 
{ // Not a valid user ID.
    echo '<div class="container bg-light p-3" style="margin: 5% auto; ">
    <a href="manage_applications.php"><button type="button" class="btn btn-primary"><-Back</button></a>';
    echo '<p class="text-danger">This page has been accessed in error.</p>';
}

mysqli_close($dbc);
?>

<?php include_once("includes/footer.html");?>
