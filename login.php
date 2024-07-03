<?php

$error = '';


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
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
<body>
    <h2>Login Form</h2>
    <form action="index.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label><input type="radio" name="user_type" value="staff" required> เจ้าหน้าที่</label><br>
        <label><input type="radio" name="user_type" value="doctor" required> แพทย์</label><br><br>
        <input name="btnLogin" type="submit" value="Login">
    </form>

    <?php
    // ตรวจสอบว่ามีข้อมูลที่ได้รับมาจาก API หรือไม่
    if (isset($responseData) && is_array($responseData)) {
        echo "<h2>Data from API</h2>";
        echo "<table>";
        echo "<tr><th>Key</th><th>Value</th></tr>";
        foreach ($responseData as $key => $value) {
            echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
