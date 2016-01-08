<?php
session_start();
if (!isset($_GET['hospital_id'])) {
    header("Location: index.php");
    exit;
}
include 'php/config/autoload.inc.php';
use classes as cls;
use config as cfg;

$db = new cfg\database;
$ht = new cls\hospitals;
$pv = new cls\provinces;

$data = $ht->get_hospital_detail_by_id($_GET['hospital_id']);
// print_r($data);
$province = $pv->get_province($data['province']);
$amphur = $pv->get_amphur($data['amphur']);
$district = $pv->get_district($data['district']);

/*
Array
(
[hospital_id] => 1
[hospital_verify_code] => กก11021จ
[hospital_name] => ค่ายสรรพสิทธิประสงค์
[hospital_address] => 383 หมู่ 2 ถ.สถิตย์นิมานกาล
[province] => 1
[amphur] => 4
[district] => 31
[zipcode] => 34190
[lat] => 15.1939973
[lng] => 104.8732654
[tel] => 045-3211735
[email] => thongtank@hotmail.com
[date_added] => 2015-10-27 23:08:49
)
 */
$address = $data['hospital_address'] . " อำเภอ" . $amphur[0]['AMPHUR_NAME'] . " ตำบล" . $district[0]['DISTRICT_NAME'] . " จังหวัด" . $province[0]['PROVINCE_NAME'] . $data['zipcode'];
// echo $address;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>
            <?=$data['hospital_name'];?>
        </title>
        <script type="text/javascript">
        function initMap() {
            var positions = [{
                lat: <?php echo $data["lat"]; ?>,
                lng: <?php echo $data["lng"]; ?>,
                title: '<?php echo $data["hospital_name"]; ?>',
                detail: '<?php echo $data["hospital_name"]; ?>',
                address: '<?php echo $address; ?>'
            }];
            var map;
            var $div = document.getElementById('map');
            map = new google.maps.Map($div, {
                zoom: 16,
                center: {
                    lat: <?php echo $data['lat']; ?>,
                    lng: <?php echo $data['lng']; ?>,
                },
                mapTyleId: google.maps.MapTypeId.ROADMAP
            });

            console.log(map.getCenter().lat());
            // Create LatLng Class
            // var latLng = new google.maps.LatLng(lat, lng);
            var marker;
            $.each(positions, function(index, val) {
                marker = createmarker(val.lat, val.lng, map, val.title, val.detail, val.address);
                marker.setMap(map);
            });
        }

        function createmarker(lat, lng, map, title, detail, address) {
            // console.log(title);
            var marker = new google.maps.Marker({
                position: {
                    lat: lat,
                    lng: lng
                },
                title: title
            });
            var info = new google.maps.InfoWindow({
                content: '<div class="col-md-12 text-center"><strong>' + detail + '</strong></div><div class="col-md-12 text-center">' + address + '</div>'
            });

            marker.addListener('click', function() {
                info.open(map, marker);
            });

            return marker;
        }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArNDS9don3Y-aywBRd-1GgMW7NAGiL6_o&callback=initMap">
        </script>
        <style type="text/css">
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 50%;
        }
        </style>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
    </head>

    <body>
        <?php include 'header.php';?>
            <div id="map"></div>
            <article class="container">
                <section class="header">
                    <hgroup>
                        <h1><strong><?=$data['hospital_name'];?></strong></h1>
                        <h3><?=$address;?></h3>
                        <h3>โทร. <?=$data['tel'];?></h3>
                        <h3>อีเมล์ <?=$data['email'];?></h3>
                    </hgroup>
                </section>
                <section>
                    <h1><strong>ความชำนาญการพิเศษของโรงพยาบาล</strong></h1>
                    <?php
$rows = $ht->get_special_by_hospital_id($_GET['hospital_id']);
if ($rows !== false) {
    $i = 1;
    if (count($rows) > 0) {
        $arr_medical_name = array();
        foreach ($rows as $k => $v) {
            if (in_array($v['medical_name'], $arr_medical_name)) {

            } else {
                array_push($arr_medical_name, $v['medical_name']);
                print "<h3>" . $i . ". " . $v['medical_name'] . "</h3>";
                $i++;
            }
        }
    } else {
        print "<H3>ไม่มีข้อมูล</H3>";
    }
}
?>
                        <h1><strong>คะแนนเฉลี่ยความพึงพอใจ</strong></h1>
                        <h3><?php
$rate = $ht->get_rating_by_hospital_id($_GET['hospital_id']);
echo $rate['word'] . " ( " . round($rate['score'], 2) . " คะแนน )";
?></h3>
                </section>
                <?php if (!isset($_GET['do'])) {
    ?>
                <section>
                    <h1><strong>รายะละเอียดการรักษา</strong></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รพ.</th>
                                        <th>อาการ</th>
                                        <th>ประเภทการรักษา</th>
                                        <th>ค่ารักษา</th>
                                        <th>ความพึงพอใจ</th>
                                        <th>วัน / เวลา</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$ex = explode("GROUP", $_SESSION['paging_sql']);
// print($ex[0]);
    $rows = $ht->get_medical_by_sql($ex[0]);
    $i = 1;
    foreach ($rows as $key => $value) {
        if ($value['hospital_id'] == $_GET['hospital_id']) {
            print "
<tr>
                            <td>" . $i . "</td>
                            <td>" . trim($ht->get_hospital_detail_by_id($value['hospital_id'])['hospital_name']) . "</td>
                            <td>" . trim($value['organ']) . "</td>
                            <td>" . trim($ht->get_medical_by_id($value['medical_type_id'])['medical_name']) . "</td>
                            <td>" . trim(number_format(round($value['cost'], 2))) . "</td>
                            <td>" . trim(round($value['rating'], 2)) . "</td>
                            <td>" . $value['date_added'] . "</td>
                        </tr>
    ";
            $i++;
        }
    }
    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <?php }
?>
            </article>
            <?php include 'footer.php';?>
                <script src="js/jquery-1.11.3.min.js"></script>
                <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
                <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="js/__jquery.tablesorter/jquery.tablesorter.min.js"></script>
                <script>
                    $(function(){
                        $(".table")
                        .tablesorter({});
                    });
                </script>
    </body>

    </html>
