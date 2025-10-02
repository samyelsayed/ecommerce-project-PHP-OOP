<?php 

include_once 'app/requests/validation.php';
//هعمل كونديشن هل هوا جاي من كي اسمه لوجين
if(!isset($_POST['login'])){
    header('location:../../layouts/errors/404.php');
    die;

}


//هبدا اخد اوبجت من  الكلاس بتاع الفلديشن واسميه اميل فالديشن واديلو النيم و الفاليو
//2 هاستخدم من الاوبجت الميود بتاع الاميل ريكويريست و خزنه في رايميل ريكويرد ريزلت
// كذالك هاستخدم الميود بتاع الريجكس و خزنه في رايميل ريجيكس ريزلت واديها الباترن  

$emailValidation = new Validation("email",$_POST['email']);
$emailRequiredReuslt = $emailValidation->required();
if(!empty($emailRequiredReuslt)){
$emailPattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
$emailRegexReuslt = $emailValidation->regex($emailPattern);
}
//هبدا اخد اوبجت من  الكلاس بتاع الفلديشن واسميه باسورد فالديشن واديلو النيم و الفاليو
//2 هاستخدم من الاوبجت الميود بتاع الاميل ريكويريد و خزنه في باسورد ريكويرد ريزلت
// كذالك هاستخدم الميود بتاع الريجكس و خزنه في باسورد ريجيكس ريزلت واديها الباترن


$passwordValidation = new Validation("password",$this->password);
$passwordRequiredReuslt = $passwordValidation->required();
if(!empty($passwordRequiredReuslt)){
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
$passwordRegexReuslt = $passwordValidation->regex($passwordPattern);
}
//بإذن الله هكمل من اول ما خزنهم في متغيرات وخزن الايرور فقط في السيشن الايرور فقط مش كله



?>