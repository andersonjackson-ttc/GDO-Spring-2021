-- MySQL dump 10.13  Distrib 8.0.19, for Linux (x86_64)
--
-- Host: 192.168.6.3    Database: admin_login
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `job` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant` (
  `id` int NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `application_status` varchar(255) DEFAULT NULL,
  `application_notes` varchar(255) DEFAULT NULL,
  `camp_group` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `college_of_interest` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `denied_reason` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `school_attending_in_fall` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `medications` varchar(255) DEFAULT NULL,
  `relatives_military_branch` varchar(255) DEFAULT NULL,
  `relatives_in_military` varchar(255) DEFAULT NULL,
  `parents_college` varchar(255) DEFAULT NULL,
  `record_id` varchar(255) DEFAULT NULL,
  `rising_grade_level` varchar(255) DEFAULT NULL,
  `shirt_size` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `waiver_status` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `contents` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--
INSERT INTO admin_login.emails VALUES ('Approved', 'An update to your status', 'Congratulations, Your application as been approved!'),('Denied', 'An update to your status', 'Your application has been denied.'),('Pending', 'An update to your status', 'Your application is currently pending for review.'),('Cancelled', 'An update to your status', 'Your application has been cancelled. If you think this is a mistake, please contact us.');
COMMIT;

--
-- Table structure for table `emergency_contact`
--

DROP TABLE IF EXISTS `emergency_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emergency_contact` (
  `contact_address` varchar(255) DEFAULT NULL,
  `contact_alt_phone` varchar(255) DEFAULT NULL,
  `contact_city` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_primary_phone` varchar(255) DEFAULT NULL,
  `contact_state` varchar(255) DEFAULT NULL,
  `contact_zip_code` varchar(255) DEFAULT NULL,
  `contact_relationship` varchar(255) DEFAULT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FKd938fgta26xoky2pwqxwqnl4g` FOREIGN KEY (`id`) REFERENCES `applicant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_names`
--

DROP TABLE IF EXISTS `group_names`;
CREATE TABLE IF NOT EXISTS `group_names` (
  `group_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table 'group_names'
--

INSERT INTO admin_login.group_names VALUES ('Super Scientists'),('Marvellous Mathematicians'),('Excited Engineers'),('Awesome Astronauts');
COMMIT;

--
-- Table structure for table `hibernate_sequence`
--

