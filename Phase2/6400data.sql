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




Insert into	
Clerk 
values (	'123456789012345a'	,'123456'	,'Mike','lala'	);
Insert into	
Clerk 
values (	'123456789012345b'	, '567890'	,'kaka', 'didi'	);


Insert into
TOOL
values(1, 'daye', 'dayede', 'Hand Tools', 'N', 100, 50, 2, '123456789012345a');

Insert into
TOOL
values(2, 'grass', 'grasskiller', 'Construction Equipments', 'N', 200, 100, 5, '123456789012345b');

Insert into
TOOL
values(3, 'turf', 'grassremover', 'Construction Equipments', 'N', 150, 20, 1, '123456789012345a');

Insert into
TOOL
values(4, 'block', 'blocker', 'Power Tools', 'N', 500, 250, 10, '123456789012345b');

Insert into
TOOL
values(5, 'air', 'conditioner', 'Construction Equipments', 'Y', 200, 100, 20, '123456789012345a');
Insert into
TOOL
values(6, 'air', 'conditioner', 'Construction Equipments', 'N', 200, 100, 20, '123456789012345a');

Insert into 
Accessories
values(4, 'CANNON');


Insert into	
reservation 
values (2222,	'20160315', '20160405', 'bxia33', '123456789012345a', '123456789012345a', '1234567890123451','20170430');

Insert into	
reservation 
values (1001,	'20160220', '20160305', 'XX', '123456789012345a', '123456789012345b', '1234567890123454','20180430');







Insert into
reserve
values (2222, 1);
Insert into
reserve
values (2222, 6);
Insert into
reserve
values (1001, 2);


Insert into
service_order
values (3, '20160301','20160401', 10.1);

Insert into
service_order
values (3, '20160501','20160401', 10.1);

 Reservation_Number INT NOT NULL,
 Start_date DATE NOT NULL,
 End_date DATE NOT NULL,
 Request_customer VARCHAR(36) NOT NULL,
 Pickup_clerk VARCHAR(16) NOT NULL,
 Dropoff_clerk VARCHAR(16) NOT NULL,
 Pickup_creditcard_number CHAR(16) NULL,
 Pickup_creditcard_expdate DATE NULL,

 Tool_ID INT NOT NULL,
 Abbrdesc VARCHAR(20) NOT NULL,
 Fulldesc VARCHAR(100) NOT NULL,
 Tool_Type  VARCHAR(20) NOT NULL,
 Is_sold  CHAR(1) DEFAULT 'N',
 Purchase_price DECIMAL(10,2) NOT NULL,
 Deposit DECIMAL(10,2) NOT NULL,
 Rental DECIMAL(10,2) NOT NULL,
 Add_clerk VARCHAR(16) NOT NULL,


 Reservation_number INT NOT NULL,
 Tool_ID  INT NOT NULL,
 PRIMARY KEY (Reservation_number, Tool_ID),
 FOREIGN KEY (Reservation_number) REFERENCES RESERVATION(Reservation_number), 
FOREIGN KEY (Tool_ID) REFERENCES TOOL(Tool_ID)
 
 

commit;
