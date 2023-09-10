<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-01-17 13:36:45
 */
function sendMail($reveuser, $title, $message, $isHTML = true, $config)
{

    require(__DIR__ . '/PHPMailer/class.phpmailer.php');
    require(__DIR__ . '/PHPMailer/class.smtp.php');

    $mail = new PHPMailer();
    $mail->SMTPDebug = $config['debug'];
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->SMTPSecure = 'ssl';
    $mail->CharSet = 'UTF-8';
    $mail->Host = $config['host'];
    $mail->Port = $config['port'];

    $mail->Username = $config['username'];
    $mail->Password = $config['password'];
    $mail->From = $config['fromuser'];
    $mail->FromName = $config['fromname'];

    $mail->isHTML($isHTML);
    $reveuser = explode(',', $reveuser);
    foreach ($reveuser as $val) {
        $mail->addAddress($val);
    }
    $mail->Subject = $title;
    $mail->Body = $message;

    $code = $mail->send() ? 500 : 502;
    return $code;
    // printResult($code);
}
