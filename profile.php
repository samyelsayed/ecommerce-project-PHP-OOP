
<?php
$title = "my account"; 
include_once 'layouts/header.php';
include_once 'app/middleware/auth.php'; // وحطيتها تحت الهيدر لانه فيها السيشن عشان الي لسا مسجلش دخول ميدخلش ع صفحه البروفايل
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/models/User.php';
include_once 'app/requests/Validation.php';
 $errors = [];
  $error = [];
   $userObject = new User;
   $userObject->setEmail($_SESSION['user']->email);

$errors = [];
if(isset($_POST['update-profile'])){


    //فيما بعد ابقا اعمل فالديشن  للبيانات الي اليوزر يحب يعدلها قبل ما اخزنها في الداتا بيز
    
    if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['phone']) || empty($_POST['gender']) ){
      $errors['all'] = "<div class='alert alert-danger'>All fields are required</div>";
     }
    
         $userObject->setFirstName($_POST['first_name']);
         $userObject->setLastName($_POST['last_name']);
         $userObject->setPhone($_POST['phone']);
         $userObject->setGender($_POST['gender']);
        if($_FILES['image']['error'] == 0){
            //يبقا بعت صورة
            //هبدا اهط فالديشن قبل ما اخزن الصورة 
            //ال حجم بتاع الصورة او مساحتها اقصي حاجة واحد بايت يعني 10 اوس 6
            $maxUploadSize = 10**6;
            $megaBits = $maxUploadSize / (10**6); // 1MB
            if($_FILES['image']['size'] >$maxUploadSize) {
                $errors['image-size'] = "<div class='alert alert-danger'>Image size must be less than $megaBits byts
                </div>";
            }
            //ال اكستينشن بتاعتها لازم يكون من ضمن اكستنشنات معينة زي بي ان جي او جي بي جي
            //في فانشكن في ال بي اتش بي اسمها باص انفو بتديها الصورة او الفايل تقولك علي الاكستنشن بتاعها
            $extention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            if(!in_array($extention, $allowedExtensions)){
            $errors['image-extention'] = "<div class='alert alert-danger'>Allowed image extension are: ". implode(', ', $allowedExtensions)."
                </div>";
            }
                    //لو مفيش ايرور في الفالديشن بتاع الصورة احفظها في فولدر عندي في المشروع وبحفظ الصوره في استورج البرنامج 
                   // علشان اقدر اعرضها بعد كدا لكن لو في الداتا بيز هتبقا الكويري تقيله جدا
            if(empty($errors)){
                $photoName = uniqid() . '.' . $extention;    //دي ميثود بتولد اسم عشوائي للصورة عشان ميتكررش مع صور تانية
                $photoPath = 'assets/img/users/' . $photoName; //المسار الي هتتحفظ فيه الصورة
                move_uploaded_file($_FILES['image']['tmp_name'], $photoPath); //دي فانكشن بتاخد الصورة الي اتحملت في المكان المؤقت وبتحطها في المسار الي انا عايزه    
                $userObject->setImage($photoName);
                $_SESSION['user']->image = $photoName;
            }
        }             //خزنت الاسم مش الباص علشان زي ما اناعامل في الداتا بيز مخزن الاسم فقط بتاع الصوره الديفولت
        if(empty($errors)){
        $result = $userObject->update();
        $_SESSION['user']->first_name = $_POST['first_name'];
        $_SESSION['user']->last_name = $_POST['last_name'];
        $_SESSION['user']->phone = $_POST['phone'];
        $_SESSION['user']->gender = $_POST['gender'];
            if($result){
                $success = "<div class='alert alert-success'>Profile updated successfully</div>";
            }else{
                $errors['db'] = "<div class='alert alert-danger'>Something went wrong, please try again</div>";}
        }
      
}

if(isset($_POST['update-password'])){
  
    //old-password => required , regex , correct=data base هعمله سلكت من الداتا بيز
    $passwordValidation = new Validation('old-password',$_POST['old-password']);
    $passwordValidationRequired = $passwordValidation->required();
    if(empty($passwordValidationRequired)){
        $Pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
        $passwordValidationRegex = $passwordValidation->regex($Pattern);
        if(!empty($passwordValidationRegex)){
            $error['old-password']['regex'] = "<div class ='alert alert-danger'> Old Password Is Not Correct.</div>" ;
        }else{
            $userObject->setPassword($_POST['old-password']);
            $result = $userObject->verifyOldPassword();
            if(!$result){
                $error['old-password']['correct'] = "<div class ='alert alert-danger'> Old password is incorrect</div>" ;
            }
        }

    }else{
         $error['old-password']['required']= "<div class='alert alert-danger'>The old password field is required</div>";
    }
    //new-password => required , regex
    $newPasswordValidation = new Validation('new-password',$_POST['new-password']);
    $newPasswordValidationRequired = $newPasswordValidation->required();
    if(empty($newPasswordValidationRequired)){
        $Pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
        $newPasswordValidationRegex = $newPasswordValidation->regex($Pattern);
        if(empty($newPasswordValidationRegex)){
          $newPasswordValidationcofirmed = $newPasswordValidation->confirmed($_POST['password-confirm']);
          if(!empty($newPasswordValidationcofirmed)){
            $error['new-password']['confirmed']= "<div class='alert alert-danger'>The new password no smetya with password confirm </div>";
          }
        }else{
          $error['new-password']['regex'] = "<div class ='alert alert-danger'> Minimum eight and maximum 15 characters, at least one uppercase letter, one lowercase letter, one number and one special character.</div>" ;

        }
    }else{
         $error['new-password']['required']= "<div class='alert alert-danger'>The new password field is required</div>";
    }

    //password-confirm => required , match new-password
    $newPasswordConfermValidation = new Validation ('password-confirm',$_POST['password-confirm']);
    $newPasswordConfermValidationRequired = $newPasswordConfermValidation->required();
    if(!empty($newPasswordConfermValidationRequired)){
            $error['password-confirm']['required']= "<div class='alert alert-danger'>The new password confirm field is required</div>";

    }
    //if no validation errors
    if(empty($error)){
            $userObject->setPassword($_POST['new-password']);
            $result = $userObject->updatePasswordByEmail();
            
            if($result){
                //print succsess massage
                $successed = "<div class='alert alert-success'>password updated successfully </div>";
            }else{
                //print error massage واعرضهم في الفورم الخاصة بالباسورد تحت
                $error['db'] = "<div class='alert alert-danger'>Something went wrong, please try again</div>";
            }

    }
   
}

   $result = $userObject->getUserByEmail();
   $user = $result->fetch_object();
   include_once 'layouts/nav.php';
   include_once 'layouts/breadcrumb.php';
    //  print_r($user);