DROP TABLE IF EXISTS `hibernate_sequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hibernate_sequence` (
  `next_val` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hibernate_sequence`
--
INSERT INTO admin_login.hibernate_sequence VALUES (1000);
COMMIT;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `changed_by` varchar(55) COLLATE utf8_unicode_ci NULL,
  `changed_to` varchar(15) COLLATE utf8_unicode_ci NULL,
  `changed_from` varchar(15) COLLATE utf8_unicode_ci NULL,
  `mail_type` varchar(15) COLLATE utf8_unicode_ci NULL,
  `time_submitted` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `date_submitted` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `year_submitted` int(4) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `max_applicants`
--

DROP TABLE IF EXISTS `max_applicants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `max_applicants` (
  `max_applicants` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `max_applicants` VALUES (
  125
);

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent` (
  `alt_parent_address` varchar(255) DEFAULT NULL,
  `alt_parent_alt_phone` varchar(255) DEFAULT NULL,
  `alt_parent_city` varchar(255) DEFAULT NULL,
  `alt_parent_email` varchar(255) DEFAULT NULL,
  `alt_parent_first_name` varchar(255) DEFAULT NULL,
  `alt_parent_last_name` varchar(255) DEFAULT NULL,
  `alt_parent_primary_phone` varchar(255) DEFAULT NULL,
  `alt_parent_state` varchar(255) DEFAULT NULL,
  `alt_parent_zip_code` varchar(255) DEFAULT NULL,
  `primary_parent_address` varchar(255) DEFAULT NULL,
  `primary_parent_alt_phone` varchar(255) DEFAULT NULL,
  `primary_parent_city` varchar(255) DEFAULT NULL,
  `primary_parent_email` varchar(255) DEFAULT NULL,
  `primary_parent_first_name` varchar(255) DEFAULT NULL,
  `primary_parent_last_name` varchar(255) DEFAULT NULL,
  `primary_parent_primary_phone` varchar(255) DEFAULT NULL,
  `primary_parent_state` varchar(255) DEFAULT NULL,
  `primary_parent_zip_code` varchar(255) DEFAULT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FKan1a11c3i14x6gfhrvxkrmodo` FOREIGN KEY (`id`) REFERENCES `applicant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `schoolid` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  PRIMARY KEY (`schoolid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--
INSERT INTO admin_login.schools VALUES (1,'Academy of Arts, Science, and Technology'),(2,'Addelstone Hebrew Academy'),(3,'Alston Middle School'),(4,'Ashley Ridge High'),(5,'Baptist Hill Middle'),(6,'Berkeley High'),(7,'Berkeley Intermediate'),(8,'Berkeley Middle College HS'),(9,'Berkeley Middle School'),(10,'Blythewood High'),(11,'Bishop England'),(12,'Buist Academy'),(13,'Burke High'),(14,'Burke Middle'),(15,'Camp Road Middle'),(16,'Cane Bay High'),(17,'Cane Bay Middle'),(18,'Cario Middle'),(19,'Carvers Bay High'),(20,'CE Williams Middle'),(21,'Charis Academy'),(22,'Charleston Academic Magnet High'),(23,'Charleston Charter School of Math and Science'),(24,'Charleston Progressive Academy'),(25,'Charleston School of the Arts'),(26,'Christ Our King-Stella Maris'),(27,'Clemson University'),(28,'College of Charleston'),(29,'College Park Middle School'),(30,'Colleton County High'),(31,'Colleton County Middle'),(32,'Conway High School'),(33,'Cross High School'),(34,'Daniel Island School'),(35,'Daniel Jenkins Academy'),(36,'Dorchester County Career and Technology Center'),(37,'Dubose Middle'),(38,'East Clarendon Middle-High'),(39,'Edith L. Frierson School of Technology'),(40,'Fairfield Central High'),(41,'Ft. Dorchester High'),(42,'Ft. Johnson Middle School'),(43,'Garrett School of Technology'),(44,'Goose Creek High'),(45,'Goose Creek Primary'),(46,'Greg Mathis Charter'),(47,'Gregg Middle School'),(48,'Guinyard Butler Middle School'),(49,'Hanahan High'),(50,'Hanahan Middle'),(51,'Hanahan Rec and Sports'),(52,'Harbison Theater'),(53,'Haute Gap Middle'),(54,'James Island Charter'),(55,'James Island Middle School'),(56,'Jerry Zucker Middle School'),(57,'Kingstree Middle'),(58,'Laing Middle'),(59,'Lincoln Middle High'),(60,'Lowcountry Tech Academy'),(61,'Macedonia Middle School'),(62,'Manning Middle School'),(63,'Marrington Middle School'),(64,'Military Magnet'),(65,'Morningside Middle'),(66,'Moultrie Middle School'),(67,'North Charleston Academic Magnet High'),(68,'North Charleston High'),(69,'Northwoods Middle School'),(70,'Oakbrook Middle School'),(71,'Oaks Christian School'),(72,'Orange Grove Charter'),(73,'Other (list in details column)'),(74,'Palmetto Scholars Academy'),(75,'Philip Simmons Middle'),(76,'Philip Simmons High'),(77,'Pine Ridge Middle School'),(78,'Pinewood Preparatory School'),(79,'Regional Computer Science Board'),(80,'River Oaks Middle'),(81,'Rollings Middle School of the Arts'),(82,'Sangaree Intermediate School'),(83,'Sangaree Middle School'),(84,'Sedgefield Intermediate'),(85,'Sedgefield Middle'),(86,'Simmons Pinkney Middle School'),(87,'St. Andrews School of Math and Science'),(88,'St. John\'s Catholic School'),(89,'St. John\'s High School'),(90,'St. Stephens Middle School'),(91,'RB Stall High'),(92,'Stratford High'),(93,'Summerville High School'),(94,'Thunderbolt Career and Technology Center'),(95,'Timberland High School'),(96,'Timmonsville High School'),(97,'Trident Technical College'),(98,'University of the Lowcountry'),(99,'Wando High'),(100,'West Ashley Advanced Studies Magnet'),(101,'West Ashley High School'),(102,'West Ashley Middle School'),(103,'West Ashley Montisorre'),(104,'Westview Middle School'),(105,'Whale Branch High'),(106,'Woodland High');
COMMIT;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `stateid` int NOT NULL,
  `state_name` varchar(45) NOT NULL,
  `state_abbr` varchar(45) NOT NULL,
  PRIMARY KEY (`stateid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

INSERT INTO admin_login.states VALUES (1,'Alabama','AL'),(2,'Alaska','AK'),(3,'Arizona','AZ'),(4,'Arkansas','AR'),(5,'California','CA'),(6,'Colorado','CO'),(7,'Connecticut','CT'),(8,'Delaware','DE'),(9,'District of Columbia','DC'),(10,'Florida','FL'),(11,'Georgia','GA'),(12,'Hawaii','HI'),(13,'Idaho','ID'),(14,'Illinois','IL'),(15,'Indiana','IN'),(16,'Iowa','IA'),(17,'Kansas','KS'),(18,'Kentucky','KY'),(19,'Louisiana','LA'),(20,'Maine','ME'),(21,'Maryland','MD'),(22,'Massachusetts','MA'),(23,'Michigan','MI'),(24,'Minnesota','MN'),(25,'Mississippi','MS'),(26,'Missouri','MO'),(27,'Montana','MT'),(28,'Nebraska','NE'),(29,'Nevada','NV'),(30,'New Hampshire','NH'),(31,'New Jersey','NJ'),(32,'New Mexico','NM'),(33,'New York','NY'),(34,'North Carolina','NC'),(35,'North Dakota','ND'),(36,'Ohio','OH'),(37,'Oklahoma','OK'),(38,'Oregon','OR'),(39,'Pennsylvania','PA'),(40,'Rhode Island','RI'),(41,'South Carolina','SC'),(42,'South Dakota','SD'),(43,'Tennessee','TN'),(44,'Texas','TX'),(45,'Utah','UT'),(46,'Vermont','VT'),(47,'Virginia','VA'),(48,'Washington','WA'),(49,'West Virginia','WV'),(50,'Wisconsin','WI'),(51,'Wyoming','WY');
COMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `waiver`
--

DROP TABLE IF EXISTS `waiver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `waiver` (
  `waiver_one` varchar(255) DEFAULT NULL,
  `waiver_three` varchar(255) DEFAULT NULL,
  `waiver_two` varchar(255) DEFAULT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FKpr8b8ui5c45qjpmhn3tsbs6tp` FOREIGN KEY (`id`) REFERENCES `applicant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-14 16:24:12
