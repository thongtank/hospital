<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    include '../php/config/autoload.inc.php';
}
use classes as cls;
use config\database as db;

$db = new db;
$pv = new cls\provinces();
$pf = new cls\profiles();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Management</title>
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    </head>

    <body>
        <article class="container-fluid">
            <?php include "header.php";?>
                <section>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>โรงพยาบาล <a href="create-hospital.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ใบอนุญาติ</th>
                                            <th>ชื่อ</th>
                                            <th>ที่ตั้ง</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
$sql = "select * from hospital order by hospital_id DESC limit 5;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    foreach ($rows as $k => $v) {
        $province = $pv->get_province($v['province']);
        $provine_name = $province[0]['PROVINCE_NAME'];
        $amphur = $pv->get_amphur($v['amphur']);
        $amphur_name = $amphur[0]['AMPHUR_NAME'];
        $district = $pv->get_district($v['district']);
        $district_name = $district[0]['DISTRICT_NAME'];

        print "
        <tr>
            <td>" . $v['hospital_verify_code'] . "</td>
            <td>โรงพยาบาล" . $v['hospital_name'] . "</td>
            <td>
                " . $v['hospital_address'] . " อำเภอ" . $amphur_name . " ตำบล" . $district_name . " จังหวัด" . $provine_name . $v['zipcode'] . "
            </td>
            <td><a href='delete-hospital.php?id=" . $v['hospital_id'] . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
            <td><a href='edit-hospital.php?id=" . $v['hospital_id'] . "'><i class='fa fa-pencil'></i></a></td>
        </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                    </table>
                                </div>
                                <div class="panel-footer text-right">
                                    <a href="list-hospital.php">โรงพยาบาลทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3>ยา <a href="create-medicine.php"><i style="" class="fa fa-plus"></i></a></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>เลขทะเบียนยา</th>
                                            <th>ชื่อยา</th>
                                            <th>ผู้ได้รับอนุญาต</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
$sql = "select * from medicine order by date_added desc limit 5;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    foreach ($rows as $k => $v) {
        print "
        <tr>
            <td>" . $v['medicine_id'] . "</td>
            <td>" . $v['medicine_name_th'] . "</td>
            <td>" . $v['owner_name'] . "</td>
            <td><a href='delete-medicine.php?id=" . urlencode($v['medicine_id']) . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
            <td><a href='edit-medicine.php?id=" . urlencode($v['medicine_id']) . "'><i class='fa fa-pencil'></i></a></td>
        </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                    </table>
                                </div>
                                <div class="panel-footer text-right">
                                    <a href="list-medicine.php">ยาทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3>ประเภทการรักษา <a href="create-typeofmedical.php"><i style="" class="fa fa-plus"></i></a></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ความชำนาญการ</th>
                                            <th>สร้างโดย</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
$sql = "select * from typeOfmedical order by date_added desc limit 5;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    foreach ($rows as $k => $v) {
        print "
        <tr>
            <td>" . $v['medical_name'] . "</td>
            <td>" . $v['added_from'] . "</td>
            <td><a href='delete-typeofmedical.php?id=" . urlencode($v['medical_type_id']) . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
            <td><a href='edit-typeofmedical.php?id=" . urlencode($v['medical_type_id']) . "'><i class='fa fa-pencil'></i></a></td>
        </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                    </table>
                                </div>
                                <div class="panel-footer text-right">
                                    <a href="list-typeofmedical.php">ความชำนาญทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3>สมาชิก</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>เพศ</th>
                                            <th>ว/ด/ป เกิด</th>
                                            <th>อายุ</th>
                                            <th>ที่อยู่</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
$sql = "select * from profile order by date_added desc limit 5;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    foreach ($rows as $k => $v) {
        $gender = "หญิง";
        if ($v['gender'] == "M") {
            $gender = "ชาย";
        }

        $province = $pv->get_province($v['province']);
        $provine_name = $province[0]['PROVINCE_NAME'];
        $amphur = $pv->get_amphur($v['amphur']);
        $amphur_name = $amphur[0]['AMPHUR_NAME'];
        $district = $pv->get_district($v['district']);
        $district_name = $district[0]['DISTRICT_NAME'];
        /* วันเกิด */
        $birthday = $pf->convert_birthday($v['birthday'], $arr_month);

        print "
        <tr>
            <td>" . $v['title'] . $v['firstname'] . " " . $v['lastname'] . "</td>
            <td>" . $gender . "</td>
            <td>" . $birthday . "</td>
            <td>" . $v['age'] . "</td>
            <td>"
        . $v['address'] . " <BR>อำเภอ" . $amphur_name . " <BR>ตำบล" . $district_name . " <BR>จังหวัด" . $provine_name . $v['zipcode'] . "
            </td>
            <td>" . str_replace(",", "<BR>", $v['tel']) . "</td>
            <td><a href='view-profile.php?id=" . urlencode($v['profile_id']) . "'><i class='fa fa-list'></i></a></td>
            <td><a href='delete-profile.php?id=" . urlencode($v['profile_id']) . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
        </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                    </table>
                                </div>
                                <div class="panel-footer text-right">
                                    <a href="list-profile.php">สมาชิกทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-md-3 hidden-print hidden-xs hidden-sm affix" style="right: 0;">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">รายการ</h3>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="#hospital"><i class="fa fa-heartbeat"></i> โรงพยาบาล</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#medicine"><i class="fa fa-medkit"></i> ยา</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#profile"><i class="fa fa-users"></i> สมาชิก</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    -->
                </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
