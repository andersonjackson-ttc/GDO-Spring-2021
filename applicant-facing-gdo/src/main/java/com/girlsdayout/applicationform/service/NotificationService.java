package com.girlsdayout.applicationform.service;

import com.girlsdayout.applicationform.model.Admin;
import com.girlsdayout.applicationform.model.Applicant;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.FileSystemResource;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;

import javax.mail.Address;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import java.io.File;
import java.util.ArrayList;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

@Service
public class NotificationService {

    //creating javaMailSender object
    @Autowired
    private JavaMailSender javaMailSender;

    public void emailApplicant(Applicant a) throws MessagingException {

        //creating a new email object
        MimeMessage mail = javaMailSender.createMimeMessage();

        //creating helper object needed to add to/from/content/attachments to e-mail
        MimeMessageHelper helper = new MimeMessageHelper(mail, true);

        //getting the parents email from the passed applicant object, and setting it as the "email receiver"
        helper.setTo(a.getPriParentEMail());

        //setting the email sender in the mail object
        helper.setFrom("GDOTestEmail@gmail.com");

        //setting the email subject
        helper.setSubject("Girls Day Out 2020 Application Verification");

        //setting the email body
        helper.setText("Hello " + a.getfName() + ",\n\n" +
                "Thank you for your application for the 2020 summer camp Girls Day Out!\n" +
                "Your Record ID is: " + a.getRecordId() +
                "\n You may also view your application status here: localhost:8080/application/status/" +
                a.getRecordId() +
                "\n Please visit this link to submit your waivers if you haven't already " +
                "done so: localhost:8080/waiver/" + a.getRecordId() + "\n\n");

        //creating new attachment objects
        FileSystemResource boschWaiver = new FileSystemResource(new File("src/main/resources/static/boschWaiver.pdf"));
        FileSystemResource consentWaiver = new FileSystemResource(new File("src/main/resources/static/consentWaiver.pdf"));
        FileSystemResource cofcWaiver = new FileSystemResource(new File("src/main/resources/static/cofcWaiver.pdf"));

        //adding the attachment objects to the e-mail/helper object
        helper.addAttachment("Bosch Waiver", boschWaiver);
        helper.addAttachment("Consent Waiver", consentWaiver);
        helper.addAttachment("CofC Waiver", cofcWaiver);

        //sends the email object through javaMailSender
        javaMailSender.send(mail);

    }

    public void emailApprovers(Iterable<Admin> allAdmins, String type, Applicant app) throws MessagingException {
       ArrayList<Admin> approvers = new ArrayList<Admin>();

       for (Admin a : allAdmins){
           if (a.getJob().toUpperCase().equals("APPROVER")){
               approvers.add(a);
           }
       }

       MimeMessage message = javaMailSender.createMimeMessage();


       for (Admin a : approvers){
           Address to = new InternetAddress(a.getEmail());
           message.addRecipient(Message.RecipientType.TO, to);
       }

        //setting the email sender in the mail object
        message.setFrom("GDOTestEmail@gmail.com");

       if (type.equals("application")){
           //setting the email subject
           message.setSubject("New Application Submitted");

           message.setText("A new application has been submitted for Girl's Day Out 2020 by " + app.getfName() + " " + app.getlName() + ".");
       }
       else{
           //setting the email subject
           message.setSubject("New Set of Waivers Submitted");

           //setting the email body text
           message.setText("A new set of waivers has been submitted for Girl's Day Out 2020 by " + app.getfName() + " " + app.getlName() + ".");
       }

        //sends the message through javamailsender object
        javaMailSender.send(message);
    }

    public void contactEmail(String name, String email, String message){

        //email address that is receiving the contact form messages, assigned to toAddress
        String toAddress = "gdosummercamp@gmail.com";

        //creating new simplemailmessage object
        SimpleMailMessage mail = new SimpleMailMessage();

        //setting the "To" field of email
        mail.setTo(toAddress);

        //setting the subject field of email
        mail.setSubject("Girl's Day Out Question/Concern");

        //setting the text field of email
        mail.setText("A new message has been sent through the Contact Us page on the GDO website. Please view the message below:\n\n" +
                "Name: " + name + "\nE-Mail Address: " + email + "\n\nMessage: " + message +
                "\n\n**** THIS IS AN AUTOMATED MESSAGE PLEASE DO NOT REPLY TO THIS EMAIL ****");

        //sending the mail object
        javaMailSender.send(mail);
    }

    public void cancellationEmail(String name, String email, String message){

	//creating a timestamp of the current date and time
	LocalDateTime dateTime = LocalDateTime.now();

	//formatting the date and time
	DateTimeFormatter dateTimeFormat = DateTimeFormatter.ofPattern("MM-dd-yyyy HH:mm");
	String formattedDateTime = dateTime.format(dateTimeFormat);

	//parent email address that is receiving the cancellation notification
	String toAddress = email;

    //email address that is receiving the cancellation form messages, assigned to toAdminAddress
    String toAdminAddress = "gdosummercamp@gmail.com";

    //creating new simplemailmessage object
    SimpleMailMessage mail = new SimpleMailMessage();

	//creating new admin simplemailmessage object
	SimpleMailMessage adminMail = new SimpleMailMessage();

    //setting the "To" field of parent email
    mail.setTo(toAddress);

    //setting the subject field of parent email
    mail.setSubject("Girl's Day Out Cancellation");

	//setting the text field of parent email
	mail.setText("A request for the cancellation of " + name + "'s application to Girls Day out has been made on " + formattedDateTime + 
		".\nIf the cancellation request was not made by you or you wish to revoke your request, please message us through our website" +
		"\nwithin 48 hours of receiving this email." + 
		"\n\n**** THIS IS AN AUTOMATED MESSAGE PLEASE DO NOT REPLY TO THIS EMAIL ****");

	//setting the "To" field of the admin email
	adminMail.setTo(toAdminAddress);

	//setting the subject field of admin email
	adminMail.setSubject("Girls Day Out Cancellation");

    //setting the text field of admin email
    adminMail.setText("A new message has been sent through the Cancellation page on the GDO website. Please view the message below:\n\n" +
         "Name: " + name + "\nE-Mail Address: " + email + "\n\nMessage: " + message + "\n\nat:" + formattedDateTime +
         "\n\n**** THIS IS AN AUTOMATED MESSAGE PLEASE DO NOT REPLY TO THIS EMAIL ****");

    //sending the mail object
    javaMailSender.send(mail);

	//sending the adminMail object
	javaMailSender.send(adminMail);
    }

    public void emailApprovedApplicant(Applicant a) throws MessagingException {

        //creating a new email object
        MimeMessage mail = javaMailSender.createMimeMessage();

        //creating helper object needed to add to/from/content/attachments to e-mail
        MimeMessageHelper helper = new MimeMessageHelper(mail, true);

        //setting the email subject
        helper.setSubject("Your Girls Day Out 2021 Application Decision is Ready!");

        //setting the email body
        helper.setText("Hello " + a.getfName() + ",\n\n" +
                "To view your Girls Day Out 2021 application decision, " +
                "log in to your application portal here: localhost:8080/application/status/" +
                "\n\n If you need anything at all, just let us know." +
                "\nAnd thank you, " + a.getfName() + ", for applying to the Girls Day Out 2021!" + "\n\n");
    }
}
