/*create db*/
CREATE DATABASE IF NOT EXISTS TWT2231_PharmacyInventory;
USE TWT2231_PharmacyInventory;

/*create users table*/
CREATE TABLE IF NOT EXISTS users (
	uid INT(11) PRIMARY KEY AUTO_INCREMENT,
	uemail VARCHAR(765),
	upw VARCHAR(90),
	uname VARCHAR(300)
);

/*insert example records into users table*/
DELETE FROM users;
INSERT INTO users (uemail,upw,uname)
VALUES ("kskoh@bluepharmacy.com","123456","KS Koh"),
("123@123.com","123456","123"),
("leyong@bluepharmacy.com","123456","Leyong");

/*create inventory table*/
CREATE TABLE IF NOT EXISTS inventory(
	inv_id INT(11) PRIMARY KEY AUTO_INCREMENT,
	inv_prd_id INT(11),
	inv_qty INT(11)
);

/*create medicine master table*/
CREATE TABLE IF NOT EXISTS mst_medicine(
	drug_id INT(11) PRIMARY KEY AUTO_INCREMENT,
	drug_name VARCHAR(255),
	drug_dosage VARCHAR(100),
	drug_form VARCHAR(100)
);

/*insert example records into medicine master table*/
DELETE FROM mst_medicine;
INSERT INTO mst_medicine
VALUES
(1,"Amoxicillin","500","Cap"),
(2,"Amoxicillin","250","Cap"),
(3,"Amoxicillin","125/5","Susp."),
(4,"Ampicloxicillin","500","Cap"),
(5,"Ampiclox Neonatal","90",""),
(6,"Antibiotic Ointment","",""),
(7,"ASA(Aspirin)","",""),
(8,"Ascorbic Acid/Vitamin C","200",""),
(9,"Atenolol","50",""),
(10,"Betamethazone Ointment","0.001",""),
(11,"Boric Acid","",""),
(12,"Cetrizine","10",""),
(13,"Chloramphenicol","150",""),
(14,"Chloramphenicol","0.005",""),
(15,"Chlorphenarimine (Piriton)","4mg",""),
(16,"Chlorphenarimine (Piriton)","Syrup","5L jugs"),
(17,"Cipro","500",""),
(18,"Clotrimazole","30g",""),
(19,"Clotrimazole","0.01","Cream"),
(20,"Clotrimazole","200mg","Pessaries"),
(21,"Cloxacillin","250",""),
(22,"Crepe Bandage","Large",""),
(23,"Crepe Bandage","Small",""),
(24,"Diazepam","5mg",""),
(25,"Diclofenac","50mg",""),
(26,"Doxyccline","100",""),
(27,"Ducolox (Bisacodyl)","5",""),
(28,"Enalapril","5",""),
(29,"Enhancin","625",""),
(30,"Erythromycin","250",""),
(31,"Erythromycin","200/5","Susp."),
(32,"Fansidar (Methomine S)","25/500",""),
(33,"Flagyl/Metronidazole","400",""),
(34,"Flagyl/Metronidazole","200",""),
(35,"Flagyl/Metronidazole","200/5","Susp."),
(36,"FeSO4 (Ferrous Sulfate)","200",""),
(37,"Fe/Folate (Folic Acid)","5",""),
(38,"Gentamycin","0.003","Eye Drops"),
(39,"Griseofulvin","250",""),
(40,"HCTZ","50",""),
(41,"Hydrocortisone","100",""),
(42,"Hyoscine","",""),
(43,"Ibuprofen","400",""),
(44,"Ibuprofen","200",""),
(45,"Ibuprofen","100/5","Susp."),
(46,"FeSO4 (Ferrous Sulfate)","Syrup","5L jugs"),
(47,"Cephalexin (Keflex)","125/5",""),
(48,"Mebendazole","100",""),
(49,"(Magnesium)Antacid Tablets","",""),
(50,"Antacid Liquids","",""),
(51,"Multivitamin","","Tab"),
(52,"Multivitamin Syrup","","5L jugs"),
(53,"Nitrofurantoin","100",""),
(54,"Nystatin","30ml",""),
(55,"Omeprazole","20mg",""),
(56,"Paracetamol","500",""),
(57,"Paracetamol","100",""),
(58,"Paracetamol","120/5","5L jugs"),
(59,"Parafin","Liquid","5L jugs"),
(60,"Phenobarbital","30",""),
(61,"Prednisone","5",""),
(62,"Prednisolone","5ml",""),
(63,"Promethazine","25",""),
(64,"Promethazine","","5L jugs"),
(65,"Quinine","300",""),
(66,"Quinine","20%/15ml","Drops"),
(67,"Ranitidine","150mg",""),
(68,"Rubem","0.05","Cream"),
(69,"Secnidazole","500",""),
(70,"Septra (Co-Trimoxazole)","900/60",""),
(71,"Septra (Co-Trimoxazole)","400/80",""),
(72,"Septra (Co-Trimoxazole)","200/40",""),
(73,"Septra (Co-Trimoxazole)","100-20/5","Susp."),
(74,"Tetracycline Opth. Oint.","0.001",""),
(75,"Throatasil","",""),
(76,"Tinidazole","500",""),
(77,"Salbutamol","2mg/5",""),
(78,"Salbutamol","4mg",""),
(79,"Vit. B Complex","",""),
(80,"ACT (Under 6) Falcimon","",""),
(81,"ACT (Adults)","",""),
(82,"ACT (Children 7-13) IDA","",""),
(83,"Aminophylline","100mg",""),
(84,"Amitryptyline","25mg",""),
(85,"Atropine",".6mg/vial",""),
(86,"Beclomethasone 100micgram","100/puff",""),
(87,"Beclomethazone 80mcg","100/puff",""),
(88,"Beclomethasone 40mcg","100/puff",""),
(89,"Benzhexol","5mg",""),
(90,"Menzylpenicillin","5miu",""),
(91,"Carbamazepine(Tegeretol)","200",""),
(92,"Ceftriaxone","500",""),
(93,"Ceftriaxone","15/vial",""),
(94,"Cetrizine","5mg/5",""),
(95,"Chloramphenicol","1g/vial",""),
(96,"Chlorpromazine","25",""),
(97,"Cloxacillin","500",""),
(98,"Dexamethazone","1m",""),
(99,"Diazepam","5/vial",""),
(100,"Diclofenac","100/3",""),
(101,"Enhancin","375",""),
(102,"Frusemide","10mg/ml",""),
(103,"Furazolidone","100mg",""),
(104,"Gacet","250mg",""),
(105,"Gacet","125mg",""),
(106,"Gentamycin","40/vial",""),
(107,"Gentamycin","80/vial",""),
(108,"Hyoscine","20",""),
(109,"Ketoconazole","200",""),
(110,"KY Jelly","",""),
(111,"Levamsole","8",""),
(112,"Levamsole","4mg/5",""),
(113,"Lidocaine","0.01",""),
(114,"Lidocaine","0.02",""),
(115,"Lignocaine","0.02",""),
(116,"Mebendazole","200",""),
(117,"Metformin","5",""),
(118,"Methylated Spirit","",""),
(119,"Metoclopromide","10mg",""),
(120,"Metronidazole","500mg/ml",""),
(121,"Nifedipine","20",""),
(122,"Paracetamol","150/vial",""),
(123,"Penicillin Benzathine","2.4miu",""),
(124,"Promethazine","25/ml",""),
(125,"Propanolol","40mg",""),
(126,"Quinine","200",""),
(127,"Ranitidine","300",""),
(128,"Ranitidine","50mg/2ml",""),
(129,"Salbutamol","100/puff",""),
(130,"Salbutamol","0.005",""),
(131,"Silvadene","0.01",""),
(132,"Theophyline/Ephedrine","150-12",""),
(133,"Vitamin K","10/ml",""),
(134,"Amoxycillin","500","Tab");

