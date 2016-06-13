<?php

session_start();

if (isset($_SESSION['usn'])) {
    session_destroy();
    print_r(array(
        "status" => "success",
        "message" => "Logged out successfully"
    ));
} else {
    print_r(array(
        "status" => "error",
        "message" => "Already logged out"
    ));
}
?>