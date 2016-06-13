<?php

function database_query($query) {
    require_once 'config.php';
    $db = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($db->connect_errno > 0) {
        print_r(array(
            "status" => "error",
            "message" => "Unable to connect to database [" . $db->connect_error . "]"
        ));
        return FALSE;
    }
    $results = $db->query($query);
    $db->close();
    return($results);
}

?>
