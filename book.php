<?php

include("booking_success.html");

// Require config file
require_once( 'config.php' );

// Send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

global $email_address, $password, $from, $fromName, $subject;

$mail = new PHPMailer(true);

//Enable SMTP debugging.
$mail->SMTPDebug = false;
//Set PHPMailer to use SMTP.
$mail->isSMTP();
//Set SMTP host name
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;

//Provide username and password
$mail->Username = $email_address;
$mail->Password = $password;

//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";
//Set TCP port to connect to
$mail->Port = 587;

$mail->From = $from;
$mail->FromName = $fromName;

//To address and name
$mail->addAddress($_POST['email'], $_POST['fname'] . " " . $_POST['lname']);

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = $subject;

$pharmacy = '';
if ($_POST['radioOptions3'] === 'Delivery within 24 hours') {
  $pharmacy = '<h3>Your full address:' . ' ' . $_POST['address'] . '</h3>';
} else {
  $pharmacy = '<h3>Preferred pharmacy:' . ' ' . $_POST['pharmacy'] . '</h3>
               <h3>Phone number:' . ' ' . $_POST['pharm-number'] . '</h3>
               <h3>Fax number:' . ' ' . $_POST['pharm-fax-number'] . '</h3>
               <h3>Full address:' . ' ' . $_POST['pharm-address'] . '</h3>';
}

$mail->Body = '<div style="background-color:#e0eaef; padding:50px 0px 50px 0px;">
      <div style="background-color:#282b5e; margin:0px 50px 0px 50px; font-family: Arial, Helvetica, sans-serif;">
        <div style="color:white; padding:25px 50px 25px 50px;">
          <h2>' . $_POST['fname'] . ' ' . $_POST['lname'] . ',</h2>
          <h2>Thank you for requesting an appointment with Dundurn Medical Centre. We will get back to you soon.</h2>
          <h2>Below is a summary of your submission.</h2>
          <br>

      		<h1>Appointment Request</h1>
          <br>

        	<div>
      			<div style="color:white;">
    					<h2>About you</h2>

        			<h3>I am a new patient:' . ' ' . $_POST['radioOptions1'] . '</h3>

        			<h3>Is the patient a child? (under 18):' . ' ' . $_POST['radioOptions2'] . '</h3>

      			  <h3>Phone number:' . ' ' . $_POST['phone'] . '</h3>

              <h3>Additional Information:</h3>
        			<h3>' . $_POST['you-add'] . '</h3>
              <br>

        			<h2>About your appointment</h2>

              <h3>Reason for visit:' . ' ' . $_POST['reason'] . '</h3>

              <h3>Additional Information:</h3>
      				<h3>' . $_POST['app-add'] . '</h3>
              <br>

        			<h2>Pharmacy details</h2>

              <h3>Where do you want your prescription:' . ' ' . $_POST['radioOptions3'] . '</h3>'
              . $pharmacy .
            '</div>
      		</div>
        </div>
    	</div>
    </div>';

$mail->send();

global $whitelist;

// Whitelist data
foreach ( $whitelist as $key ) {
  $fields[$key] = $_POST[$key];
}

?>
