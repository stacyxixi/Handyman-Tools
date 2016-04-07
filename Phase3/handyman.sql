SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



CREATE DATABASE IF NOT EXISTS handyman;
USE handyman;

/*
Table for customer
*/
DROP TABLE IF EXISTS CUSTOMER;
CREATE TABLE IF NOT EXISTS CUSTOMER (
 Username VARCHAR(36) NOT NULL,
 Password VARCHAR(20) NOT NULL,
 Fname  VARCHAR(25) NOT NULL,
 Lname  VARCHAR(40) NOT NULL,
 Work_area_code CHAR(3) NULL,
 Work_local_number CHAR(7) NULL,
 Home_area_code CHAR(3)  NULL,
 Home_local_number CHAR(7) NULL,
 Address  VARCHAR(200) NULL,
PRIMARY KEY (Username) 
);

/*
Dumping data for table CUSTOMER
*/
Insert into 
CUSTOMER	
Values ('bxia33'	,	'1234' 	,	'Bo', 'Xia', '212','2357640','211','2357640', 'MN' 	);
Insert into 
CUSTOMER	
Values ('Cook'	,	'5678'		,'COOK','CHICKEN', 	'212','2357640','211','2357640', 'TN'	);
Insert into 
CUSTOMER	
Values ('XX'	,	'7631'		,'XIAOXI','WANG', 	'211','110108','222','1101051', 'GA'	);
Insert into 
CUSTOMER	
Values ('GUHU',	'1234'	,	'GU', 'HONG', '211','110108','222','1101051', 'NY');
Insert into 
CUSTOMER	
Values ('MU'	,	'2222F'	,	'MU','ER',  '225','3313677','226','2205785', 'WA'	);
Insert into 
CUSTOMER	
Values ('AA'	,	'AA1'	,	'AAF','AAL',  '001','1111111','011','1111110', 'AA_adress'	);
Insert into 
CUSTOMER	
Values ('BB'	,	'BB1'	,	'BBF','BBL',  '002','2222222','022','2222220', 'BB_adress'	);
Insert into 
CUSTOMER	
Values ('CC'	,	'CC1'	,	'CCF','CCL',  '003','3333333','033','3333330', 'CC_adress'	);
Insert into 
CUSTOMER	
Values ('DD'	,	'DD1'	,	'DDF','DDL',  '004','4444444','044','4444440', 'DD_adress'	);
Insert into 
CUSTOMER	
Values ('EE'	,	'EE1'	,	'EEF','EEL',  '005','5555555','055','5555550', 'EE_adress'	);
Insert into 
CUSTOMER	
Values ('FF'	,	'FF1'	,	'FFF','FFL',  '006','6666666','066','6666660', 'FF_adress'	);
Insert into 
CUSTOMER	
Values ('HH'	,	'HH1'	,	'HHF','HHL',  '007','7777777','077','7777770', 'EE_adress'	);



/*
Table for CLERK
*/
DROP TABLE IF EXISTS CLERK;
CREATE TABLE IF NOT EXISTS CLERK (
 Username VARCHAR(16) NOT NULL,
 Password VARCHAR(20) NOT NULL,
 Fname  VARCHAR(25) NOT NULL,
 Lname  VARCHAR(40) NOT NULL,
 PRIMARY KEY (Username) 
 );

 /*
Dumping data for table CLERK
*/
 
