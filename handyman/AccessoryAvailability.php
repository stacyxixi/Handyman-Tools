<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */







if (!$rowy) {

	$emptyMsg = "No transactions found.";

}
$URLS = array();
while ($rowy)
{
  $URLS[] = array('R.reservation_number' => $rowy['R.reservation_number'], 'R.start_date' => $rowy['R.start_date'], 'R.end_date' => $rowy['R.end_date'], 'Rental_price'=> $rowy['Rental_price'], 'T.deposit'=> $rowy['T.deposit'], 'R.Pickup_clerk'=> $rowy['R.Pickup_clerk'], 'R.Dropoff_clerk'=> $rowy['R.Dropoff_clerk'] );
}