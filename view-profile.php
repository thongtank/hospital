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
use config\database as db;

$db = new db;
$pv = new cls\provinces();
$pf = new cls\profiles();
$ht = new cls\hospitals();

$data_medical = $ht->get_medical($_SESSION['profile_detail']['profile_username']);

$data = $pf->get_profile(trim($_SESSION['profile_detail']['profile_id']));
$province = $pv->get_province($data['province'])[0];
$amphur = $pv->get_amphur($data['amphur'])[0];
$district = $pv->get_district($data['district'])[0];
// print "<pre>" . print_r($province, 1) . "</pre>";
// exit;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ข้อมูลส่วนตัว</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
    </head>

    <body>
        <?php include "header.php";?>
            <article class="container" style="">
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h1 class=""><?=$data['title'] . "" . $data['firstname'] . " " . $data['lastname'] . " <small>( " . $data['age'] . " ปี )</small>";?></h1>
                                </div>
                                <div class="panel-body">
                                    <p class="lead">
                                        <strong>เกิดเมื่อวันที่</strong>
                                        <?=$pf->convert_birthday($data['birthday'], $arr_month);?>
                                    </p>
                                    <p class="lead">
                                        <strong>ที่อยู่</strong>
                                        <?=$data['address'] . " ตำบล" . $district['DISTRICT_NAME'] . " อำเภอ" . $amphur['AMPHUR_NAME'] . " จังหวัด" . $province['PROVINCE_NAME'] . " " . $data['zipcode'];?>
                                    </p>
                                    <p class="lead">
                                        <strong>เบอร์โทรศัพท์ </strong>
                                        <?=$data['tel'];?>
                                    </p>
                                    <p class="lead">
                                        <strong>อีเมล์ </strong>
                                        <?=($data['email'] == "") ? "-" : $data['email'];?>
                                    </p>
                                    <p>
                                        <a href="edit-profile.php">
                                            <button class="btn btn-info"><i class="fa fa-pencil"></i> แก้ไขข้อมุลส่วนตัว</button>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-12">
                            <a href="create-medical.php">
                                <button class="btn btn-info"><i class="fa fa-plus fa-lg"></i> บันทึกประวัติการรักษา</button>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>โรงพยาบาล</th>
                                        <th>อาการ</th>
                                        <th>ค่ารักษาพยาบาล</th>
                                        <th>วันที่บันทึกข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$i = 0;
if (count($data_medical) > 0) {
    foreach ($data_medical as $key => $value) {
        $i++;
        $hospital = $ht->get_hospital_detail_by_id($value['hospital_id']);
        $time = strtotime($value['date_added']);
        $y = date("Y", $time) + 543;
        $m = $arr_month[date("m", $time)];
        $date = date("d", $time) . " " . $m . " " . $y;
        print "
                                <tr>
                                    <td>" . $i . "</td>
                                    <td>" . $hospital['hospital_name'] . "</td>
                                    <td>" . $value['organ'] . "</td>
                                    <td>" . number_format($value['cost']) . "</td>
                                    <td>" . $date . "</td>
                                </tr>
                                ";
    }
} else {
    echo "
<tr>
    <td colspan=5 align=center>ไม่มีประวัติการรักษา</td>
</tr>
    ";
}

?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </article>
            <?php include 'footer.php';?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="js/__jquery.tablesorter/jquery.tablesorter.min.js"></script>
                <script>
                $(function() {
                    $('.table').tablesorter({});
                });
                </script>
    </body>

    </html>
