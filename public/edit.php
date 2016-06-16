<?php
session_start();

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {
    if (!isset($_SESSION['usn'])) {
        print_r("You must be logged in for this");
        header("Location: /login.php");
    }
    $student = $_SESSION['url'];
    $content = json_decode(file_get_contents("../data/" . $student . "/content.json"), true);
    // Now update all the fields that have been sent as params
    $params = [];
    $params['name'] = isset($_POST['name']) ? filter_input(INPUT_POST, 'name') : NULL;
    $params['quote'] = isset($_POST['quote']) ? filter_input(INPUT_POST, 'quote') : NULL;
    $params['about'] = isset($_POST['about']) ? filter_input(INPUT_POST, 'about') : NULL;

    foreach ($params as $key => $value) {
        if (!is_null($value)) {
            $content[$key] = $value;
        }
    }

    file_put_contents("../data/" . $student . "/content.json", json_encode($content));
    file_put_contents('../updates.log', $_SESSION['usn'] . " updated profile", FILE_APPEND);
    print_r(array(
        "status" => "success",
        "message" => "Data has been updated"
    ));
} else {
    if (!isset($_SESSION['usn'])) {
        print_r(array(
            "status" => "error",
            "message" => "You must be logged in for this"
        ));
        die();
    }
    $student = $_SESSION['url'];
    $content = json_decode(file_get_contents("../data/" . $student . "/content.json"));
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Yearbook | Your profile</title>
            <link rel="stylesheet" href="/static/css/lib/bootstrap.min.css">
            <link rel="stylesheet" href="/static/css/yearbook.css">
            <!--The following line is the custom CSS for each student-->
            <link rel="stylesheet" href="/resources/<?= $student ?>/stylesheet">
        </head>

        <body>
            <div class="single-page">
                <div class="group">
                    <div id="student-profile-picture" class="editable">
                        <img src="/resources/<?= $student ?>/photo">
                    </div>
                    <div id="student-name" class="editable"><?= $content->name ?></div>
                </div>
                <div id="student-quote" class="editable"><?= $content->quote ?></div>
                <div id="student-about" class="editable"><?= $content->about ?></div>
                <div id="student-social-links" class="editable">
                    <?php
                    foreach ($content->links as $domain => $link) {
                        echo "<a>$domain</a>";
                    }
                    ?>
                </div>
            </div>

            <script src="/static/js/lib/jquery-2.1.1.js"></script>
            <script src="/static/js/lib/jquery-ui-1.10.4.min.js"></script>
            <script src="/static/js/lib/bootstrap.min.js"></script>
            <script src="/static/js/yearbook.js"></script>
        </body>
    </html>
    <?php
}
?>