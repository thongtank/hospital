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
$ht = new cls\hospitals;

/*
[profile] => logon
[profile_username] => user1
[profile_typeOfUser] => profile
[profile_detail] => Array
(
[profile_id] => 7
[profile_username] => user1
[profile_pwd] => 1234
[firstname] => รมิตา
[lastname] => จิระกิจอนันต์
[age] => 25
[title] => นางสาว
[gender] => F
[birthday] => 1990-10-10
[tel] => 0877797910
[email] => p_ramij@hotmail.com
[address] => 439 ถ.สรรพสิทธิ์
[province] => 23
[amphur] => 312
[district] => 2788
[zipcode] => 34000
[lat] =>
[lng] =>
[date_added] => 2015-11-01 17:14:30
[privacy] => 1
[last_login] => 0000-00-00 00:00:00
[a] => 1
)

 */
$data = $ht->get_medical($_SESSION['profile_detail']['profile_username']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ประวัติการรักษา</title>
    </head>
    <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/mine.css">

    <body>
        <?php include 'header.php';?>
            <article class="container">
                <header>
                    <hgroup>
                        <h1>ประวัติการรักษา </h1>
                    </hgroup>
                </header>
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
if (count($data) > 0) {
    foreach ($data as $key => $value) {
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