/*insert example records into inventory table*/
DELETE FROM inventory;
INSERT INTO inventory (inv_prd_id)
SELECT drug_id FROM mst_medicine;

/*set the quantity of all medicine to 50*/
UPDATE inventory SET inv_qty = 50;

/*add cost and price to the mst_medicine*/
ALTER TABLE mst_medicine ADD COLUMN drug_cost DECIMAL (6,2);
ALTER TABLE mst_medicine ADD COLUMN drug_price DECIMAL (6,2);

/*update cost and price of the mst_medicine*/
UPDATE mst_medicine SET drug_cost = 10;
UPDATE mst_medicine SET drug_price= 20;

/*create dummy record that need to re-order*/
UPDATE inventory SET inv_qty = 4 WHERE inv_id = 1 OR inv_id = 3 OR inv_id = 5 OR inv_id = 7 OR inv_id = 9 OR inv_id = 11 OR inv_id = 13 OR inv_id = 15 OR inv_id = 17 OR inv_id = 19 OR inv_id = 21;

/*create transactions table*/
CREATE TABLE IF NOT EXISTS transactions(
	trans_id INT(11) PRIMARY KEY AUTO_INCREMENT,
	trans_group_id INT(11),
	trans_prd_id INT(11),
	trans_qty_in INT(11),
	trans_qty_out INT(11),
	trans_user INT(11),
	trans_date TIMESTAMP NOT NULL
);

/*dummy data for transaction*/
INSERT INTO transactions (trans_group_id,trans_prd_id,trans_qty_in,trans_qty_out,trans_user)
VALUES
(2,1,0,2,10),
(2,2,0,2,10),
(2,3,0,2,10),
(3,1,0,2,10),
(4,1,0,2,10),
(5,1,0,2,10),
(6,2,0,2,10),
(7,3,0,2,10),
(8,4,0,2,10),
(9,5,0,2,10),
(10,6,0,2,10),
(11,7,0,2,10),
(12,8,0,2,10),
(13,9,0,2,10),
(14,10,0,2,10),
(15,10,0,2,10),
(16,11,0,1,10)
;