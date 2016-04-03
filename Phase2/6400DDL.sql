CREATE TABLE CUSTOMER (
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

CREATE TABLE CLERK (
 Username VARCHAR(16) NOT NULL,
 Password VARCHAR(20) NOT NULL,
 Fname  VARCHAR(25) NOT NULL,
 Lname  VARCHAR(40) NOT NULL,
 PRIMARY KEY (Username) 
 );

CREATE TABLE RESERVATION (
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

CREATE TABLE TOOL (
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



CREATE TABLE ACCESSORIES (
 Tool_ID INT NOT NULL,
 Accessories VARCHAR(50)  NOT NULL,
PRIMARY KEY (Tool_ID, Accessories),
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID) 
);



CREATE TABLE SERVICE_ORDER (
 Tool_ID INT NOT NULL,
 Start_date DATE NOT NULL,
 End_date DATE NOT NULL,
 Repair_cost DECIMAL(10,2) NOT NULL,
PRIMARY KEY (Tool_ID, Start_date),
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID)
);

CREATE TABLE RESERVE (
 Reservation_number INT NOT NULL,
 Tool_ID  INT NOT NULL,
 PRIMARY KEY (Reservation_number, Tool_ID),
 FOREIGN KEY (Reservation_number) REFERENCES RESERVATION(Reservation_number), 
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID)
);



$query = mysql_query("Select username from customer where username = '$username'")
if (mysql_num_rows($query)=0){
	echo 'user not exists!';}

$query_ps = mysql_query("Select username from customer where username = '$username' and password = '$password'")
if (mysql_num_rows($query)=0 && mysql_num_rows($query_ps) =0{
	echo 'password is not correct';}
	




