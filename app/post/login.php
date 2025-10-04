<?php 
session_start();
include_once '../requests/validation.php';
include_once '../models/user.php';
//هعمل كونديشن هل هوا جاي من كي اسمه لوجين
if(!isset($_POST['login'])){
    header('location:../../layouts/errors/404.php');
    die;

}


//هبدا اخد اوبجت من  الكلاس بتاع الفلديشن واسميه اميل فالديشن واديلو النيم و الفاليو
//2 هاستخدم من الاوبجت الميود بتاع الاميل ريكويريست و خزنه في رايميل ريكويرد ريزلت
// كذالك هاستخدم الميود بتاع الريجكس و خزنه في رايميل ريجيكس ريزلت واديها الباترن  

$emailValidation = new Validation('email',$_POST['email']);
$emailRequiredRuslt = $emailValidation->required();
if(empty($emailRequiredRuslt)){
$emailPattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
$_SESSION['errors']['email']['regex'] = $emailValidation->regex($emailPattern);
}else{
    $_SESSION['errors']['email']['required'] = $emailRequiredRuslt
}
//هبدا اخد اوبجت من  الكلاس بتاع الفلديشن واسميه باسورد فالديشن واديلو النيم و الفاليو
//2 هاستخدم من الاوبجت الميود بتاع الاميل ريكويريد و خزنه في باسورد ريكويرد ريزلت
// كذالك هاستخدم الميود بتاع الريجكس و خزنه في باسورد ريجيكس ريزلت واديها الباترن


$passwordValidation = new Validation('password',$_POST['password']);
$_SESSION['errors']['password']['required'] = $passwordValidation->required();
if(empty($_SESSION['errors']['password']['required'])){
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
$_SESSION['errors']['password']['regex'] = $passwordValidation->regex($passwordPattern);
}
//بإذن الله هكمل من اول ما خزنهم في متغيرات وخزن الايرور فقط في السيشن الايرور فقط مش كله


//هعمل كونديشن هل السيشن جواه اي ايرور من ايرور الفالديشن ولا لا
if((isset($_SESSION['email_required']) && $_SESSION['email_required'] == '' )&&
   (isset($_SESSION['email_regex']) && $_SESSION['email_regex'] == '' )&&
    (isset($_SESSION['password_required']) && $_SESSION['password_required'] == '' )&&
    (isset($_SESSION['password_regex']) && $_SESSION['password_regex'] == '' )){
$userObject = new User();
$userObject->setemail($_POST['email']);
$userObject->setPassword($_POST['password']);
$result = $userObject->login();
if($result){
    print_r($result);die;

    }else{
        $_SESSION['login_error'] = "Invalid Email or Password";
    }

}
    header("location:../../login.php");
//بعدين هاخد اوبجكت من كلاس اليوزر  وبعدين ابدااعطيله ال اميل و الباسورد
//بعدين اعمل كويريري علشان يبحث عن الاميل و الباسود دول هل هما جوا الداتا بيز ولا لا
//واخزن ناتج الكويري في ريزلت ولو موجودة خزنه بياناته في سيشن اليوزر
?>