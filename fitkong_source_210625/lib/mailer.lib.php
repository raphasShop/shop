<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_PHPMAILER_PATH.'/PHPMailerAutoload.php');

// 메일 보내기 (파일 여러개 첨부 가능)
// type : text=0, html=1, text+html=2
function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="")
{
    global $config;
    global $g5;

    // 메일발송 사용을 하지 않는다면
    if (!$config['cf_email_use']) return;

    if ($type != 1)
        $content = nl2br($content);

    $mail = new PHPMailer(); // defaults to using php "mail()"
    if (defined('G5_SMTP') && G5_SMTP) {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "help.acropass@gmail.com"; //사용할 지메일 계정
        $mail->Password = "gjqm0410!@"; //구글계정 패스워드
    }
    $mail->CharSet = 'UTF-8';
    $mail->From = "help.acropass@gmail.com"; //발송메일(=사용할 지메일 계정)
    $mail->FromName = $fname;
    $mail->Subject = $subject;
    $mail->AltBody = ""; // optional, comment out and test
    $mail->msgHTML($content);
    $mail->addAddress($to);
    return $mail->send();
}

// 파일을 첨부함
function attach_file($filename, $tmp_name)
{
    // 서버에 업로드 되는 파일은 확장자를 주지 않는다. (보안 취약점)
    $dest_file = G5_DATA_PATH.'/tmp/'.str_replace('/', '_', $tmp_name);
    move_uploaded_file($tmp_name, $dest_file);
    $tmpfile = array("name" => $filename, "path" => $dest_file);
    return $tmpfile;
}
?>