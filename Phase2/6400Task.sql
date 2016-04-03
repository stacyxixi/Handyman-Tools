SELECT UserName, Fname, Lname
FROM CLERK
WHERE Username = $Login AND Password = $Password;

SELECT UserName, Fname, Lname
FROM CUSTOMER
WHERE Username = $Login AND Password = $Password;	

INSERT INTO
CUSTOMER (Login,  Password, Fname, Lname, Work_area_code, Work_local_number, Home_area_code, Home_local_number, Address)
VALUES ($Login,  $Password, $First_name, $Last_name, $Work_phone_area_code, $Work_phone_local_number, $Home_phone_area_code, $Home_phone_local_number, $Address);

SELECT Tool_ID, Abbrdesc, Rental
FROM TOOL
WHERE is_Sold = 'N' and 
Tool_Type = $Tool_Type and 
tool_ID not in 
(select tool.tool_id from tool, reserve, reservation
where reservation.start_date< CURDATE() and reservation.end_date>CURDATE() and 
reserve.reservation_number = reservation.reservation_number and tool.tool_id = reserve.tool_id) and 
tool_id not in 
(select tool_id from service_order
where start_date< CURDATE() and end_date>CURDATE());

SELECT Tool_ID, Abbrdesc, Rental
FROM TOOL
WHERE is_Sold = 'N' and 
Tool_Type = $Tool_Type and 
tool_ID not in 
(select tool.tool_id from tool, reserve, reservation
where reservation.start_date< CURDATE() and reservation.end_date>CURDATE() and 
reserve.reservation_number = reservation.reservation_number and tool.tool_id = reserve.tool_id) and 
tool_id not in 
(select tool_id from service_order
where start_date< CURDATE() and end_date>CURDATE());

select abbrdesc from tool
where tool_id in ($tool_ids);

select sum(rental*(5)), sum(deposit) from tool
where tool_id in (1,2);


SELECT R.reservation_number, R.start_date, R.end_date, T.abbrdesc 
from Reservation as R
inner join reserve on
R.reservation_number = reserve.reservation_number
inner join tool as T on
T.Tool_id = reserve.tool_ID
where R.reservation_number = 2222;

SELECT sum(T.rental*(R.end_date-R.start_date)), sum(T.deposit)
from Reservation as R
inner join reserve on
R.reservation_number = reserve.reservation_number
inner join tool as T on
T.Tool_id = reserve.tool_ID
where R.reservation_number = 2222;

SELECT R.reservation_number, T.abbrdesc, R.start_date, R.end_date, T.rental*(DATEDIFF(R.end_date,R.start_date)), T.deposit, R.Pickup_clerk, R.Dropoff_clerk
FROM Reservation as R
inner join reserve on
R.reservation_number = reserve.reservation_number
inner join tool as T on
T.Tool_id = reserve.tool_ID
where R.Request_customer = 'bxia33';

SELECT T.Tool_ID, T.Abbrdesc, T.Deposit, T.Rental
FROM Tool AS T 
INNER JOIN 

Reservation AS R ON T.Tool_ID = R.Tool_ID INNER JOIN Service_order AS S ON T.Tool_ID = S.Tool_ID
WHERE T.Type = $tool_type AND T.is_sold = False AND $start_date > R.End_date OR $end_date < R.Start_date and $start_date > S.End_date OR $end_date < S.Start_date

SELECT Tool_ID, Abbrdesc, Deposit, Rental
FROM TOOL
WHERE is_Sold = 'N' and 
tool_type = 'Construction Equipments' and 
tool_ID not in 
(select tool.tool_id from tool, reserve, reservation
where ((reservation.start_date< '20160306' and reservation.end_date>'20160306') or (reservation.start_date< '20160317' and reservation.end_date>'20160317')) and
reserve.reservation_number = reservation.reservation_number and tool.tool_id = reserve.tool_id) and 
tool_id not in 
(select tool_id from service_order
where 
(start_date< '20160306' and end_date>'20160306') or (start_date< '20160317' and end_date>'20160317'));


SELECT T.Tool_ID, T.AbbrDesc, T.FullDesc, T.Purchase_Price, T.Deposit, T.Rental, A.ACCESSORIES
From TOOL AS T 
LEFT JOIN ACCESSORIES AS A
ON T.Tool_ID = ACCESSORIES.Tool_ID;



SELECT R.Reservation_number, R.Pickup_clerk, R.Request_customer, 
R.Pickup_creditcard_number, R.start_date, R.End_date,
sum(T.rental*DATEDIFF(R.end_date,R.start_date)), sum(T.deposit),
sum(T.rental*DATEDIFF(R.end_date,R.start_date)) + sum(T.deposit)
from Reservation as R
inner join reserve on
R.reservation_number = reserve.reservation_number
inner join tool as T on
T.Tool_ID = reserve.Tool_ID
where R.reservation_number = 2222;

SELECT sum(T.rental*DATEDIFF(R.end_date,R.start_date)), sum(T.deposit)
from Reservation as R
inner join reserve on
R.reservation_number = reserve.reservation_number
inner join tool as T on
T.Tool_ID = reserve.Tool_ID
where R.reservation_number = 2222;

SELECT Tool_ID
FROM TOOL
WHERE is_Sold = 'N' AND
Tool_ID = 2 AND 
tool_ID NOT IN 
(SELECT tool.tool_id FROM tool, reserve, reservation
WHERE reservation.start_date< CURDATE() and reservation.end_date>CURDATE() and 
reserve.reservation_number = reservation.reservation_number and tool.tool_id = reserve.tool_id) AND
tool_id NOT IN 
(SELECT tool_id from service_order
WHERE start_date< CURDATE() and end_date>CURDATE());


SELECT R1.Request_customer, C.Fname, C.Lname, COUNT(R2.Tool_ID) AS num_tools
FROM Reservation AS R1 INNER JOIN Customer AS C ON R1.Request_customer = C.Username 
INNER JOIN Reserve AS R2 ON R1.Reservation_number = R2.Reservation_number
WHERE YEAR(R1.Start_date) = '2016'
GROUP BY R1.Request_customer
ORDER BY num_tools, C.Lname;



begin
IF 1=1

then
  select 'YOUR MESSAGE HERE'  
else
  select 'YOUR OTHER MESSAGE HERE'
end if;


