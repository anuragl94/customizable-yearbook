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
    file_put_contents('../updates.log', "[" . date("G:i - d M, Y") . "] " . $_SESSION['usn'] . " updated profile\n", FILE_APPEND);
    print_r(json_encode(array(
        "status" => "success",
        "message" => "Data has been updated"
    )));
} else {
    if (!isset($_SESSION['usn'])) {
        print_r(json_encode(array(
            "status" => "error",
            "message" => "You must be logged in for this"
        )));
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
            <link rel="stylesheet" href="/static/css/themes/theme1.css">
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

            <div class="templates">
                <!--Just a normal alert-->
                <div id="alert" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
                        </div>
                    </div>
                </div>
                <!--Takes an input text-->
                <div id="prompt-text" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary accept" data-dismiss="modal">Accept</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
                <!--Takes input text for larger content-->
                <div id="prompt-textarea" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <textarea></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary accept" data-dismiss="modal">Accept</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="toolbar">
                <a id="save-changes">Save</a>
            </div>

            <script src="/static/js/lib/jquery-2.1.1.js"></script>
            <script src="/static/js/lib/jquery-ui-1.10.4.min.js"></script>
            <script src="/static/js/lib/bootstrap.min.js"></script>
            <script src="/static/js/theme2.js"></script>
            <script src="/static/js/yearbook.js"></script>
        </body>
    </html>
    <?php
}
?>