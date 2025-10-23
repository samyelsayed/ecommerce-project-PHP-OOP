<?php  $title = "shop";
   include_once "layouts/header.php";
   include_once "layouts/nav.php";
   include_once "layouts/breadcrumb.php";
   include_once 'app/models/Product.php';


   $productObject = new Product;
   $productObject->setStatus(1);
   if($_GET){
      if($_GET['sub']){           //علشان لو اليوزر شغل دماغه ولعب ف الكويري استرنج وغير الكي
        if(is_numeric($_GET['sub'])){
                   $objectSubcategory->setId($_GET['sub']);          //علشان لو شغل دماغه لو في رفم الكويري استرنج
                   $objectSubcategoryData = $objectSubcategory->searchOnId();
                        if($objectSubcategoryData){
                        $productObject->setSubcategory_id($_GET['sub']); 
                        $productResult = $productObject->getProductsBySubs();
                        }else{
                        $productResult = $productObject->read();     //get all products
                        }

        }else{
            header("Location:layouts/errors/404.php");
        }    
      }else{
            $productResult = $productObject->read();     //get all products

      }

  }else{
     $productResult = $productObject->read();            //get all products
  }

   ?>
		<!-- Shop Page Area Start -->
        <div class="shop-page-area ptb-100">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-9">
                        <div class="shop-topbar-wrapper">
                            <div class="shop-topbar-left">
                                <ul class="view-mode">
                                    <li class="active"><a href="#product-grid" data-view="product-grid"><i class="fa fa-th"></i></a></li>
                                    <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                                </ul>
                                <p>Showing 1 - 20 of 30 results  </p>
                            </div>
                            <div class="product-sorting-wrapper">
                                <div class="product-shorting shorting-style">
                                    <label>View:</label>
                                    <select>
                                        <option value=""> 20</option>
                                        <option value=""> 23</option>
                                        <option value=""> 30</option>
                                    </select>
                                </div>
                                <div class="product-show shorting-style">
                                    <label>Sort by:</label>
                                    <select>
                                        <option value="">Default</option>
                                        <option value=""> Name</option>
                                        <option value=""> price</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="grid-list-product-wrapper">
                            <div class="product-grid product-view pb-20">
                                <div class="row">
                                    <!-- //loop on products -->
                                    <!-- بنفس الخطوات بتاعت الكاتجوريز ولا حاجة هتزيد وا حاجة هتقل -->
                                    <!-- //بعدين اتاكد هل  الراري دي فيها بيانات ولا لا ولو فيها اعملها فيتش -->
                                   <?php 
                                   if($productResult){
                                    $products = $productResult ->fetch_all(MYSQLI_ASSOC);
                                    foreach($products as $index => $product){
                                        ?>

                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="product-details.php">
                                                    <img alt="" src="assets/img/product/<?= $product['image'] ?>">
                                                </a>
                                                <span>-30%</span>
                                                <div class="product-action">
                                                    <a class="action-wishlist" href="#" title="Wishlist">
														<i class="ion-android-favorite-outline"></i>
													</a>
													<a class="action-cart" href="#" title="Add To Cart">
														<i class="ion-ios-shuffle-strong"></i>
													</a>
													<a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
														<i class="ion-ios-search-strong"></i>
													</a>
                                                </div>
                                            </div>
                                            <div class="product-content text-left">
												<div class="product-hover-style">
													<div class="product-title">
														<h4>
															<a href="product-details.php"><?= $product['name_en'] ?></a>
														</h4>
													</div>
													<div class="cart-hover">
														<h4><a href="product-details.php">+ Add to cart</a></h4>
													</div>
												</div>
												<div class="product-price-wrapper">
													<span><?= $product['price'] ?> EGP</span>
												</div>
											</div>
                                            <div class="product-list-details">
                                                <h4>
                                                    <a href="product-details.php"><?= $product['name_en '] ?></a>
                                                </h4>
                                                <div class="product-price-wrapper">
                                                    <span><?= $product['price'] ?> EGP</span>
                                                </div>
                                                <p><?= $product['desc_en'] ?> </p>
                                                <div class="shop-list-cart-wishlist">
                                                    <a href="#" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" title="Add To Cart"><i class="ion-ios-shuffle-strong"></i></a>
                                                    <a href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                                        <i class="ion-ios-search-strong"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    }
                                   }else{
                                                echo"<div class='alert alert-warning text-center w-100'>No Products Yet</div>";
                                            }
                                   
                                   
                                   
                                   ?>
                                    
                                </div>
                            </div>
                            <div class="pagination-total-pages">
                                <div class="pagination-style">
                                    <ul>
                                        <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a></li>
                                        <li><a class="active" href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">...</a></li>
                                        <li><a href="#">10</a></li>
                                        <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i> </a></li>
                                    </ul>
                                </div>
                                <div class="total-pages">
                                    <p>Showing 1 - 20 of 30 results  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                            <div class="shop-widget">
                                <h4 class="shop-sidebar-title">Shop By Categories</h4>
                                <div class="shop-catigory">
                                    <ul id="faq">

                                 <!-- //نفس الي في الناف بس كان حصل مشكله علشان كنت عملت فيتش ل  اراري انا عاملها فيتش -->
                                     <?php if(!empty($categoryResult)){
                                         foreach($categories as $key => $category){ 

                                        ?> 
                                        <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-<?= $key ?>"><?= $category['name_en'] ?> <i class="ion-ios-arrow-down"></i></a>
                                            <ul id="shop-catigory-<?= $key ?>" class="panel-collapse collapse ">
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
                                </div>
                            </div>
                            <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">Price Filter</h4>
                                <div class="price_filter mt-25">
                                    <span>Range:  $100.00 - 1.300.00 </span>
                                    <div id="slider-range"></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <input type="text" id="amount" name="price"  placeholder="Add Your Price" />
                                        </div>
                                        <button type="button">Filter</button> 
                                    </div>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">By Brand</h4>
                                <div class="sidebar-list-style mt-20">
                                    <ul>
                                        <li><input type="checkbox"><a href="#">Green </a>
                                        <li><input type="checkbox"><a href="#">Herbal </a></li>
                                        <li><input type="checkbox"><a href="#">Loose </a></li>
                                        <li><input type="checkbox"><a href="#">Mate </a></li>
                                        <li><input type="checkbox"><a href="#">Organic </a></li>
                                        <li><input type="checkbox"><a href="#">White  </a></li>
                                        <li><input type="checkbox"><a href="#">Yellow Tea </a></li>
                                        <li><input type="checkbox"><a href="#">Puer Tea </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">By Color</h4>
                                <div class="sidebar-list-style mt-20">
                                    <ul>
                                        <li><input type="checkbox"><a href="#">Black </a></li>
                                        <li><input type="checkbox"><a href="#">Blue </a></li>
                                        <li><input type="checkbox"><a href="#">Green </a></li>
                                        <li><input type="checkbox"><a href="#">Grey </a></li>
                                        <li><input type="checkbox"><a href="#">Red</a></li>
                                        <li><input type="checkbox"><a href="#">White  </a></li>
                                        <li><input type="checkbox"><a href="#">Yellow   </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">Compare Products</h4>
                                <div class="compare-product">
                                    <p>You have no item to compare. </p>
                                    <div class="compare-product-btn">
                                        <span>Clear all </span>
                                        <a href="#">Compare <i class="fa fa-check"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">Popular Tags</h4>
                                <div class="shop-tags mt-25">
                                    <ul>
                                        <li><a href="#">Green</a></li>
                                        <li><a href="#">Oolong</a></li>
                                        <li><a href="#">Black</a></li>
                                        <li><a href="#">Pu'erh</a></li>
                                        <li><a href="#">Dark </a></li>
                                        <li><a href="#">Special</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- Shop Page Area End -->
     
	 <?php include_once "layouts/footer.php"; ?>
     <?php include_once "layouts/footer-scripts.php"; ?>