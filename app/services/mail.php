<?php 

ob_start();
  //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';
 



class mail{
    private $mailTo;
    private $subject;
    private $body;

    public function __construct($mailTo, $subject, $body) {  //دا كونستراكتور علشان اجبره لو اخد اوبجت من الكلاس دا لازم يحطلي القيم دي وبعدين هيخزنهم في البروبيرتز وبعدها اقدر استخدمهم في الفانكشن الي اسمها سيند
        $this->mailTo = $mailTo;
        $this->subject = $subject;
        $this->body = $body;
    }
    public function send() {

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //دا للتجريب بس عشان يطلعلك اخطاء لو فيه
    $mail->isSMTP();                                            //دايميل هيبعت عن طريق بروتوكول اس ام تي بي
    $mail->Host       = 'smtp.gmail.com';                     //دايميل هيبعت عن طريق جيميل
    $mail->SMTPAuth   = true;                                   //دايميل هيبعت عن طريق بروتوكول اس ام تي بي
    $mail->Username   = 'training9745@gmail.com';                     //دايميل اللي هيبعت منه
    $mail->Password   = 'jaen mqwn gyvr dvqq';                               //دايميل اللي هيبعت منه
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //دايميل هيبعت عن طريق بروتوكول اس ام تي بي
    $mail->Port       = 465;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    //Recipients
    $mail->setFrom('training9745@gmail.com', 'smsmecomerce');  //اسم الاميل اللي هيبعت منه
    $mail->addAddress($this->mailTo);     //اسم الاميل اللي هيبعت له
  

  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $this->subject;
    $mail->Body    = $this->body;

    $mail->send();   //دي الفانكشن الي هتبعت الاميل
    return true;
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}

    }
}







ob_end_flush();

?>