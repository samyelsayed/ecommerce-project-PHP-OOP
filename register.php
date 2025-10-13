<?php
$title = "Register"; 
include_once 'layouts/header.php';
include_once 'app/middleware/guest.php'; //  وحطيتها تحت الهيدر لانه فيها السيشنعشان مفيش يوزر مسجل دخول يقدر يدخل ع صفحه الريجستر
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/requests/validation.php';
include_once 'app/models/User.php';
include_once 'app/services/mail.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
   // email validation
   $success = [];
$emailValidation = new Validation("email", $_POST['email']); 
$emailRequiredResult = $emailValidation->required();
$pattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
if(empty($emailRequiredResult)){
    $emailRegexResult = $emailValidation->regex($pattern);
    if(empty($emailRegexResult)){
        $emailUniqeResult = $emailValidation->unique('users');
        if(empty($emailUniqeResult)){
            $success['email'] = "email";
            }
    }
}

// phone validation
$phoneValidation = new Validation("phone", $_POST['phone']); 
$phoneRequiredResult = $phoneValidation->required();
$phonePattern = "/^01(0|1|2|5)[0-9]{8}$/";
if(empty($phoneRequiredResult)){
    $phoneRegexResult = $phoneValidation->regex($phonePattern);
    if(empty($phoneRegexResult)){
        $phoneUniqeResult = $phoneValidation->unique('users');
        if(empty($phoneUniqeResult)){
            $success['phone'] = "phone";
            }
    }
}

// password validation
$passwordValidation = new Validation("password", $_POST['password']); 
$passwordRequiredResult = $passwordValidation->required();
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
if(empty($passwordRequiredResult)){
    $passwordRegexResult = $passwordValidation->regex($passwordPattern);
    if(empty($passwordRegexResult)){
        $passwordConfirmationResult = $passwordValidation->confirmed($_POST['password_confirmation']);
         if(empty($passwordConfirmationResult)){
            $success['password'] = "password";
            }
    }
}

if (isset($success['password']) && isset($success['email']) && isset($success['phone'])) {

$userObject = new User();
$userObject->setFirstName($_POST['First_Name']);
$userObject->setLastName($_POST['Last_Name']);
$userObject->setEmail($_POST['email']);
$userObject->setPhone($_POST['phone']);
$userObject->setGender($_POST['gender']);
$userObject->setPassword($_POST['password']);
$code = rand(10000,99999);
$userObject->setCode($code);

$result =  $userObject->create();
if($result){

$subject = "Verfacation Code";
$body = "hello {$_POST['First_Name']} {$_POST['Last_Name']}  <br> Your Verfacation Code is : $code <br> thank you";
$mail = new mail($_POST['email'],$subject,$body);

$mailResult = $mail->send();
if($mailResult){
$_SESSION['email'] = $_POST['email'];
header("location:check-code.php?page=register");
}else{
    $error = "<div class='alert alert-danger'>Error Try Again</div>";
}





}else{
    $error = "<div class='alert alert-danger'>Error Try Again</div>";
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
                                
                                <a class="active" data-toggle="tab" href="#lg2">
                                    <h4> register </h4>
                                </a>
                            </div>
                          
                                <div id="lg2" class="tab-pane active" >
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <?php if(isset($error)){ echo $error; } ?>
                                            <form action=" " method="post">
                                                <input type="text" name="First_Name" placeholder="First Name" value="<?php if(isset($_POST['First_Name'])){echo $_POST['First_Name']; } ?>">
                                                <input type="text" name="Last_Name" placeholder="Last Name" value="<?php if(isset($_POST['Last_Name'])){echo $_POST['Last_Name']; } ?>">
                                                <input name="email" placeholder="Email" type="email" value="<?php if(isset($_POST['email'])){echo $_POST['email']; } ?>">
                                                <?=  empty( $emailRequiredResult) ? "" : "<div class ='alert alert-danger'> $emailRequiredResult</div>"  ?>
                                                <?=  empty($emailRegexResult) ? "" : "<div class ='alert alert-danger'>$emailRegexResult</div>"  ?>
                                                <?=  empty($emailUniqeResult) ? "" : "<div class ='alert alert-danger'>$emailUniqeResult</div>"  ?>

                                                <input name="phone" placeholder="phone" type="number" value="<?php if(isset($_POST['phone'])){echo $_POST['phone']; } ?>">
                                                <?=  empty( $phoneRequiredResult) ? "" : "<div class ='alert alert-danger'> $phoneRequiredResult</div>"  ?>
                                                <?=  empty($phoneRegexResult) ? "" : "<div class ='alert alert-danger'>$phoneRegexResult</div>"  ?>
                                                <?=  empty($phoneUniqeResult) ? "" : "<div class ='alert alert-danger'>$phoneUniqeResult</div>"  ?>                                                
                                                <input type="password" name="password" placeholder="Password">
                                                <?=  empty( $passwordRequiredResult) ? "" : "<div class ='alert alert-danger'> $passwordRequiredResult</div>"  ?>
                                                <?=  empty( $passwordRegexResult) ? "" : "<div class ='alert alert-danger'> Minimum eight and maximum 15 characters, at least one uppercase letter, one lowercase letter, one number and one special character.</div>"  ?>
                                                <input type="password" name="password_confirmation" placeholder="confirm Password">
                                                <?=  empty( $passwordConfirmationResult) ? "" : "<div class ='alert alert-danger'> $passwordConfirmationResult</div>"  ?>

                                                <select name="gender" id="" class="form_control">
                                                    <option  <?= (isset($_POST['gender']) && ($_POST['gender']) == 'm') ? 'selected' : '' ?>  value="m">Male</option>
                                                    <option  <?php if(isset($_POST['gender']) && ($_POST['gender']) == 'f'){echo 'selected';} ?> value="f">Female</option>
                                                </select>
                                                <div class="button-box mt-5">
                                                    <button type="submit"><span>Register</span></button>
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
include_once 'layouts/footer.php';
include_once 'layouts/footer-scripts.php';
?>