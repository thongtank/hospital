<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนผู้ใช้</title>
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
                    <h1>ลงทะเบียนผู้ใช้</h1>
                    <h5>แบบฟอร์มลงทะเบียนสำหรับผู้ใช้</h5>
                </hgroup>
            </header>
        </section>
        <section>
            <form action="php/insert_profile.php" method="POST" class="form-horizontal form-register">
                <div class="form-group">
                    <label for="username" class="control-label col-md-4">ชื่อผู้ใช้ *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label col-md-4">รหัสผ่าน *</label>
                    <div class="col-md-8">
                        <input type="password" aria-describedby="password-help" pattern="[a-zA-Z0-9]{6,12}" class="form-control" name="password" id="password" required>
                        <span class="help-block" id="password-help">รหัสผ่าน 6 ตัวอักษาขึ้นไป</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="control-label col-md-4"></label>
                    <div class="col-md-8">
                        <select name="title" id="title" class="form-control">
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="control-label col-md-4">ชื่อ *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="control-label col-md-4">นามสกุล *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateOfbirth" class="control-label col-md-4">วัน/เดือน/ปี เกิด *</label>
                    <div class="col-md-8">
                        <input type="date" name="birthday" class="form-control" aria-describedby="date_help-block" required>
                        <span class="help-block" id="date_help-block">วัน/เดือน/ปี (ค.ศ.)</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="tel" id="tel" cols="30" rows="5" aria-describedby="tel-helpBlock"></textarea>
                        <span id="tel-helpBlock" class="help-block">กรณีมีมากกว่า 1 หมายเลขให้ขั้นด้วยเครื่องหมาย ","<br>เช่น 090-111-0xxx,090-222-0xxx เป็นต้น</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label col-md-4">อีเมล์</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label col-md-4">ที่อยู่ *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="address" name="address" required="" aria-describedby="address-helpBox">
                        <span id="address-helpBox" class="help-block">บ้านเลขที่ / หมู่ ถนน ซอย ฯลฯ</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="province" class="control-label col-md-4">จังหวัด *</label>
                    <div class="col-md-8">
                        <select name="province" id="province" class="form-control" required>
                            <option value="">เลือกจังหวัด</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="amphur" class="control-label col-md-4">อำเภอ *</label>
                    <div class="col-md-8">
                        <select name="amphur" id="amphur" class="form-control" required>
                            <option value="">เลือกอำเภอ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="district" class="control-label col-md-4">ตำบล *</label>
                    <div class="col-md-8">
                        <select name="district" id="district" class="form-control" required>
                            <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="zipcode" class="control-label col-md-4">รหัสไปรษณีย์ *</label>
                    <div class="col-md-8">
                        <input type="text" pattern="[0-9]{5}" minlength="5" maxlength="5" size="5" name="zipcode" id="zipcode" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lat" class="control-label col-md-4">Latitude, Longitude</label>
                    <div class="col-md-8">
                        <input type="text" pattern="[0-9.,]+" name="latlng" id="latlng" class="form-control" aria-describedby="latlng-helpBlock">
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
                        <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการลงทะเบียนของท่าน ?');">บันทึก</button>
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
