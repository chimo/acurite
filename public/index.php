<?php

require '../private/config.php';

if (!isset($_SERVER['HTTP_SECRET']) || $_SERVER['HTTP_SECRET'] !== $config['secret']) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    exit(0);
}


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        get();
        break;
    case 'POST':
        post();
        break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        break;
}


function post() {
    if (!isset($_POST['data'])) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        exit(0);
    }

    $data = $_POST['data'];

    file_put_contents('/var/lib/acurite/data.json', $data);
}


function get() {
    $filepath = '/var/lib/acurite/data.json';

    if (file_exists($filepath) === false) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        exit(0);
    }

    $data = file_get_contents('/var/lib/acurite/data.json');

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}

