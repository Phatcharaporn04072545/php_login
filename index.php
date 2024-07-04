<?php
session_start();


function callApiAndDisplay($username, $password, $utype_value) {
    // API Login
    $apiUrl = 'http://172.16.99.200/api/pmk/get_data/';

  
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
            'fnc' => 'chk_utable',
            'utype' => $utype_value,
            'uname' => $username,
            'pword' => $password,
        )),
    ));

   
    $response = curl_exec($curl);

 
    curl_close($curl);

    
    $responseData = json_decode($response, true);

    
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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['hn'])) {
        $hn = $_POST['hn'];

        
        header("Location: hn_data.php?hn=" . urlencode($hn));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Adjust href as needed -->
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

<?php
if (isset($_SESSION['username'])) {
    echo "<div class='welcome-message'>Welcome, {$_SESSION['username']}!</div>";
    echo '
    <form method="post" action="">
        <div class="hn-form">
            <label for="hn">Enter HN:</label>
            <input type="text" id="hn" name="hn" required>
            <button type="submit">Submit</button>
        </div>
    </form>
    ';
} else {
    echo '
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" required>
            <option value="doctor">Doctor</option>
            <option value="staff">Staff</option>
        </select>
        <br>
        <button type="submit">Login</button>
    </form>
    ';
}
?>

</body>
</html>