?>







        <!-- my account start -->
        <div class="checkout-area pb-80 pt-100">
            <div class="container">
                <div class="row">
                    <div class="ml-auto mr-auto col-lg-9">
                        <div class="checkout-wrapper">
                            <div id="faq" class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                                    </div>
                                    <div id="my-account-1" class="panel-collapse collapse show">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>My Account Information</h4>
                                                    <h5>Your Personal Details</h5>
                                                   <h5 class="text-center"  >     <?php 
                                                        if(!empty($errors)){
                                                           foreach($errors as $key => $value){
                                                            echo $value;
                                                           }
                                                        }
                                                        if(isset($success)){
                                                            echo $success;
                                                        }
                                                        ?></h5>
                                                   
                                                </div>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3 offset-4">
                                                                <img src="assets/img/users/<?= $user->image ?>" id="image" alt="" class="w-100 rounded-circle" style="cursor: pointer;">
                                                                <input type="file" name="image" id="file"  class="d-none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 mt-5">
                                                        <div class="billing-info">
                                                            <label>First Name</label>
                                                            <input type="text" name="first_name" value="<?= $user->first_name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 mt-5">
                                                        <div class="billing-info">
                                                            <label>Last Name</label>
                                                            <input type="text" name="last_name" value="<?= $user->last_name ?>">
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>phone</label>
                                                            <input type="text" name="phone" value="<?= $user->phone ?>">
                                                        </div>
                                                    </div>
                                                   <div class="col-lg-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="Gender">Gender</label>
                                                            <select name="gender" id="gender" class="form-control">
                                                            <option value="">Select Gender</option>
                                                            <option value="m" <?= $user->gender == 'm' ? 'selected' : '' ?>>Male</option>
                                                            <option value="f" <?php if( $user->gender == 'f'){ echo 'selected';
                                                            } ?> >Female</option>
                                                            </select>
                                                        </div>
                                                   </div>

                                                </div> 
                                                    <div class="billing-btn">
                                                        <button type="submit" name="update-profile">Update</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                                    </div>
                                    <div id="my-account-2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>Change Password</h4>
                                                    <h5>Your Password</h5>
                                                </div>
                                               

                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Old Password</label>
                                                            <input type="password" name="old-password">
                                                        </div>
                                                    </div>
                                                    <?php if(isset($_POST['update-password']) && isset($error['old-password']) && !empty($error['old-password'])){
                                                        foreach($error['old-password'] as $key => $value){
                                                            echo $value;
                                                        }
                                                    } ?>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>New Password</label>
                                                            <input type="password" name="new-password">
                                                        </div>
                                                    </div>
                                                    <?php if(!empty($error['new-password'])){
                                                        foreach($error['new-password'] as $key => $value){
                                                            echo $value;
                                                        }
                                                    } ?>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Password Confirm</label>
                                                            <input type="password" name="password-confirm">
                                                        </div>
                                                    </div>
                                                    <?php if(!empty($error['password-confirm'])){
                                                        foreach($error['password-confirm'] as $key => $value){
                                                            echo $value;
                                                        }
                                                    } ?>
                                                </div>
                                                <div class="billing-back-btn">
                                                   
                                                    <div class="billing-btn">
                                                        <button type="submit" name="update-password" >Update Password </button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries   </a></h5>
                                    </div>
                                    <div id="my-account-3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>Address Book Entries</h4>
                                                </div>
                                                <div class="entries-wrapper">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                            <div class="entries-info text-center">
                                                                <p>Farhana hayder (shuvo) </p>
                                                                <p>hastech </p>
                                                                <p> Road#1 , Block#c </p>
                                                                <p> Rampura. </p>
                                                                <p>Dhaka </p>
                                                                <p>Bangladesh </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                            <div class="entries-edit-delete text-center">
                                                                <a class="edit" href="#">Edit</a>
                                                                <a href="#">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit">Continue</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>4</span> <a href="wishlist.html">Modify your wish list   </a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- my account end -->
         

<?php
include_once 'layouts/footer.php';
include_once 'layouts/footer-scripts.php';
?>

<script>
$("#image").click(function(){
    $("#file").click();
});

</script>