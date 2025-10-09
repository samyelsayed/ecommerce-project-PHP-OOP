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
       $emailRegexRuslt = $emailValidation->regex($emailPattern);
       if(!empty($emailRegexRuslt)){
       $_SESSION['errors']['email']['regex'] = $emailRegexRuslt;
       }
    }else{
    $_SESSION['errors']['email']['required'] = $emailRequiredRuslt;
}
//هبدا اخد اوبجت من  الكلاس بتاع الفلديشن واسميه باسورد فالديشن واديلو النيم و الفاليو
//2 هاستخدم من الاوبجت الميود بتاع الاميل ريكويريد و خزنه في باسورد ريكويرد ريزلت
// كذالك هاستخدم الميود بتاع الريجكس و خزنه في باسورد ريجيكس ريزلت واديها الباترن


$passwordValidation = new Validation('password',$_POST['password']);
$passwordRequiredRuslt = $passwordValidation->required();
if(empty($passwordRequiredRuslt)){
         $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
         $passwordRegexRuslt = $passwordValidation->regex($passwordPattern);
        if(!empty($passwordRegexRuslt)){
        $_SESSION['errors']['password']['regex'] = $passwordRegexRuslt;
        }
}else{
    $_SESSION['errors']['password']['required'] = $passwordRequiredRuslt;
}
//بإذن الله هكمل من اول ما خزنهم في متغيرات وخزن الايرور فقط في السيشن الايرور فقط مش كله


//هعمل كونديشن هل السيشن جواه اي ايرور من ايرور الفالديشن ولا لا
if(empty($_SESSION['errors'])){
$userObject = new User();
$userObject->setemail($_POST['email']);
$userObject->setPassword($_POST['password']);
$result = $userObject->login();
if($result){
    $user=$result->fetch_object();
    if($user->status == 1){
                 

                  //هعمل كونديشن للشخص الي اختار ريمببر مي هوا الي هخزن بياناته في الكوكي
                  if(isset($_POST['remember_me'])){
                  setcookie('remember_me',$_POST['email'],time()+(60*60*24) * 30 * 12 ,'/');            
                  }
                 $_SESSION['user'] = $user;
                 header("location:../../index.php");die;
    }elseif($user->status == 0){
            $_SESSION['email'] = $_POST['email'];
                 header("location:../../check-code.php");die;
    }else{
                $_SESSION['errors']['password']['block'] = "your account is blocked";

    }
    
    
    
}else{
        $_SESSION['errors']['password']['wrong'] = "Invalid Email or Password";
    }
}

    header("location:../../login.php");
//بعدين هاخد اوبجكت من كلاس اليوزر  وبعدين ابدااعطيله ال اميل و الباسورد
//بعدين اعمل كويريري علشان يبحث عن الاميل و الباسود دول هل هما جوا الداتا بيز ولا لا
//واخزن ناتج الكويري في ريزلت ولو موجودة خزنه بياناته في سيشن اليوزر
?>