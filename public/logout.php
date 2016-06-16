<?php

session_start();

if (isset($_SESSION['usn'])) {
    session_destroy();
    print_r(json_encode(array(
        "status" => "success",
        "message" => "Logged out successfully"
    )));
} else {
    print_r(json_encode(array(
        "status" => "error",
        "message" => "Already logged out"
    )));
}
?>