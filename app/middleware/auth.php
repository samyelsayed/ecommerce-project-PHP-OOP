<?php
if(empty($_SESSION['user'])){
    header("location:login.php");die;               //دا بيسمح لليوزر الي سجل دخول بس انه يدخل ع الصفحه دي
}                                                         //لو مفيش يوزر مسجل دخول هيوديه ع صفحه اللوجين