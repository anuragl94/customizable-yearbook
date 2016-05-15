<?php
/**
 * Single page view for a student
 *
 * @author anurag
 */
$student = explode("/", $_SERVER['REQUEST_URI'])[2];    // The unique username/url for that student
$content = json_decode(file_get_contents("../data/" . $student . "/content.json"));
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Yearbook | <?= $content->name ?></title>
        <link rel="stylesheet" href="/static/css/lib/bootstrap.min.css">
        <link rel="stylesheet" href="/static/css/yearbook.css">
        <!--The following line is the custom CSS for each student-->
        <link rel="stylesheet" href="/resources/<?= $student ?>/stylesheet">
    </head>

    <body>
        <div class="single-page">
            <div id="student-profile-picture">
                <img src="/resources/<?= $student ?>/photo">
            </div>
            <div id="student-name"><?= $content->name ?></div>
            <div id="student-quote"><?= $content->quote ?></div>
            <div id="student-about"><?= $content->about ?></div>
            <div id="student-social-links">
                <?php
                foreach ($content->links as $domain => $link) {
                    echo "<a href=$link data-domain=$domain>$domain</a>";
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