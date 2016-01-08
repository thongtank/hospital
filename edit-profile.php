<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION['profile']) && $_SESSION['profile'] == 'logon') {
    include 'php/config/autoload.inc.php';
} else {
    echo "
    <script type='text/javascript'>
        alert('กรุณาเข้าสู่ระบบก่อนกรอกประวัติการรักษา');
        window.location = 'signin.php';
    </script>
    ";
    exit;
}

use classes as cls;
use config as cfg;
$db = new cfg\database;
$pv = new cls\provinces;
// print "<pre>" . print_r($_SESSION, 1) . "</pre>";
// exit;
/*
Array
(
[profile] => logon
[profile_username] => user111
[profile_typeOfUser] => profile
[profile_detail] => Array
(
[profile_id] => 51
[profile_username] => user111
[profile_pwd] => 123456
[firstname] => กรุณ
[lastname] => รูปหล่อ
[age] => 26
[title] => นาย
[gender] => M
[birthday] => 1988-12-21
[tel] => 0875435550,045261624
[email] =>
[address] => 439 ถ.สรรพสิทธิ์
[province] => 23
[amphur] => 312
[district] => 2788
[zipcode] => 34000
[lat] =>
[lng] =>
[date_added] => 2015-11-10 23:14:13
[privacy] => 1
[last_login] => 0000-00-00 00:00:00
[a] => 1
)

[admin] => logon
[admin_username] => admin
[typeOfUser] => admin
)
 */
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขข้อมูลส่วนตัว</title>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/mine.css">
        <style type="text/css">
        .form-register {
            border-style: solid;
            border-color: #ddd;
            border-width: 1px;
            border-radius: 4px 4px 4px 4px;
            padding: 15px 10px 0px 10px;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: auto;
            margin-right: auto;
        }
        </style>
    </head>

    <body>
        <div class="se-pre-con"></div>
        <?php include 'header.php';?>
            <article class="container">
                <section>
                    <header>
                        <hgroup>
                            <h1>แก้ไขข้อมูลส่วนตัว</h1>
                            <h5>แบบฟอร์มแก้ไขข้อมูลส่วนตัว</h5>
                        </hgroup>
                    </header>
                </section>
                <section>
                    <form action="php/update_profile.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="title" class="control-label col-md-4"></label>
                            <div class="col-md-8">
                                <select name="title" id="title" class="form-control">
                                    <option value="นาย" <?php echo ($_SESSION['profile_detail']['title'] == "นาย") ? "selected" : "";?>>นาย</option>
                                    <option value="นาง" <?php echo ($_SESSION['profile_detail']['title'] == "นาง") ? "selected" : "";?>>นาง</option>
                                    <option value="นางสาว" <?php echo ($_SESSION['profile_detail']['title'] == "นางสาว") ? "selected" : "";?>>นางสาว</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="control-label col-md-4">ชื่อ *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="firstname" name="firstname" value=<?=$_SESSION['profile_detail']['firstname'];?> required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="control-label col-md-4">นามสกุล *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="lastname" name="lastname" value=<?=$_SESSION['profile_detail']['lastname'];?> required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dateOfbirth" class="control-label col-md-4">วัน/เดือน/ปี เกิด *</label>
                            <div class="col-md-8">
                                <input type="date" name="birthday" class="form-control" aria-describedby="date_help-block" value=<?=$_SESSION['profile_detail']['birthday'];?> required>
                                <span class="help-block" id="date_help-block">เดือน/วัน/ปี (ค.ศ.)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="tel" id="tel" cols="30" rows="5" aria-describedby="tel-helpBlock">
                                    <?=$_SESSION['profile_detail']['tel'];?>
                                </textarea>
                                <span id="tel-helpBlock" class="help-block">กรณีมีมากกว่า 1 หมายเลขให้ขั้นด้วยเครื่องหมาย ","<br>เช่น 090-111-0xxx,090-222-0xxx เป็นต้น</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-4">อีเมล์</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="email" name="email" value="<?=$_SESSION['profile_detail']['email'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label col-md-4">ที่อยู่ *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="address" value="<?=$_SESSION['profile_detail']['address'];?>" name="address" required="" aria-describedby="address-helpBox">
                                <span id="address-helpBox" class="help-block">บ้านเลขที่ / หมู่ ถนน ซอย ฯลฯ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="province" class="control-label col-md-4">จังหวัด</label>
                            <div class="col-md-8">
                                <?php $province = $pv->get_province($_SESSION['profile_detail']['province']);?>
                                    <select name="province" id="province" class="form-control" aria-describedby="province-helpBox">
                                        <option value="">เลือกจังหวัด</option>
                                    </select>
                                    <span id="province-helpBox" class="help-block">จังหวัดเดิมคือ <?=$province[0]['PROVINCE_NAME'];?></span>
                                    <input type="hidden" name="hidden_province_id" value="<?=$province[0]['PROVINCE_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amphur" class="control-label col-md-4">อำเภอ</label>
                            <div class="col-md-8">
                                <?php $amphur = $pv->get_amphur($_SESSION['profile_detail']['amphur']);?>
                                    <select name="amphur" id="amphur" class="form-control" aria-describedby="amphur-helpBox">
                                        <option value="">เลือกอำเภอ</option>
                                    </select>
                                    <span id="amphur-helpBox" class="help-block">อำเภอเดิมคือ <?=$amphur[0]['AMPHUR_NAME'];?></span>
                                    <input type="hidden" name="hidden_amphur_id" value="<?=$amphur[0]['AMPHUR_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="district" class="control-label col-md-4">ตำบล</label>
                            <div class="col-md-8">
                                <?php $district = $pv->get_district($_SESSION['profile_detail']['district']);?>
                                    <select name="district" id="district" class="form-control" aria-describedby="district-helpBox">
                                        <option value="">เลือกตำบล</option>
                                    </select>
                                    <span id="district-helpBox" class="help-block">ตำบลเดิมคือ <?=$district[0]['DISTRICT_NAME'];?></span>
                                    <input type="hidden" name="hidden_district_id" value="<?=$district[0]['DISTRICT_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zipcode" class="control-label col-md-4">รหัสไปรษณีย์ *</label>
                            <div class="col-md-8">
                                <input type="text" pattern="[0-9]{5}" value="<?=$_SESSION['profile_detail']['zipcode'];?>" minlength="5" maxlength="5" size="5" name="zipcode" id="zipcode" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lat" class="control-label col-md-4">Latitude, Longitude</label>
                            <div class="col-md-8">
                                <?php
$comma = "";
if ($_SESSION['profile_detail']['lng'] != "") {
    $comma = ",";
}
?>
                                <input type="text" value="<?=$_SESSION['profile_detail']['lat'] . "" . $comma . "" . $_SESSION['profile_detail']['lng'];?>" pattern="[0-9.,]+" name="latlng" id="latlng" class="form-control" aria-describedby="latlng-helpBlock">
                                <span class="help-block" id="latlng-helpBlock">เช่น 15.2407686,104.839887</span>
                            </div>
                        </div>
                        <!--
                <div class="form-group">
                    <label for="privacy" class="control-label col-md-4">ความเป็นส่วนตัว</label>
                    <div class="col-md-8">
                        <label class="radio-inline">
                            <input type="radio" name="privacy" id="privacy" value="0" checked="checked"> ส่วนตัว
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="privacy" id="privacy" value="1"> สาธารณะ
                        </label>
                    </div>
                </div>
                -->
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการแก้ไขข้อมูลของท่าน ?');">แก้ไข</button>
                                <button class="btn btn-danger" type="reset">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </section>
            </article>
            <?php include 'footer.php';?>
                <script src="src/person.js"></script>
                <script src="src/province.js"></script>
                <script src="js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
