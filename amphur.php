<?php

include 'php/config/autoload.inc.php';

use config\database as db;
$db = new db;

$sql = 'select * from amphur where AMPHUR_NAME like "%' . urldecode($_GET['term']) . '%"';
// $sql = 'select * from province';
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // printf("Rows: %d", $result->num_rows);
    // print "<BR>";
    $provinces = array();
    foreach ($rows as $key => $data) {
        $arr = array(
            'id' => trim($data['AMPHUR_ID']),
            'name' => trim($data['AMPHUR_NAME']),
        );
        array_push($provinces, $arr);
    }

    $json = json_encode($provinces);
    echo $json;
}
?>
