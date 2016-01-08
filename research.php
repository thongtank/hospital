<?php

session_start();
include 'php/config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$ht = new cls\hospitals;

// print "<pre>" . print_r($ht->get(), 1) . "</pre>";
// exit;

$hospital_option = "";
$selected = "";
foreach ($ht->get() as $k => $v) {
    if (isset($_GET['hospital'])) {
        $selected = ($v['hospital_id'] == $_GET['hospital']) ? "selected" : "";
    }
    $hospital_option .= "<option value='" . $v['hospital_id'] . "' " . $selected . ">" . $v['hospital_name'] . "</option>";
}

$typeofmedical_option = "";
$selected = "";
foreach ($ht->get_typeofmedical() as $k => $v) {
    if (isset($_GET['typeofmedical'])) {
        $selected = ($v['medical_type_id'] == $_GET['typeofmedical']) ? "selected" : "";
    }
    $typeofmedical_option .= "<option value='" . $v['medical_type_id'] . "' " . $selected . ">" . $v['medical_name'] . "</option>";
}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ประเมินการรักษา</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
    </head>

    <body>
        <?php include 'header.php';?>
            <article class="container">
                <section class="header">
                    <header>
                        <hgroup>
                            <h1>แบบประเมินการรักษา</h1>
                            <h5>ค้นหาข้อมูลวิเคราะห์จากทางโรงพยาบาลและสมาชิก</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <button type="button" class="btn btn-info" id="show-hide">button</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-stethoscope"></i></div>
                                        <input type="text" name="organ" id="organ" class="form-control" aria-describedby="organ-help-block" placeholder="ลักษณะอาการป่วย เช่น ไส้ติ่ง, หวัด เป็นต้น">
                                    </div>
                                    <span class="help-block" id="organ-help-block">สามารถใส่ได้มากกว่า 1 คำโดยใส่เครื่องหมาย "," คั่น เช่น คลอด,ครรภ์,บุตร เป็นต้น</span>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">฿</div>
                                        <input type="text" class="form-control" name="cost" id="cost" pattern="[0-9-><]{0,}" placeholder="ค่ารักษาพยาบาล" aria-describedby="cost-help-block">
                                    </div>
                                    <span class="help-block" id="cost-help-block">เช่น น้อยกว่า 30,000 บาท ให้กรอก <30000</span>
                                    <span class="help-block" id="cost-help-block">หรือ มากกว่า 30,000 บาท ให้กรอก >30000</span>
                                    <span class="help-block" id="cost-help-block">หรือ ระหว่าง 10,000 ถึง 30,000 บาท ให้กรอก 10000-30000</span>
                                </div>
                                <div class="form-group">
                                    <select name="medical_type_id" id="medical_type_id" class="form-control">
                                        <option value="">เลือกความชำนาญการ</option>
                                        <?=$typeofmedical_option;?>
                                            <option value="">ความชำนาญการทั้งหมด . . .</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="hospital_id" id="hospital_id" class="form-control">
                                        <option value="">เลือกโรงพยาบาล</option>
                                        <?=$hospital_option;?>
                                            <option value="">รพ. ทั้งหมด...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="province" id="province" class="form-control">
                                        <option value="">เลือกจังหวัด</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="amphur" id="amphur" class="form-control">
                                        <option value="">เลือกอำเภอ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="district" id="district" class="form-control">
                                        <option value="">เลือกตำบล</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">เลือกความพึงพอใจ</option>
                                        <option value="5">ดีมาก</option>
                                        <option value="4">ดี</option>
                                        <option value="3">ปานกลาง</option>
                                        <option value="2">พอใช้</option>
                                        <option value="1">ปรับปรุง</option>
                                        <option value="">ความพึงพอใจทั้งหมด . . .</option>
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <button class="submit btn btn-primary btn-lg" id="submit">วิเคราะห์ข้อมูล</button>
                                    <input type="hidden" value="s" name="do" id="do">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รพ.</th>
                                        <th>เฉลี่ยค่ารักษา</th>
                                        <th>เฉลี่ยความพึงพอใจ</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!isset($_GET['do'])) {?>
                                        <tr>
                                            <td colspan="6" align="center">ไม่พบข้อมูล</td>
                                        </tr>
                                        <?php
} else {
    // print_r($_GET);
    $html = $ht->research($_GET);
    print $html;
}
?>
                                </tbody>
                            </table>
                        </div>
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
                <!--
                <script src="js/esimakin-twbs-pagination-a0ceda4/jquery.twbsPagination.min.js"></script>
                <script src="js/jquery.tablesorter.pager.js"></script>
                -->
                <script src="js/__jquery.tablesorter/jquery.tablesorter.min.js"></script>
                <script type="text/javascript">
                $(function() {
                    $('form, table').css({
                        'margin-top': '10px'
                    });
                    $('#show-hide').text('แสดงฟอร์มค้นหา');
                    $('form').hide();

                    $('#show-hide').click(function(event) {
                        $(this).text(function(i, text) {
                            // alert(text);
                            // return text === "PUSH ME" ? "DON'T PUSH ME" : "PUSH ME";
                            return text === "ซ่อนฟอร์มค้นหา" ? "แสดงฟอร์มค้นหา" : "ซ่อนฟอร์มค้นหา";
                        });

                        $('form').toggle("slow/400/fast", function() {

                        });

                    });

                    $(".table")
                        .tablesorter({});
                });
                </script>;
                <script src="src/province.js"></script>
    </body>

    </html>
