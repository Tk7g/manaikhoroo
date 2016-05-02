<?php
/**
 * This example shows sending a message using a local sendmail binary.
 */

require_once(realpath(dirname(__FILE__))."/config/mailer/PHPMailerAutoload.php");

//Create a new PHPMailer instance
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'mail.manaikhoroo.ub.gov.mn';
$mail->SMTPAuth = true;
$mail->Username = 'contact@manaikhoroo.ub.gov.mn';
$mail->Password = 'Pass2015';
$mail->SMTPSecure = 'tls';   
$mail->Port = 25;

//Set who the message is to be sent from
$mail->setFrom('contact@manaikhoroo.ub.gov.mn');
//Set an alternative reply-to address
$mail->addReplyTo('contact@manaikhoroo.ub.gov.mn');
//Set who the message is to be sent to
$mail->addAddress('zandaa_m@yahoo.com');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);    
$mail->Body = "Та манай <a href='http://manaikhoroo.ub.gov.mn'>manaikhoroo.ub.gov.mn</a> системд амжилттай бүртгүүллээ.<br/>Таны хэрэглэгчийн нэр: <br/>Таны нууц үг: ";

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
