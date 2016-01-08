<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
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
$hospital_option = "";
foreach ($ht->get() as $k => $v) {
    $hospital_option .= "<option value='" . $v['hospital_id'] . "'>" . $v['hospital_name'] . "</option>";
}

$typeofmedical_option = "";
foreach ($ht->get_typeofmedical() as $k => $v) {
    $typeofmedical_option .= "<option value='" . $v['medical_type_id'] . "'>" . $v['medical_name'] . "</option>";
}
$typeofmedical_option .= "<option value='9999'>อื่นๆ</option>";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>เพิ่มประวัติการรักษาพยาบาล</title>
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
                            <h1>ประวัติการรักษาพยาบาล</h1>
                            <h5>แบบฟอร์มประวัติการรักษาพยาบาล</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="php/insert_medical.php" method="POST" class="">
                                <div class="form-group">
                                    <label for="hospital" class="control-label">โรงพยาบาล *</label>
                                    <select name="hospital" id="hospital" class="form-control" required>
                                        <option value="">เลือกโรงพยาบาล</option>
                                        <?=$hospital_option;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="typeofmedical" class="control-label">ลักษณะการรักษา *</label>
                                    <select name="typeofmedical" id="typeofmedical" class="form-control" required>
                                        <option value="">เลือกความชำนาญการ</option>
                                        <?=$typeofmedical_option;?>
                                    </select>
                                    <span class="help-block" id="typeofmedical-help">กรณีไม่มีความชำนาญที่ต้องการให้เลือก "อื่นๆ" จากนั้นใส่รายละเอียดในช่องอาการด้านล่าง</span>
                                </div>
                                <div class="form-group">
                                    <label for="organ" class="control-label">อาการ *</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-stethoscope"></i></div>
                                        <input type="text" id="organ" class="form-control" name="organ" aria-describedby="organ-help-block" required>
                                    </div>
                                    <span class="help-block" id="organ-help-block">เช่น เป็นไข้หวัด, ผ่าตัดไส้ติ่ง, ท้องอืด เป็นต้น</span>
                                </div>
                                <div class="form-group">
                                    <label for="date_start" class="control-label">วันที่เข้ารักษา</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" name="date_start" id="date_start" class="form-control" aria-describedby="date_help-block">
                                    </div>
                                    <span class="help-block" id="date_help-block">วัน/เดือน/ปี (ค.ศ.)</span>
                                </div>
                                <div class="form-group">
                                    <label for="date_end" class="control-label">ถึง</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" id="date_end" name="date_end" class="form-control" aria-describedby="date_help-block">
                                    </div>
                                    <span class="help-block" id="date_help-block">วัน/เดือน/ปี (ค.ศ.)</span>
                                </div>
                                <div class="form-group">
                                    <label for="cost" class="control-label">ค่ารักษาพยาบาล *</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">฿</div>
                                        <input type="number" name="cost" id="cost" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group medicine_order">
                                    <label for="amountofmedicine" class="control-label">จำนวนยา</label>
                                    <select name="amountofmedicine" id="amountofmedicine" class="form-control" aria-describedby="amountofmedicine-block">
                                        <option value="">เลือกจำนวนยา</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <span class="help-block" id="amountofmedicine-block">สูงสุด 10 ตัวยา</span>
                                </div>
                                <div class="form-group">
                                    <label for="rating" class="control-label">ความพึงพอใจ *</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rating" id="rating" value="5" checked> ดีมาก
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rating" id="rating" value="4"> ดี
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rating" id="rating" value="3"> ปานกลาง
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rating" id="rating" value="2"> พอใช้
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rating" id="rating" value="1"> ปรับปรุง
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment" class="control-label">ความคิดเห็นเพิ่มเติม</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-success" type="submit" onclick="return confirm('ยืนยันการบันทึกข้อมูล ?');">บันทึกข้อมูล</button>
                                    <button class="btn btn-danger" type="reset">ล้างข้อมูล</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
            <?php include 'footer.php';?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
                <script type="text/javascript">
                $(function() {
                    $("#typeofmedical").change(function() {
                        if ($(this).val() == 9999) {
                            $("#organ").select();
                        }
                    });
                    $("#amountofmedicine").change(function() {
                        $('.sub-medicine').remove();
                        // alert($(this).val());
                        var s = $(this).val();
                        if (s !== "") {
                            $.ajax({
                                    url: 'php/get_medicine.php',
                                    type: 'POST',
                                    dataType: 'html',
                                    data: {
                                        s: $(this).val(),
                                        rt: 'html'
                                    }
                                })
                                .done(function(ele) {
                                    $(ele).insertAfter('#amountofmedicine-block');
                                });
                        }
                    });
                });
                </script>
    </body>

    </html>
