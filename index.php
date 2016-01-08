<?php
session_start();
// print_r($_SESSION['profile_detail']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ระบบวิเคราะห์และออกแบบแผนการรักษาพยาบาลผู้สูงอายุ</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
        <style>
        div.menu {
            height: 200px;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        </style>
    </head>

    <body>
        <?php include "header.php";?>
            <article class="container-fluid">
                <section class="container">
                    <div class="col-md-4 menu text-center">
                        <?php if ($_SESSION['profile'] != 'logon') {?>
                            <a href="create-profile.php" title="ลงทะเบียนประวัติ">
                                <i class="fa fa-user-plus fa-5x"></i>
                                <h1 class="">ลงทะเบียนประวัติ</h1>
                            </a>
                            <?php } else {?>
                                <a href="medical.php" title="ประวัติการรักษา">
                                    <i class="fa fa-archive fa-5x"></i>
                                    <h1 class="">ประวัติการรักษา</h1>
                                </a>
                                <?php }
?>
                    </div>
                    <div class="col-md-4 menu text-center">
                        <a href="research.php" title="ประเมินการรักษา">
                            <i class="fa fa-line-chart fa-5x"></i>
                            <h1 class="">ประเมินการรักษา</h1>
                        </a>
                    </div>
                    <div class="col-md-4 menu text-center">
                        <a href="search.php" title="ค้นหาโรงพยาบาล">
                            <i class="fa fa-search fa-5x"></i>
                            <h1 class="">ค้นหาโรงพยาบาล</h1>
                        </a>
                    </div>
                    <div class="col-md-12 menu text-center">
                        <?php if (!isset($_SESSION['profile']) || $_SESSION['profile'] != "logon") {?>
                            <a href="signin.php" title="เข้่สู่ระบบ">
                                <i class="fa fa-sign-in fa-5x"></i>
                                <h1 class="">เข้าสู่ระบบ</h1>
                            </a>
                            <?php } else {?>
                                <a href="signout.php" onclick="return confirm('ยืนยันการออกจากระบบ ?');" title="ออกจากระบบ">
                                    <i class="fa fa-sign-out fa-5x"></i>
                                    <h1 class="">ออกจากระบบ</h1>
                                </a>
                                <?php }
?>
                    </div>
                </section>
            </article>
            <?php include 'footer.php';?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
