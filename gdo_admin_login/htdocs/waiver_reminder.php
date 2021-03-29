<?php session_start();?>
<?php

        
        if(mysqli_query ($dbc, $q))
        {
           

                //sends an email to the student to remind them to finish the waivier
                $m = mysqli_query($dbc, "SELECT email FROM applicant WHERE id=$approvedApp");
                $mail = mysqli_fetch_assoc($m);
                $studentemail = $mail['email'];
                $mailsubject = "Waivier is incomplete";
                $mailcontents = "It would appear that you have not completed your waiver yet. Log in to your application portal and finish the waiver as soon as possible!";
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
                }
               
}
