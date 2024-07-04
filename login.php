
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
