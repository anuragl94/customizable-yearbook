<?php
require_once(__DIR__ . "/../Utility.php");

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {

    // Validate inputs, then establish mysql connection
    $username = isset($_POST['username']) ? filter_input(INPUT_POST, 'username') : NULL;
    $password = isset($_POST['password']) ? filter_input(INPUT_POST, 'password') : NULL;

    if (empty($username) || empty($password)) {
        print_r(array(
            "status" => "error",
            "message" => "Invalid credentials"
        ));
        die();
    }

    // MySQL connection
    $query = "select * from users where usn='" . mysql_escape_string($username) . "' and password='" . md5(mysql_escape_string($password)) . "'";

    $results = database_query($query);

    if ($results->num_rows === 0) {
        print_r(array(
            "status" => "error",
            "message" => "Login failed. USN/password mismatch"
        ));
        die();
    } else {
        session_start();
        $data = $results->fetch_assoc();
        $_SESSION['usn'] = $data['usn'];
        $_SESSION['url'] = $data['url'];
        print_r(array(
            "status" => "success",
            "message" => "Login successful"
        ));
    }
} else {
    ?>
    <html>
        <head>
            <title>Yearbook | Login</title>
        </head>
        <body>
            Login:
            <br>
            <form action='login.php' method='POST'>
                <input type='text' name='username' placeholder='Enter your USN' required />
                <br>
                <input type='password' name='password' placeholder='Enter your password' required />
                <br>
                <input type='submit' value='Login'/>
            </form>
        </body>
    </html>
    <?php
}
?>