<?php
// ฟังก์ชันสำหรับเรียกใช้ API และแสดงผลข้อมูลในรูปแบบตาราง HTML
function callApiAndDisplay($username, $password, $utype_value) {
    // URL ของ API endpoint
    $apiUrl = 'http://172.16.99.200/api/pmk/get_data/';


    // สร้าง cURL
    $curl = curl_init();


    // ตั้งค่า cURL
    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query(array(
            'fnc' => 'chk_utable',
            'utype' => $utype_value,
            'uname' => $username,
            'pword' => $password,
        )),
    ));


    // เรียก API และรับการตอบกลับ
    $response = curl_exec($curl);


    // ปิด cURL
    curl_close($curl);


    // แปลงการตอบกลับเป็น array
    $responseData = json_decode($response, true);


    // ตรวจสอบว่ามีข้อมูลที่ได้รับมาจาก API หรือไม่ และแสดงผลลัพธ์ในรูปแบบของตาราง HTML
    if ($responseData && is_array($responseData)) {
        echo "<h2>Data from API</h2>";
        echo "<table>";
        echo "<tr><th>Key</th><th>Value</th></tr>";
        foreach ($responseData as $key => $value) {
            echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data available from API.</p>";
    }
}


// เช็คว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $utype = $_POST['user_type'];


    // แปลงค่า utype เป็นค่าที่ถูกต้องสำหรับ API
    switch ($utype) {
        case 'doctor':
            $utype_value = 1;
            break;
        case 'staff':
            $utype_value = 2;
            break;
        default:
            $utype_value = 0;
            break;
    }


    // เรียกใช้ฟังก์ชันสำหรับเรียกใช้ API และแสดงผลข้อมูล
    callApiAndDisplay($username, $password, $utype_value);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- เปลี่ยน href ตามต้องการ -->
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
