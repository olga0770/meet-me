<?php



/*$message = mail('olyalo0201@gmail.com','Testing','Test Mail from localhost using PHP');
echo '—'.$message.'—';
if ( $message ) {
    echo 'The email has been sent!';
} else {
    echo 'The email has failed!';
}*/


$sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);

$to      = 'olyalo0201@gmail.com';
$subject = 'MeetMe Activation Key';
$message = 'Your Activation Key is: '.$sActivationKey;
$email = mail($to, $subject, $message);

echo '—'.$email.'—';
if ( $email ) {
    echo 'The email has been sent!';
} else {
    echo 'The email has failed!';
}



