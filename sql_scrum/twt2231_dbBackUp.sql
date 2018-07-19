/*
SQLyog Community v12.4.0 (64 bit)
MySQL - 10.1.21-MariaDB : Database - twt2231_pharmacyinventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`twt2231_pharmacyinventory` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `twt2231_pharmacyinventory`;

/*Table structure for table `inventory` */

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_prd_id` int(11) DEFAULT NULL,
  `inv_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

/*Data for the table `inventory` */

insert  into `inventory`(`inv_id`,`inv_prd_id`,`inv_qty`) values 
(2,2,93),
(3,3,98),
(4,4,495),
(5,5,35),
(6,6,53),
(7,7,56),
(8,8,57),
(9,9,58),
(10,10,59),
(11,11,60),
(12,12,10),
(13,13,-1),
(14,14,23),
(15,15,3),
(16,16,4),
(17,17,5),
(18,18,6),
(19,19,78),
(20,20,9),
(21,21,10),
(22,22,5),
(23,23,8),
(24,24,60),
(25,25,254),
(26,26,24),
(27,27,5),
(28,28,7),
(29,29,69),
(30,30,87),
(31,31,86),
(32,32,2),
(33,33,25),
(34,34,36),
(35,35,21),
(36,36,10),
(37,37,50),
(38,38,50),
(39,39,50),
(40,40,50),
(41,41,50),
(42,42,50),
(43,43,50),
(44,44,50),
(45,45,50),
(46,46,50),
(47,47,50),
(48,48,50),
(49,49,50),
(50,50,50),
(51,51,50),
(52,52,50),
(53,53,50),
(54,54,50),
(55,55,50),
(56,56,60),
(57,57,50),
(58,58,50),
(59,59,50),
(60,60,50),
(61,61,50),
(62,62,50),
(63,63,50),
(64,64,50),
(65,65,50),
(66,66,50),
(67,67,50),
(68,68,50),
(69,69,50),
(70,70,50),
(71,71,50),
(72,72,50),
(73,73,50),
(74,74,50),
(75,75,50),
(76,76,50),
(77,77,50),
(78,78,50),
(79,79,50),
(80,80,50),
(81,81,50),
(82,82,50),
(83,83,50),
(84,84,50),
(85,85,50),
(86,86,50),
(87,87,50),
(88,88,50),
(89,89,50),
(90,90,50),
(91,91,50),
(92,92,50),
(93,93,50),
(94,94,50),
(95,95,50),
(96,96,50),
(97,97,50),
(98,98,50),
(99,99,50),
(100,100,50),
(101,101,50),
(102,102,50),
(103,103,50),
(104,104,50),
(105,105,50),
(106,106,50),
(107,107,50),
(108,108,50),
(109,109,50),
(110,110,50),
(111,111,50),
(112,112,50),
(113,113,50),
(114,114,50),
(115,115,50),
(116,116,50),
(117,117,50),
(118,118,50),
(119,119,50),
(120,120,50),
(121,121,50),
(122,122,50),
(123,123,50),
(124,124,50),
(125,125,50),
(126,126,50),
(127,127,50),
(128,128,70),
(129,129,50),
(130,130,50),
(131,131,50),
(132,132,50),
(133,133,50),
(134,134,50),
(137,139,12);

/*Table structure for table `mst_medicine` */

DROP TABLE IF EXISTS `mst_medicine`;

