<?php
$landing_page = 'contacts.html';

$from = htmlspecialchars($_POST["email"]);
$subject = 'Fedironics Mail From '.htmlspecialchars($_POST["name"]);
$message = 'Name : ' . htmlspecialchars($_POST["name"])."\r\n";
$message .= 'Phone No: ' . htmlspecialchars($_POST["phone"])."\r\n"."\r\n";
$message .= htmlspecialchars($_POST["message"]);

$to = 'machine@fedironics.com';
$headers = 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n".
    'X-Mailer: PHP/' . phpversion();


mail($to, $subject, $message, $headers);

if ($landing_page != ""){
//header("Location: http://".$_SERVER["HTTP_HOST"]."/$landing_page");
echo "Success, thanks for contacting us ";
} else {
header("Location: http://".$_SERVER["HTTP_HOST"]."/");
}

?>