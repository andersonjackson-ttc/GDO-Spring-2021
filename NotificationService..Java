package com.girlsdayout.applicationform.service;

import com.girlsdayout.applicationform.model.Admin;
import com.girlsdayout.applicationform.model.Applicant;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
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
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

@Service
public class NotificationService {

    @Value("${spring.EMAIL_CONTENT_FILE_PATH}")
    private String EMAIL_CONTENT_FILE_PATH;

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

        // Initializing emailSubject and emailBody string
        String emailSubject = "";
        String emailBody = "";

        /*
         * Try/Catch method that will read the file.
         * First line gets assigned to emailSubject.
         * Second line and on gets assigned to emailBody.
         */
        try{
            StringBuilder str = new StringBuilder();
            File emailFile = new File(EMAIL_CONTENT_FILE_PATH);
            Scanner emailFileReader = new Scanner(emailFile);
            // if file has content, assign first line to subject
            if (emailFileReader.hasNextLine()) {
                emailSubject = emailFileReader.nextLine();
            }
            //while there are still lines to be read, append to stringbuilder for emailBody
            while (emailFileReader.hasNextLine()) {
                str.append(emailFileReader.nextLine());
                str.append("\n");
            }
            // stringBuilder assigned to emailBody
            emailBody = str.toString();
        } catch (FileNotFoundException e) {
            System.out.println("There was an error finding the email body file.");
            e.printStackTrace();
        }

        // removing SUBJECT annotation
        emailSubject = emailSubject.replaceAll("<SUBJECT>", "");

        // removing BODY annotation
        emailBody = emailBody.replaceAll("<BODY>", "");

        //replacing FIRSTNAME with applicant's first name
        emailBody = emailBody.replaceAll("<FIRSTNAME>", a.getfName());

        //replacing RECORDID with applicant's record id
        emailBody = emailBody.replaceAll("<RECORDID>", a.getRecordId());

        //setting the email subject
        helper.setSubject(emailSubject);

        //setting the email body with emailBody variable
        helper.setText(emailBody);

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
    public void missingRequisite(Applicant a) {
    	ArrayList<Applicant> applicants = new ArrayList<Applicant>();
    	for(Applicant app: applicants)
    	{
    	
    	}
    }
}
