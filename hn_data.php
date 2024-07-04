<?php

function callApiAndDisplay($hn) {
 
    $apiUrl = 'http://61.19.25.200/api/pmk/get_data/';


    $curl = curl_init();


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
            'fnc' => 'patients_opd_ipd',
            'hn' => $hn, 
        )),
    ));

    $response = curl_exec($curl);


    curl_close($curl);

    
    $responseData = json_decode($response, true);


    if ($responseData && is_array($responseData)) {
        echo "<h2>Data for HN: {$hn}</h2>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        foreach ($responseData as $data) {
            echo "<tr><td>ID Card</td><td>{$data['id_card']}</td></tr>";
            echo "<tr><td>Full Name</td><td>{$data['flname']}</td></tr>";
            echo "<tr><td>Birth Date</td><td>{$data['bdate']}</td></tr>";
            echo "<tr><td>Address</td><td>{$data['hname']}</td></tr>";
            echo "<tr><td>Credit</td><td>{$data['credit']}</td></tr>";
            echo "<tr><td>Blood Group</td><td>{$data['bgname']}</td></tr>";
            echo "<tr><td>Age (Years)</td><td>{$data['age_year']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data available for HN: {$hn}</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['hn'])) {
        $hn = $_GET['hn'];

        // เรียก API 
        callApiAndDisplay($hn);
    } else {
        echo "<p>No HN provided.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HN Data</title>
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

<div>
    <a href="index.php">Back to Index</a>
</div>

</body>
</html>
