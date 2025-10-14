
<?php
$title = "my account"; 
include_once 'layouts/header.php';
include_once 'app/middleware/auth.php'; // وحطيتها تحت الهيدر لانه فيها السيشن عشان الي لسا مسجلش دخول ميدخلش ع صفحه البروفايل
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/models/User.php';


   $userObject = new User;
   $userObject->setEmail($_SESSION['user']->email);

$errors = [];
if(isset($_POST['update-profile'])){
    print_r($_FILES);die;


    //فيما بعد ابقا اعمل فالديشن  للبيانات الي اليوزر يحب يعدلها قبل ما اخزنها في الداتا بيز
    $errors = [];
    if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['phone']) || empty($_POST['gender']) ){
      $errors['all'] = "<div class='alert alert-danger'>All fields are required</div>";
     }
    
         $userObject->setFirstName($_POST['first_name']);
         $userObject->setLastName($_POST['last_name']);
         $userObject->setPhone($_POST['phone']);
         $userObject->setPhone($_POST['gender']);
        if($_FILES['imge']['error'] == 0){
            //يبقا بعت صورة
        }            
       $result = $userObject->update();
       if($result){
        $success = "<div class='alert alert-success'>Profile updated successfully</div>";
       }else{
        $errors['db'] = "<div class='alert alert-danger'>Something went wrong, please try again</div>";}
}


   $result = $userObject->getUserByEmail();
   $user = $result->fetch_object();
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
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Password</label>
                                                            <input type="password">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Password Confirm</label>
                                                            <input type="password">
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