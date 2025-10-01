<?php  $title = "check code"; 
include_once 'layouts/header.php';
include_once 'app/models/User.php';

if($_POST){
    $error = [];
    if(empty($_POST['code'])){
        $error['Required'] = "<div class='alert alert-danger'>Code Field Required</div>";
      }else{
          if(strlen($_POST['code']) != 5){
        $error['Digits '] = "<div class='alert alert-danger'>Code Must Be 5 Digits</div>";
                                         }
           }
    if(empty($error)){
        $userObject = new User();
        $userObject->setEmail($_SESSION['email']);
        $userObject->setCode($_POST['code']);
        $result = $userObject->checkcode();
        if($result){
            $userObject->setStatus(1);
            date_default_timezone_set("Africa/Cairo");
            $userObject->setEmailVerifiedAt(date("Y-m-d h:i:s"));
            $updateResult = $userObject->verfiedUser();
              if($updateResult){
                header("location:login.php");
        }else{
           $error['someting'] = "<div class='alert alert-danger'>someting went rong</div>";
        }
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
                                                <input type="number" min="10000" max="99999" name="code" placeholder="Enter Your Verfacation Code">
                                                <?php 
                                                if(!empty($error)){
                                                    foreach($error as $key => $value){
                                                        echo $value;
                                                    }
                                                }
                                                ?>
                                                <div class="button-box">                        
                                                    <button type="submit"><span> <?= $title; ?> </span></button>
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