<?php
$title = "Reset Password"; 
include_once 'layouts/header.php';
include_once 'app/middleware/guest.php'; //عشان مفيش يوزر مسجل دخول يقدر يدخل ع صفحه اللوجين
if(!isset($_SESSION['email'])){
    header("location:login.php");
    die;
}
include_once 'app/requests/validation.php';
include_once 'app/models/User.php';
if($_POST){
    // password validation
                $errors=[];
                $passwordValidation = new Validation('password',$_POST['password']);
                $passwordRequiredRuslt = $passwordValidation->required();
                if(empty($passwordRequiredRuslt)){
                        $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
                        $passwordRegexRuslt = $passwordValidation->regex($passwordPattern);
                        if(empty($passwordRegexRuslt)){
                         $passwordConfirmedRuslt = $passwordValidation->confirmed($_POST['password-confirmation']);
                         if(!empty($passwordConfirmedRuslt)){
                        $errors['password']['confirmed'] = $passwordConfirmedRuslt;

                         }
                        }else{ 
                        $errors['password']['regex'] = "Minimum eight and maximum 15 characters, at least one uppercase letter, one lowercase letter, one number and one special character.";
                        }
                }else{
                    $errors['password']['required'] = $passwordRequiredRuslt;
                }


                 $confirmPasswordValidation = new Validation('password-confirmation',$_POST['password-confirmation']);
                 $confirmPasswordRequiredRuslt = $confirmPasswordValidation->required();
                 if(!empty($confirmPasswordRequiredRuslt)){
                    $errors['confirm']['required'] = $confirmPasswordRequiredRuslt;
                 }
    if(empty($errors)){
        $userObject = new User;
        $userObject->setEmail($_SESSION['email']);
        $userObject->setPassword($_POST['password']);
        $result = $userObject->updatePasswordByEmail();
         if($result){
            unset($_SESSION['email']);
            header("Refresh:2;url=login.php");
            $success= "Password Reset Successfully";
         }else{
              $errors['confirm']['wrong'] = "someting went rong";
         }


    
        }

}

?>
        <div class="login-register-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="login-register-tab-list nav">
                                <a class="active" data-toggle="tab" href="#lg1">
                                    <h4> <?= $title ?> </h4>
                                </a>
                                
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <?php if(isset($success )){
                                                echo "<p class='alert alert-success'>".$success."</p>";
                                            } ?>
                                            <form   method="post">
                                              
                                                <input type="password" name="password" placeholder="Password">
                                                <?php if(!empty($errors['password'])){
                                                    foreach($errors['password'] as $key => $value) {
                                                        echo "<p class='alert alert-danger'>".$value."</p>";
                                                     }
                                                } ?>
                                                <input type="password" name="password-confirmation" placeholder="password-confirmation">
                                            <?php if(!empty($errors['confirm'])){
                                                    foreach($errors['confirm'] as $key => $value) {
                                                        echo "<p class='alert alert-danger'>".$value."</p>";
                                                     }
                                                } ?>
                                                <div class="button-box">
                                                 
                                                    <button type="submit" name="login"><span><?= $title ?></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <?php


?>