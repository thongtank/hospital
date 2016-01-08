<?php
session_start();

$message = "";
// ตรวจสอบว่ามีการสร้างตัวแปร $_SESSION["not_found"] และมีค่าเท่ากับ "YES" หรือไม่ ?
if (isset($_SESSION["not_found"]) && $_SESSION["not_found"] == "YES") {
    $message = "<h5 style='color:red; text-align: center;'>Invalid Username Or Password</h5>";
}

// ลบ session ทั้งหมดในเว็บ
session_unset();
session_destroy();

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
        form {
            width: 40%;
            margin: 0px auto;
        }
        </style>
    </head>

    <body>
        <?php include "header.php";?>
            <article class="container-fluid">
                <section>
                    <form action="php/login.php" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <h1 class="text-center">เข้าสู่ระบบ</h1>
                            <?=$message;?>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default">เข้าสู่ระบบ</button> หรือ
                                <a href="create-profile.php">
                                    <button type="button" class="btn btn-success">ลงทะเบียน</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </section>
            </article>
            <?php include "footer.php";?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
