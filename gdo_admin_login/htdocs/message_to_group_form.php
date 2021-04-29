<?php session_start();?>
<?php

    include_once("includes/header.php");
    
	$page_title = 'Send a Message'; 
	include_once ('includes/frame.html');

    //The beginnings of a form to send a message to applicants
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['subject']) && !empty($_POST['message'])){
            $body = "Subject: {$_POST['subject']}\nMessage: {$_POST['message']}";
            $body = wordwrap($body, 1000);
            mail('applicantsMailsFromDB@example.com', 'Important notice GDO', $body, "From: GDO admission");
            echo'<p><em>Message sent!</em></p>';
            $_POST = [];
        } else{
            echo'<p style="font-weight: bold>Please fill out the form completely<\p>';
        }
    }
?>            
    <h1>Send a Message</h1>
    <form action="message_to_group_form.php" method="post">
        <p>Subject: <input type="text" name="subject" size="30" maxlength="70" value="<?php if(isset($_POST['subject'])) echo $_POST['subject']; ?>"></p>
        <p>Subject: <textarea name="message" rows="20" cols="30"><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea></p>
        <p><input type="submit" name="submit" value="Send email"></p>
    </form>
   

<?php include_once("includes/footer.html");?>