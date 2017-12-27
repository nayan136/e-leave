<?php
$email = "zurzaparzo@mihep.com";
$message = "Hello";
?>
<html>
<body>
<h1 style="color:green" > Lifelink </h1>
<p> You have successfully recovered your lifelink password. </p>
<p><u>Mail</u> :  <?php echo $email; ?> </p>
<!-- <p><u>Password</u> : $pass </p> -->
</body>
</html>
END_HTML;

<?php

$headers = "From: Lifelink < mail@lifelink.com > \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$recipient = $email;
$subject = "Lifelink Password Recovery";
mail( $recipient, $subject, $message, $headers );
die("Successful. Now open inbox of <b>".$email."</b> <a href='/'>Loginpage</a>");


 ?>
