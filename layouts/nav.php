<?php
//اعمل انكلود ل موديل الكاتجوري
include_once 'app/models/Category.php';
include_once 'app/models/Subcategory.php';
$objectCategory = new Category ();//اخد اوبجكت منه
$objectCategory->setStatus(1);
$categoryResult = $objectCategory->read(); 

$objectSubcategory = new Subcategory ();//اخد اوبجكت منه
$objectSubcategory->setStatus(1);



?>











<header class="header-area gray-bg clearfix">
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <a href="index.php">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-6">
                    <div class="header-bottom-right">
                        <div class="main-menu">
                            <nav>
                               <ul>
    <li><a href="index.php">Home</a></li>

    <li><a href="shop.php">Shop</a></li>

    <li class="mega-menu-position top-hover">
        <a href="#">Categories</a>
        <ul class="mega-menu">
            <!-- //get all categories from database and loop here -->
             <?php if($categoryResult){
               $categories = $categoryResult->fetch_all(MYSQLI_ASSOC);
               foreach($categories as $key => $category){ 

             ?> 
            <li>
                <ul>
                    <li class="mega-menu-title"><?= $category['name_en'] ?></li>
                    <?php 
                            //لازم علشان اعرض الصب كاتجوري اكتب الكويري هنا لان الكويري
                            //  دا لية انبوت وهوا ال هي دي بتاع الكاتجوري ودا موجود معايا وبيتغير جو اللوب هنا
                            //وكل للفه هديله كاتجوري اي دي جديد هيقوم الكويري متغير ويرجع اوت بوت لصب كويري مختلف
                            $objectSubcategory->setCategory_id($category['id']);
                            $subCategoryResult = $objectSubcategory->getSubsByCatId();
                            if($subCategoryResult){
                                $subCategories = $subCategoryResult->fetch_all(MYSQLI_ASSOC);
                                foreach($subCategories as $key => $subCategory){ 
                                    ?>
                                     <li><a href="shop.php?sub=<?= $subCategory['id'] ?>"><?= $subCategory['name_en'] ?></a></li>
                                    <?php

                                }
                          }
                    ?>


                </ul>
            </li>
             <?php 
                    }
                }
             ?>


        </ul>
    </li>

    <li><a href="contact.php">Contact</a></li>
    <li><a href="about-us.php">About</a></li>
</ul>

                            </nav>
                        </div>
                        <div class="header-currency">
                           <?php
                           if(isset($_SESSION['user'])){  ?> <span class="digit"><?php echo $_SESSION['user']->first_name. ' '. $_SESSION['user']->last_name; ?> <i class="ti-angle-down"></i></span>
                            <div class="dollar-submenu">
                                <ul>
                                    <li><a href="profile.php">profile</a></li>
                                    <li><a href="app/post/logout.php">Logout</a></li>
                                </ul>
                            </div> <?php } else{ ?> <span class="digit">WELCOME <i class="ti-angle-down"></i></span>
                            <div class="dollar-submenu">
                                <ul>
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                </ul>
                            </div> <?php } ?>
                        </div>
                        <div class="header-cart">
                            <a href="#">
                                <div class="cart-icon">
                                    <i class="ti-shopping-cart"></i>
                                </div>
                            </a>
                            <div class="shopping-cart-content">
                                <ul>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-1.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">Phantom Remote</a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="ion ion-close"></i></a>
                                        </div>
                                    </li>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-2.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">Phantom Remote</a></h4>
                                            <h6>Qty: 02</h6>
                                            <span>$260.00</span>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="ion ion-close"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-total">
                                    <h4>Shipping : <span>$20.00</span></h4>
                                    <h4>Total : <span class="shop-total">$260.00</span></h4>
                                </div>
                                <div class="shopping-cart-btn">
                                    <a href="cart-page.php">view cart</a>
                                    <a href="checkout.php">checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="#">HOME</a>
                            </li>
                            <li><a href="#">pages</a>
                                <ul>
                                    <li><a href="about-us.php">about us</a></li>
                                    <li><a href="shop.php">shop Grid</a></li>
                                    <li><a href="shop-list.php">shop list</a></li>
                                    <li><a href="product-details.php">product details</a></li>
                                    <li><a href="cart-page.php">cart page</a></li>
                                    <li><a href="checkout.php">checkout</a></li>
                                    <li><a href="wishlist.php">wishlist</a></li>
                                    <li><a href="my-account.php">my account</a></li>
                                    <li><a href="login-register.php">login / register</a></li>
                                    <li><a href="contact.php">contact</a></li>
                                </ul>
                            </li>
                            <li><a href="#"> Shop </a>
                                <ul>
                                    <li><a href="#">Categories 01</a>
                                        <ul>
                                            <li><a href="shop.php">Aconite</a></li>
                                            <li><a href="shop.php">Ageratum</a></li>
                                            <li><a href="shop.php">Allium</a></li>
                                            <li><a href="shop.php">Anemone</a></li>
                                            <li><a href="shop.php">Angelica</a></li>
                                            <li><a href="shop.php">Angelonia</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 02</a>
                                        <ul>
                                            <li><a href="shop.php">Balsam</a></li>
                                            <li><a href="shop.php">Baneberry</a></li>
                                            <li><a href="shop.php">Bee Balm</a></li>
                                            <li><a href="shop.php">Begonia</a></li>
                                            <li><a href="shop.php">Bellflower</a></li>
                                            <li><a href="shop.php">Bergenia</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 03</a>
                                        <ul>
                                            <li><a href="shop.php">Caladium</a></li>
                                            <li><a href="shop.php">Calendula</a></li>
                                            <li><a href="shop.php">Carnation</a></li>
                                            <li><a href="shop.php">Catmint</a></li>
                                            <li><a href="shop.php">Celosia</a></li>
                                            <li><a href="shop.php">Chives</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Categories 04</a>
                                        <ul>
                                            <li><a href="shop.php">Daffodil</a></li>
                                            <li><a href="shop.php">Dahlia</a></li>
                                            <li><a href="shop.php">Daisy</a></li>
                                            <li><a href="shop.php">Diascia</a></li>
                                            <li><a href="shop.php">Dusty Miller</a></li>
                                            <li><a href="shop.php">Dame’s Rocket</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="contact.php"> Contact us </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
