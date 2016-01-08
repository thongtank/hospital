<?php

session_start();
include 'php/config/autoload.inc.php';

use classes as cls;
use config as cfg;
$db = new cfg\database;
$pv = new cls\provinces;
$ht = new cls\hospitals;

$province = $pv->get_all_province();
if ($province === false) {
    echo $province;
    exit;
}

$typeofmedical_option = "";
$selected = "";
foreach ($ht->get_typeofmedical() as $k => $v) {
    if (isset($_GET['typeofmedical'])) {
        $selected = ($v['medical_type_id'] == $_GET['typeofmedical']) ? "selected" : "";
    }
    $typeofmedical_option .= "<option value='" . $v['medical_type_id'] . "' " . $selected . ">" . $v['medical_name'] . "</option>";
}

/*Array
(
[hospital_key] => ม่วง
[province] => อุบลราชธานี
[province_hidden] => 23
[amphur] =>
[amphur_hidden] =>
[district] =>
[district_hidden] =>
)
 */

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ค้นหาโรงพยาบาล</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
    </head>

    <body>
        <?php include 'header.php';?>
            <article class="container">
                <section class="header">
                    <hgroup>
                        <h1>ค้นหาข้อมูลโรงพยาบาล</h1>
                        <h5>ที่ตั้ง, เบอร์ติดต่อ, อีเมล์ ฯลฯ</h5>
                    </hgroup>
                </section>
                <section class="content">
                    <div class="row">
                        <form action="" method="GET" class="form-inline col-md-12 text-center">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-home"></i></div>
                                    <input type="text" placeholder="ชื่อหรือที่อยู่โรงพยาบาล" name="hospital_key" id="hospital_key" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="medical_type_id" id="medical_type_id" class="form-control">
                                    <option value="">เลือกความชำนาญการ</option>
                                    <?=$typeofmedical_option;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input id="province" name="province" type="text" autocomplete="off" class="form-control" placeholder="จังหวัดของโรงพยาบาล">
                                <input type="hidden" name="province_hidden" id="province_hidden">
                            </div>
                            <div class="form-group">
                                <input name="amphur" id="amphur" type="text" class="form-control" placeholder="อำเภอของโรงพยาบาล">
                                <input type="hidden" name="amphur_hidden" id="amphur_hidden">
                            </div>
                            <!-- <div class="form-group">
                                <input id="district" type="text" name="district" class="form-control" placeholder="ตำบลของโรงพยาบาล">
                                <input type="hidden" name="district_hidden" id="district_hidden">
                            </div> -->
                            <div class="form-group">
                                <button class="btn btn-primary " type="submit"><i class="fa fa-search"></i> ค้นหา ...</button>
                            </div>
                            <input type="hidden" name="do" value="s">
                        </form>
                    </div>
                    <div class="row">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รพ.</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>อีเมล์</th>
                                    <th>แผนที่</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
if (isset($_GET['do']) && $_GET['do'] == 's') {
    $ht = new cls\hospitals;
    $rows = $ht->search($_GET);
    if ($rows !== false) {
        $_GET['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $i = ($_GET['page'] - 1) * 10;
        if (count($rows) > 0) {
            foreach ($rows as $k => $v) {
                $i++;
                $province = $pv->get_province($v['province']);
                $amphur = $pv->get_amphur($v['amphur']);
                $district = $pv->get_district($v['district']);
                $address = $v['hospital_address'] . " อำเภอ" . $amphur[0]['AMPHUR_NAME'] . " ตำบล" . $district[0]['DISTRICT_NAME'] . " จังหวัด" . $province[0]['PROVINCE_NAME'] . $v['zipcode'];
                echo "
            <tr>
                <td>" . $i . "</td>
                <td>" . $v['hospital_name'] . "</td>
                <td>" . $address . "</td>
                <td>" . $v['tel'] . "</td>
                <td>" . $v['email'] . "</td>
                <td><a href='hospital_detail.php?do=s&hospital_id=" . $v['hospital_id'] . "' title='ที่ตั้งโรงพยาบาล'><i class='fa fa-map'></i></a></td>
            </tr>
            ";
            }
        } else {
            echo '<tr>
                                        <td colspan="6" align="center">ไม่พบข้อมูล</td>
                                    </tr>';
        }

    }
} else {
    ?>
                                    <tr>
                                        <td colspan="6" align="center">ไม่พบข้อมูล</td>
                                    </tr>
                                    <?php
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                                <ul class="pagination pagination-sm">
                                    <?php
if (isset($_GET['do'])) {
    echo $ht->paging();
}

?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </article>
            <?php include 'footer.php';?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="js/jquery.tablesorter.pager.js"></script>
                <script src="js/__jquery.tablesorter/jquery.tablesorter.min.js"></script>
                <script>
                $(function() {
                    $(".table")
                        .tablesorter({});

                    $("#province").autocomplete({
                            source: "province.php",
                            select: function(evt, ui) {
                                // console.log(ui);
                                $(this).val(ui.item.name);
                                $("#province_hidden").val(ui.item.id);
                                return false;
                            }
                        })
                        .autocomplete("instance")._renderItem = function(ul, item) {
                            return $("<li>")
                                .append(item.name)
                                .appendTo(ul);
                        };

                    $("#amphur").autocomplete({
                            source: "amphur.php",
                            select: function(evt, ui) {
                                // console.log(ui);
                                $(this).val(ui.item.name);
                                $("#amphur_hidden").val(ui.item.id);
                                return false;
                            }
                        })
                        .autocomplete("instance")._renderItem = function(ul, item) {
                            return $("<li>")
                                .append(item.name)
                                .appendTo(ul);
                        };

                    /**
                    $("#district").autocomplete({
                            source: "district.php",
                            select: function(evt, ui) {
                                // console.log(ui);
                                $(this).val(ui.item.name);
                                $("#district_hidden").val(ui.item.id);
                                return false;
                            }
                        })
                        .autocomplete("instance")._renderItem = function(ul, item) {
                            return $("<li>")
                                .append(item.name)
                                .appendTo(ul);
                        };
                    */
                });
                </script>
    </body>

    </html>
