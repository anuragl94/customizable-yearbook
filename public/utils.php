<?php

/**
 * Utility functions
 *
 * @author anurag
 */
$url_parts = explode("/", $_SERVER['REQUEST_URI']);
$student = $url_parts[2];
$resource = $url_parts[3];
$dataFolder = "../data/" . $student;
$content = json_decode(file_get_contents($dataFolder . "/content.json"));

$function = "get" . ucfirst($resource);
if (is_callable($function, false)) {
    $function($dataFolder, $content);
} else {
    // User requested a resource that is not served
    echo "Hmm, this is probably not something I can show you.";
}

function getPhoto($dataFolder, $content) {
    header('Content-type: image/png');
    readfile($dataFolder . "/" . $content->photo);
}

function getStylesheet($dataFolder, $content) {
    header('Content-type: text/css');
    readfile($dataFolder . "/style.css");
}

function getData($dataFolder, $content) {
    header('Content-type: application/json');
    print_r(json_encode($content));
}

?>