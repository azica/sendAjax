<?php
// Файлы phpmailer
require 'class.phpmailer.php';
require 'class.smtp.php';

$name = $_POST['name'];
$email = $_POST['email'];

// Настройки
$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';
$mail->isSMTP(); 
$mail->Host = 'smtp.test.com';  
$mail->SMTPAuth = true;                      
$mail->Username = 'example@mail.com';
$mail->Password = 'password';
$mail->SMTPSecure = 'ssl';                            
$mail->Port = 465;
$mail->setFrom('example@mail.com'); 
$mail->addAddress('example@mail.com'); 

// Прикрепление файлов
  for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));
        $filename = $_FILES['userfile']['name'][$ct];
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
    }   
                                 
// Письмо
$mail->isHTML(true); 
$mail->Subject = "Заголовок"; // Заголовок письма
$mail->Body    = "Имя $name . Почта $email"; // Текст письма

// Результат
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'ok';
}
?>