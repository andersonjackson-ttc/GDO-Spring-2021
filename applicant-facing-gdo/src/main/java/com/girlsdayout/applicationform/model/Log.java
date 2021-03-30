package com.girlsdayout.applicationform.model;

import javax.persistence.*;
import java.time.LocalDate;
import java.time.LocalTime;
import java.time.Period;
import java.time.Year;




@Entity // Specifies that the class is an entity and is mapped to a DB table
@Table(name = "log")
public class Log {

    //@Id and @GeneratedValue set to AUTO makes the applicant ID set by the database, not by user input
    //@Id
    //@GeneratedValue(strategy=GenerationType.AUTO)
    //@Column(name = "id")
    //private Integer id;

    //Start of columns/variables for applicant table
    @Id
    @Column(name = "id")
    private Integer id;

    @Column(name = "type")
    private String type;

    @Column(name = "changed_to")
    private String changedTo;

    @Column(name = "changed_from")
    private String changedFrom;

    @Column(name = "mail_type")
    private String mailType;

    @Column(name = "time_submitted")
    private String timeSubmitted;

    @Column(name = "date_submitted")
    private String dateSubmitted;

    @Column(name = "year_submitted")
    private Integer yearSubmitted;
    //end of columns/variables for log table

    //getters and setters for all log variables
    public Integer getId() { return id; }

    public String getType() { return type; }

    public String getChangedTo() { return changedTo; }

    public String getChangedFrom() { return changedFrom; }

    public String getMailType() { return mailType; }

    public String getTimeSubmitted() { return timeSubmitted; }

    public String getDateSubmitted() { return dateSubmitted; }

    public Integer getYearSubmitted() { return yearSubmitted; }

    public void setId(Integer id) {
        this.id = id;
    }

    public void setType(String type) {
        this.type = type;
    }

    public void setChangedTo(String changedTo) {
        this.changedTo = changedTo;
    }

    public void setChangedFrom(String changedFrom) {
        this.changedFrom = changedFrom;
    }

    public void setMailType(String mailType) {
        this.mailType = mailType;
    }

    public void setTimeSubmitted() {
	LocalTime currentTime = LocalTime.now();
	String timeString = currentTime.toString().substring(0,5);
        this.timeSubmitted = timeString;
    }

    public void setDateSubmitted() {
	LocalDate currentDate = LocalDate.now();
	String dateString = currentDate.toString().substring(5);
        this.dateSubmitted = dateString;
    }

    public void setYearSubmitted() {
        //gets current year in year class and converts to string, then assigned to this.yearsubmitted
        Year year = Year.now();
        String yearString = year.toString();
	int yearInt = Integer.parseInt(yearString);

        this.yearSubmitted = yearInt;
    }
	//end of getters/setters for all log variables


}