CREATE TABLE `mst_medicine` (
  `drug_id` int(11) NOT NULL AUTO_INCREMENT,
  `drug_name` varchar(255) DEFAULT NULL,
  `drug_dosage` varchar(100) DEFAULT NULL,
  `drug_form` varchar(100) DEFAULT NULL,
  `drug_cost` decimal(6,2) DEFAULT NULL,
  `drug_price` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`drug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;

/*Data for the table `mst_medicine` */

insert  into `mst_medicine`(`drug_id`,`drug_name`,`drug_dosage`,`drug_form`,`drug_cost`,`drug_price`) values 
(2,'Amoxicillin','250','Cap',12.13,20.40),
(3,'Amoxicillin','125/5','Susp.',5.00,10.00),
(4,'Ampicloxicillin','500','Cap',24.00,40.00),
(5,'Ampiclox Neonatal','90','',13.50,27.30),
(6,'Antibiotic Ointment','','',12.00,24.00),
(7,'ASA(Aspirin)','','',39.00,79.99),
(8,'Ascorbic Acid/Vitamin C','200','',17.90,20.00),
(9,'Atenolol','50','',16.00,26.00),
(10,'Betamethazone Ointment','0.001','',12.00,20.00),
(11,'Boric Acid','','',15.60,20.00),
(12,'Cetrizine','10','',10.00,20.00),
(13,'Chloramphenicol','150','',10.00,20.00),
(14,'Chloramphenicol','0.005','',10.00,20.00),
(15,'Chlorphenarimine (Piriton)','4mg','',10.00,20.00),
(16,'Chlorphenarimine (Piriton)','Syrup','5L jugs',10.00,20.00),
(17,'Cipro','500','',13.00,20.00),
(18,'Clotrimazole','30g','',10.00,20.00),
(19,'Clotrimazole','0.01','Cream',10.00,20.00),
(20,'Clotrimazole','200mg','Pessaries',10.00,20.00),
(21,'Cloxacillin','250','',10.00,20.00),
(22,'Crepe Bandage','Large','',10.00,20.00),
(23,'Crepe Bandage','Small','',10.00,20.00),
(24,'Diazepam','5mg','',10.00,20.00),
(25,'Diclofenac','50mg','',10.00,20.00),
(26,'Doxyccline','100','',10.00,20.00),
(27,'Ducolox (Bisacodyl)','5','',10.00,20.00),
(28,'Enalapril','5','',10.00,20.00),
(29,'Enhancin','625','',10.00,20.00),
(30,'Erythromycin','250','',10.00,20.00),
(31,'Erythromycin','200/5','Susp.',10.00,20.00),
(32,'Fansidar (Methomine S)','25/500','',10.00,20.00),
(33,'Flagyl/Metronidazole','400','',10.00,20.00),
(34,'Flagyl/Metronidazole','200','',10.00,20.00),
(35,'Flagyl/Metronidazole','200/5','Susp.',10.00,20.00),
(36,'FeSO4 (Ferrous Sulfate)','200','',10.00,20.00),
(37,'Fe/Folate (Folic Acid)','5','',10.00,20.00),
(38,'Gentamycin','0.003','Eye Drops',10.00,20.00),
(39,'Griseofulvin','250','',10.00,20.00),
(40,'HCTZ','50','',10.00,20.00),
(41,'Hydrocortisone','100','',10.00,20.00),
(42,'Hyoscine','','',10.00,20.00),
(43,'Ibuprofen','400','',10.00,20.00),
(44,'Ibuprofen','200','',10.00,20.00),
(45,'Ibuprofen','100/5','Susp.',10.00,20.00),
(46,'FeSO4 (Ferrous Sulfate)','Syrup','5L jugs',10.00,20.00),
(47,'Cephalexin (Keflex)','125/5','',10.00,20.00),
(48,'Mebendazole','100','',10.00,20.00),
(49,'(Magnesium)Antacid Tablets','','',10.00,25.00),
(50,'Antacid Liquids','','',10.00,20.00),
(51,'Multivitamin','','Tab',10.00,20.00),
(52,'Multivitamin Syrup','','5L jugs',10.00,20.00),
(53,'Nitrofurantoin','100','',10.00,20.00),
(54,'Nystatin','30ml','',10.00,20.00),
(55,'Omeprazole','20mg','',10.00,20.00),
(56,'Paracetamol','500','',10.00,20.00),
(57,'Paracetamol','100','',10.00,20.00),
(58,'Paracetamol','120/5','5L jugs',10.00,20.00),
(59,'Parafin','Liquid','5L jugs',10.00,20.00),
(60,'Phenobarbital','30','',10.00,20.00),
(61,'Prednisone','5','',10.00,20.00),
(62,'Prednisolone','5ml','',10.00,20.00),
(63,'Promethazine','25','',10.00,20.00),
(64,'Promethazine','','5L jugs',10.00,20.00),
(65,'Quinine','300','',10.00,20.00),
(66,'Quinine','20%/15ml','Drops',10.00,20.00),
(67,'Ranitidine','150mg','',10.00,20.00),
(68,'Rubem','0.05','Cream',10.00,20.00),
(69,'Secnidazole','500','',10.00,20.00),
(70,'Septra (Co-Trimoxazole)','900/60','',10.00,20.00),
(71,'Septra (Co-Trimoxazole)','400/80','',10.00,20.00),
(72,'Septra (Co-Trimoxazole)','200/40','',10.00,20.00),
(73,'Septra (Co-Trimoxazole)','100-20/5','Susp.',10.00,20.00),
(74,'Tetracycline Opth. Oint.','0.001','',10.00,20.00),
(75,'Throatasil','','',10.00,20.00),
(76,'Tinidazole','500','',10.00,20.00),
(77,'Salbutamol','2mg/5','',10.00,20.00),
(78,'Salbutamol','4mg','',10.00,20.00),
(79,'Vit. B Complex','','',10.00,20.00),
(80,'ACT (Under 6) Falcimon','','',10.00,20.00),
(81,'ACT (Adults)','','',10.00,20.00),
(82,'ACT (Children 7-13) IDA','','',10.00,20.00),
(83,'Aminophylline','100mg','',10.00,20.00),
(84,'Amitryptyline','25mg','',10.00,20.00),
(85,'Atropine','.6mg/vial','',10.00,20.00),
(86,'Beclomethasone 100micgram','100/puff','',10.00,20.00),
(87,'Beclomethazone 80mcg','100/puff','',10.00,20.00),
(88,'Beclomethasone 40mcg','100/puff','',10.00,20.00),
(89,'Benzhexol','5mg','',10.00,20.00),
(90,'Menzylpenicillin','5miu','',10.00,20.00),
(91,'Carbamazepine(Tegeretol)','200','',10.00,20.00),
(92,'Ceftriaxone','500','',10.00,20.00),
(93,'Ceftriaxone','15/vial','',10.00,20.00),
(94,'Cetrizine','5mg/5','',10.00,20.00),
(95,'Chloramphenicol','1g/vial','',10.00,20.00),
(96,'Chlorpromazine','25','',10.00,20.00),
(97,'Cloxacillin','500','',10.00,20.00),
(98,'Dexamethazone','1m','',10.00,20.00),
(99,'Diazepam','5/vial','',10.00,20.00),
(100,'Diclofenac','100/3','',10.00,20.00),
(101,'Enhancin','375','',10.00,20.00),
(102,'Frusemide','10mg/ml','',10.00,20.00),
(103,'Furazolidone','100mg','',10.00,20.00),
(104,'Gacet','250mg','',10.00,20.00),
(105,'Gacet','125mg','',10.00,20.00),
(106,'Gentamycin','40/vial','',10.00,20.00),
(107,'Gentamycin','80/vial','',10.00,20.00),
(108,'Hyoscine','20','',10.00,20.00),
(109,'Ketoconazole','200','',10.00,20.00),
(110,'KY Jelly','','',10.00,20.00),
(111,'Levamsole','8','',10.00,20.00),
(112,'Levamsole','4mg/5','',10.00,20.00),
(113,'Lidocaine','0.01','',10.00,20.00),
(114,'Lidocaine','0.02','',10.00,20.00),
(115,'Lignocaine','0.02','',10.00,20.00),
(116,'Mebendazole','200','',10.00,20.00),
(117,'Metformin','5','',10.00,20.00),
(118,'Methylated Spirit','','',10.00,20.00),
(119,'Metoclopromide','10mg','',10.00,20.00),
(120,'Metronidazole','500mg/ml','',10.00,20.00),
(121,'Nifedipine','20','',10.00,20.00),
(122,'Paracetamol','150/vial','',18.00,20.00),
(123,'Penicillin Benzathine','2.4miu','',10.00,20.00),
(124,'Promethazine','25/ml','',10.00,20.00),
(125,'Propanolol','40mg','',10.00,20.00),
(126,'Quinine','200','',10.00,20.00),
(127,'Ranitidine','300','',10.00,20.00),
(128,'Ranitidine','50mg/2ml','',10.00,20.00),
(129,'Salbutamol','100/puff','',10.00,20.00),
(130,'Salbutamol','0.005','',10.00,20.00),
(131,'Silvadene','0.01','',10.00,20.00),
(132,'Theophyline/Ephedrine','150-12','',10.00,20.00),
(133,'Vitamin K','10/ml','',10.00,20.00),
(134,'Amoxycillin','500','Tab',10.00,20.00),
(139,'testing3','450','cap',13.59,66.00);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_group_id` int(11) DEFAULT NULL,
  `trans_prd_id` int(11) DEFAULT NULL,
  `trans_qty_in` int(11) DEFAULT NULL,
  `trans_qty_out` int(11) DEFAULT NULL,
  `trans_user` int(11) DEFAULT NULL,
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trans_dt` date DEFAULT NULL,
  `trans_time` char(5) DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

/*Data for the table `transactions` */

insert  into `transactions`(`trans_id`,`trans_group_id`,`trans_prd_id`,`trans_qty_in`,`trans_qty_out`,`trans_user`,`trans_date`,`trans_dt`,`trans_time`) values 
(1,2,1,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(2,2,2,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(3,2,3,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(4,3,1,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(5,4,1,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(6,5,1,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(7,6,2,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(8,7,3,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(9,8,4,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(10,9,5,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(11,10,6,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(12,11,7,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(13,12,8,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(14,13,9,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(15,14,10,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(16,15,10,0,2,10,'2017-02-02 12:51:59',NULL,NULL),
(17,16,11,0,1,10,'2017-02-02 12:51:59',NULL,NULL),
(18,17,2,10,NULL,1,'2017-02-04 18:42:42','2017-02-04','18:42'),
(19,17,3,15,NULL,1,'2017-02-04 18:42:42','2017-02-04','18:42'),
(20,18,12,50,NULL,1,'2017-02-04 18:44:46','2017-02-04','18:44'),
(21,18,108,40,NULL,1,'2017-02-04 18:44:46','2017-02-04','18:44'),
(22,18,30,45,NULL,1,'2017-02-04 18:44:46','2017-02-04','18:44'),
(23,19,3,2,NULL,1,'2017-02-04 18:46:36','2017-02-04','18:46'),
(24,19,127,2,NULL,1,'2017-02-04 18:46:36','2017-02-04','18:46'),
(25,19,125,2,NULL,1,'2017-02-04 18:46:36','2017-02-04','18:46'),
(26,20,3,1,NULL,1,'2017-02-04 18:47:05','2017-02-04','18:47'),
(27,20,129,1,NULL,1,'2017-02-04 18:47:05','2017-02-04','18:47'),
(28,21,2,50,NULL,1,'2017-02-04 18:50:47','2017-02-04','18:50'),
(29,21,3,50,NULL,1,'2017-02-04 18:50:47','2017-02-04','18:50'),
(30,22,2,50,NULL,1,'2017-02-04 18:51:22','2017-02-04','18:51'),
(31,22,3,50,NULL,1,'2017-02-04 18:51:22','2017-02-04','18:51'),
(32,23,2,10,NULL,1,'2017-02-04 19:10:38','2017-02-04','19:10'),
(33,23,3,10,NULL,1,'2017-02-04 19:10:38','2017-02-04','19:10'),
(34,23,56,10,NULL,1,'2017-02-04 19:10:38','2017-02-04','19:10'),
(35,24,2,4,NULL,1,'2017-02-04 20:09:54','2017-02-04','20:09'),
(36,25,2,NULL,20,1,'2017-02-04 20:10:19','2017-02-04','20:10'),
(37,26,2,NULL,7,1,'2017-02-04 20:39:07','2017-02-04','20:39'),
(38,27,2,6,NULL,1,'2017-02-04 20:39:34','2017-02-04','20:39'),
(39,28,2,1,NULL,1,'2017-02-04 20:40:03','2017-02-04','20:40'),
(40,28,3,8,NULL,1,'2017-02-04 20:40:03','2017-02-04','20:40'),
(41,28,4,7,NULL,1,'2017-02-04 20:40:03','2017-02-04','20:40'),
(42,29,2,NULL,47,1,'2017-02-04 20:40:38','2017-02-04','20:40'),
(43,29,3,NULL,32,1,'2017-02-04 20:40:38','2017-02-04','20:40'),
(44,29,4,NULL,55,1,'2017-02-04 20:40:38','2017-02-04','20:40'),
(45,30,13,NULL,2,1,'2017-02-04 21:03:43','2017-02-04','21:03'),
(46,31,2,200,NULL,1,'2017-02-05 15:33:13','2017-02-05','15:33'),
(47,32,2,NULL,150,1,'2017-02-05 15:33:22','2017-02-05','15:33'),
(48,33,2,NULL,10,1,'2017-02-05 15:40:24','2017-02-05','15:40'),
(49,34,3,10,NULL,1,'2017-02-05 18:43:31','2017-02-05','18:43'),
(50,34,128,20,NULL,1,'2017-02-05 18:43:31','2017-02-05','18:43'),
(51,35,4,500,NULL,2,'2017-02-05 18:58:44','2017-02-05','18:58'),
(52,36,4,NULL,10,1,'2017-02-05 19:09:44','2017-02-05','19:09'),
(53,37,5,10,NULL,1,'2017-02-05 20:18:03','2017-02-05','20:18'),
(54,38,5,NULL,20,1,'2017-02-05 20:18:13','2017-02-05','20:18'),
(55,39,5,30,NULL,3,'2017-02-05 20:19:05','2017-02-05','20:19'),
(56,40,5,NULL,40,3,'2017-02-05 20:19:16','2017-02-05','20:19');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uemail` varchar(765) DEFAULT NULL,
  `upw` varchar(90) DEFAULT NULL,
  `uname` varchar(300) DEFAULT NULL,
  `ugroup` int(2) DEFAULT NULL,
  `ufirst_login` int(2) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`uid`,`uemail`,`upw`,`uname`,`ugroup`,`ufirst_login`) values 
(1,'kskoh@bluepharmacy.com','bcfd01a282ef2266287d3f6ac1310f43','KS Koh',1,0),
(2,'123@123.com','bcfd01a282ef2266287d3f6ac1310f43','123',1,1),
(3,'leyong@bluepharmacy.com','bcfd01a282ef2266287d3f6ac1310f43','Leyong',1,1),
(4,'admin@bluepharmacy.com','bcfd01a282ef2266287d3f6ac1310f43','Blue Pharmacy Admin',0,0),
(8,'456@456.com','988feef19d3c9f9e595004faf0a41c66','456',1,1),
(9,'789@789.com','14b9f490d7ba89a2c6d0bcb9906ef755','789',1,1),
(10,'qwe@qwe.com','bcfd01a282ef2266287d3f6ac1310f43','qwe',1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
