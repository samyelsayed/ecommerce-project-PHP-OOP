<?php  $title = "Forget Password"; 
include_once 'layouts/header.php';
include_once 'app/models/User.php';
include_once 'app/requests/validation.php';
include_once 'app/middleware/guest.php'; //عشان مفيش يوزر مسجل دخول يقدر يدخل ع صفحه اللوجين
include_once 'app/services/mail.php';


if($_POST){
   $emailValidation = new Validation("email",$_POST['email']);
   $emailRequiredReusult = $emailValidation->required();
   $errors = [];
   if(empty($emailRequiredReusult)){
       $pattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
       $emailRegexResult = $emailValidation->regex($pattern);
       if(!empty($emailRegexResult)){
        $errors['email-regex'] = $emailRegexResult;
        }
   }else{
    $errors['email-required'] = $emailRequiredReusult;
        } 
    


   if(empty($errors)){
        $userObject = new User;
        $userObject->setEmail($_POST['email']);
        $result = $userObject->getUserByEmail();
      
        if($result){
            $user = $result->fetch_object();
              //print_r($user);die;
        // send email to user with code to reset password
            $code = rand(10000,99999);
            $userObject->setCode($code);
            $updateResult =$userObject->updateCodeByEmail();
             if($updateResult){

                $subject = "Forget Password Code";
                $body = "hello {$user->first_name} {$user->last_name}  <br> Your Forget Password Code is : $code <br> thank you";
                $mail = new mail($_POST['email'],$subject,$body);

                $mailResult = $mail->send();
                    if($mailResult){
                    $_SESSION['email'] = $_POST['email'];
                    header("location:check-code.php?page=forget");
                    }else{
                        $errors['try-again'] = "Error Try Again";
                    }

             }else{
                      $errors['some-wrong'] = "something went wrong";   
             }

        }else{
            $errors['email-wrong'] = "the email is not registered";    

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
                                    <h4>   <?= $title; ?> </h4>
                                </a>
                             </a>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="#" method="post">
                                                <input type="email"  name="email" placeholder="Enter Your Email Address">
                                                <?php 
                                                if(!empty($errors)){
                                                    foreach($errors as $key => $value){
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                    }
                                                }
                                                ?>
                                                <div class="button-box">                        
                                                    <button type="submit"><span>Verfiy Email Address </span></button>
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
include_once 'layouts/footer-scripts.php';
?>