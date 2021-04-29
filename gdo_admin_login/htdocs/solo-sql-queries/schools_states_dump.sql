-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 12, 2020 at 07:51 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `schoolid` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  PRIMARY KEY (`schoolid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--
INSERT INTO admin_login.schools VALUES (1,'Academy of Arts, Science, and Technology'),(2,'Addelstone Hebrew Academy'),(3,'Alston Middle School'),(4,'Ashley Ridge High'),(5,'Baptist Hill Middle'),(6,'Berkeley High'),(7,'Berkeley Intermediate'),(8,'Berkeley Middle College HS'),(9,'Berkeley Middle School'),(10,'Blythewood High'),(11,'Bishop England'),(12,'Buist Academy'),(13,'Burke High'),(14,'Burke Middle'),(15,'Camp Road Middle'),(16,'Cane Bay High'),(17,'Cane Bay Middle'),(18,'Cario Middle'),(19,'Carvers Bay High'),(20,'CE Williams Middle'),(21,'Charis Academy'),(22,'Charleston Academic Magnet High'),(23,'Charleston Charter School of Math and Science'),(24,'Charleston Progressive Academy'),(25,'Charleston School of the Arts'),(26,'Christ Our King-Stella Maris'),(27,'Clemson University'),(28,'College of Charleston'),(29,'College Park Middle School'),(30,'Colleton County High'),(31,'Colleton County Middle'),(32,'Conway High School'),(33,'Cross High School'),(34,'Daniel Island School'),(35,'Daniel Jenkins Academy'),(36,'Dorchester County Career and Technology Center'),(37,'Dubose Middle'),(38,'East Clarendon Middle-High'),(39,'Edith L. Frierson School of Technology'),(40,'Fairfield Central High'),(41,'Ft. Dorchester High'),(42,'Ft. Johnson Middle School'),(43,'Garrett School of Technology'),(44,'Goose Creek High'),(45,'Goose Creek Primary'),(46,'Greg Mathis Charter'),(47,'Gregg Middle School'),(48,'Guinyard Butler Middle School'),(49,'Hanahan High'),(50,'Hanahan Middle'),(51,'Hanahan Rec and Sports'),(52,'Harbison Theater'),(53,'Haute Gap Middle'),(54,'James Island Charter'),(55,'James Island Middle School'),(56,'Jerry Zucker Middle School'),(57,'Kingstree Middle'),(58,'Laing Middle'),(59,'Lincoln Middle High'),(60,'Lowcountry Tech Academy'),(61,'Macedonia Middle School'),(62,'Manning Middle School'),(63,'Marrington Middle School'),(64,'Military Magnet'),(65,'Morningside Middle'),(66,'Moultrie Middle School'),(67,'North Charleston Academic Magnet High'),(68,'North Charleston High'),(69,'Northwoods Middle School'),(70,'Oakbrook Middle School'),(71,'Oaks Christian School'),(72,'Orange Grove Charter'),(73,'Other (list in details column)'),(74,'Palmetto Scholars Academy'),(75,'Philip Simmons Middle'),(76,'Philip Simmons High'),(77,'Pine Ridge Middle School'),(78,'Pinewood Preparatory School'),(79,'Regional Computer Science Board'),(80,'River Oaks Middle'),(81,'Rollings Middle School of the Arts'),(82,'Sangaree Intermediate School'),(83,'Sangaree Middle School'),(84,'Sedgefield Intermediate'),(85,'Sedgefield Middle'),(86,'Simmons Pinkney Middle School'),(87,'St. Andrews School of Math and Science'),(88,'St. John\'s Catholic School'),(89,'St. John\'s High School'),(90,'St. Stephens Middle School'),(91,'RB Stall High'),(92,'Stratford High'),(93,'Summerville High School'),(94,'Thunderbolt Career and Technology Center'),(95,'Timberland High School'),(96,'Timmonsville High School'),(97,'Trident Technical College'),(98,'University of the Lowcountry'),(99,'Wando High'),(100,'West Ashley Advanced Studies Magnet'),(101,'West Ashley High School'),(102,'West Ashley Middle School'),(103,'West Ashley Montisorre'),(104,'Westview Middle School'),(105,'Whale Branch High'),(106,'Woodland High');
COMMIT;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `stateid` int(11) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  `state_abbr` varchar(45) NOT NULL,
  PRIMARY KEY (`stateid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!140101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

INSERT INTO admin_login.states VALUES (1,'Alabama','AL'),(2,'Alaska','AK'),(3,'Arizona','AZ'),(4,'Arkansas','AR'),(5,'California','CA'),(6,'Colorado','CO'),(7,'Connecticut','CT'),(8,'Delaware','DE'),(9,'District of Columbia','DC'),(10,'Florida','FL'),(11,'Georgia','GA'),(12,'Hawaii','HI'),(13,'Idaho','ID'),(14,'Illinois','IL'),(15,'Indiana','IN'),(16,'Iowa','IA'),(17,'Kansas','KS'),(18,'Kentucky','KY'),(19,'Louisiana','LA'),(20,'Maine','ME'),(21,'Maryland','MD'),(22,'Massachusetts','MA'),(23,'Michigan','MI'),(24,'Minnesota','MN'),(25,'Mississippi','MS'),(26,'Missouri','MO'),(27,'Montana','MT'),(28,'Nebraska','NE'),(29,'Nevada','NV'),(30,'New Hampshire','NH'),(31,'New Jersey','NJ'),(32,'New Mexico','NM'),(33,'New York','NY'),(34,'North Carolina','NC'),(35,'North Dakota','ND'),(36,'Ohio','OH'),(37,'Oklahoma','OK'),(38,'Oregon','OR'),(39,'Pennsylvania','PA'),(40,'Rhode Island','RI'),(41,'South Carolina','SC'),(42,'South Dakota','SD'),(43,'Tennessee','TN'),(44,'Texas','TX'),(45,'Utah','UT'),(46,'Vermont','VT'),(47,'Virginia','VA'),(48,'Washington','WA'),(49,'West Virginia','WV'),(50,'Wisconsin','WI'),(51,'Wyoming','WY');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
