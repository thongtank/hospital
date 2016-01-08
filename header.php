<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">ระบบวิเคราะห์แผนการรักษาพยาบาล</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li class="">
                        <a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a>
                    </li>
                    <li class="">
                        <a href="research.php"><i class="fa fa-line-chart"></i> ประเมินการรักษา</a>
                    </li>
                    <li class="">
                        <a href="search.php"><i class="fa fa-search"></i> ค้นหา รพ.</a>
                    </li>
                </ul>
            </div>
            <?php
if (!isset($_SESSION['profile']) or $_SESSION['profile'] != "logon") {
    ?>
                <a href="signin.php">
                    <button type="button" class="btn btn-danger navbar-btn pull-right">เข้าสู่ระบบ</button>
                </a>
                <?php
} else {
    ?>
                    <p class="navbar-text pull-right">ยินดีต้อนรับคุณ
                        <a href="view-profile.php" title="ข้อมูลส่วนตัว"><?=$_SESSION['profile_detail']['firstname'] . " " . $_SESSION['profile_detail']['lastname'];?></a> | <a href="signout.php" onclick="return confirm('ยืนยันการออกจากระบบ ?');">ออกจากระบบ</a></p>
                    <?php
}
?>
        </div>
    </nav>
</header>