Insert into	
Clerk 
values (	'123456789012345a'	,'123456'	,'Mike','lala'	);
Insert into	
Clerk 
values (	'123456789012345b'	, '567890'	,'kaka', 'didi'	);
 
 
 
 
 /*
Table for RESERVATION
*/
DROP TABLE IF EXISTS RESERVATION;
CREATE TABLE IF NOT EXISTS RESERVATION (
 Reservation_Number INT NOT NULL,
 Start_date DATE NOT NULL,
 End_date DATE NOT NULL,
 Request_customer VARCHAR(36) NOT NULL,
 Pickup_clerk VARCHAR(16) NOT NULL,
 Dropoff_clerk VARCHAR(16) NOT NULL,
 Pickup_creditcard_number CHAR(16) NULL,
 Pickup_creditcard_expdate DATE NOT NULL,
PRIMARY KEY (Reservation_Number),
FOREIGN KEY (Request_customer) REFERENCES CUSTOMER(Username),
FOREIGN KEY (Pickup_clerk) REFERENCES CLERK(Username),
FOREIGN KEY (Dropoff_clerk) REFERENCES CLERK(Username)
);



 /*
Dumping data for table RESERVATION
*/
Insert into	
reservation 
values (1,	'20160320', '20160405', 'bxia33', '123456789012345a', '123456789012345a', '1234567890123451','201704');

Insert into	
reservation 
values (2,	'20160420', '20160505', 'AA', '123456789012345a', '123456789012345a', '1234567890123452','201705');

Insert into	
reservation 
values (3,	'20160520', '20160605', 'BB', '123456789012345a', '123456789012345a', '1234567890123453','201706');

Insert into	
reservation 
values (4,	'20160720', '20160805', 'CC', '123456789012345a', '123456789012345a', '1234567890123454','201707');

Insert into	
reservation 
values (5,	'20160920', '20161005', 'DD', '123456789012345b', '123456789012345b', '1234567890123455','201708');

Insert into	
reservation 
values (6,	'20161020', '20161105', 'EE', '123456789012345b', '123456789012345b', '1234567890123456','201709');

Insert into	
reservation 
values (7,	'20161120', '20161205', 'FF', '123456789012345b', '123456789012345b', '1234567890123457','201710');







 /*
Table for TOOL
*/
DROP TABLE IF EXISTS TOOL;
CREATE TABLE IF NOT EXISTS TOOL (
 Tool_ID INT NOT NULL,
 Abbrdesc VARCHAR(50) NOT NULL,
 Fulldesc VARCHAR(100) NOT NULL,
 Tool_Type  VARCHAR(50) NOT NULL,
 Is_sold  CHAR(1) DEFAULT 'N',
 Purchase_price DECIMAL(10,2) NOT NULL,
 Deposit DECIMAL(10,2) NOT NULL,
 Rental DECIMAL(10,2) NOT NULL,
 Add_clerk VARCHAR(16) NOT NULL,
PRIMARY KEY (Tool_ID),
FOREIGN KEY (Add_clerk) REFERENCES CLERK(Username) 
);


 /*
Dumping data for table TOOL
*/
Insert into
TOOL
values(1, 'daye', 'dayede', 'Hand Tools', 'N', 100, 50, 2, '123456789012345a');




 /*
Table for ACCESSORIES
*/
DROP TABLE IF EXISTS ACCESSORIES;
CREATE TABLE IF NOT EXISTS ACCESSORIES (
 Tool_ID INT NOT NULL,
 Accessories VARCHAR(50)  NOT NULL,
PRIMARY KEY (Tool_ID, Accessories),
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID) 
);



 /*
Table for SERVICE_ORDER
*/
DROP TABLE IF EXISTS SERVICE_ORDER;
CREATE TABLE IF NOT EXISTS SERVICE_ORDER (
 Tool_ID INT NOT NULL,
 Start_date DATE NOT NULL,
 End_date DATE NOT NULL,
 Repair_cost DECIMAL(10,2) NOT NULL,
PRIMARY KEY (Tool_ID, Start_date),
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID)
);



 /*
Table for RESERVE
*/
DROP TABLE IF EXISTS RESERVE;
CREATE TABLE IF NOT EXISTS RESERVE (
 Reservation_number INT NOT NULL,
 Tool_ID  INT NOT NULL,
 PRIMARY KEY (Reservation_number, Tool_ID),
 FOREIGN KEY (Reservation_number) REFERENCES RESERVATION(Reservation_number), 
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID)
);
