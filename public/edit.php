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
                <form action="edit.php" method="POST">
                    <div id="student-profile-picture">
                        <img src="/resources/<?= $student ?>/photo">
                    </div>
                    <input id="student-name" name="name" value="<?= $content->name ?>" />
                    <br>
                    <textarea id="student-quote" name="quote"><?= $content->quote ?></textarea>
                    <br>
                    <textarea id="student-about" name="about"><?= $content->about ?></textarea>
                    <div id="student-social-links">
                        <?php
                        foreach ($content->links as $domain => $link) {
                            echo "<a href=$link data-domain=$domain>$domain</a>";
                        }
                        ?>
                    </div>
                    <br>
                    <input type="submit" value="Save"/>
                </form>
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