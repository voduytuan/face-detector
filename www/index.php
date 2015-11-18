<?php

ini_set('display_errors', 1);
set_time_limit(300);

define('MAX_IMAGE_SIZE', 5 * 1024 * 1024);
define('FACECOUNT_HAARCASCADE_XML', 'haarcascade_profileface.xml');
define('FACEDETECT_HAARCASCADE_XML', 'haarcascade_profileface.xml');

// Get action from url
$action = '';
if (isset($_GET['action']) && $_GET['action'] != '') {
    $action = $_GET['action'];
}

switch ($action) {
    case 'count':
        doCount();
        break;
    case 'crop':
        doCrop();
        break;
    default:
        doDetect();
}

/**
 * Count all faces in uploaded photo
 */
function doCount()
{
    $success = false;
    $message = '';
    $count = 0;


    if (fileValidate($filepath, $error)) {
        $success = true;
        $count = face_count($filepath, 'opencv-2.4.10-haarcascades/' . FACECOUNT_HAARCASCADE_XML);

    } else {
        $message = $error;
    }

    $jsonData = array(
        'success' => $success,
        'message' => $message,
        'count' => $count
    );

    header('Content-type: application/json');
    echo json_encode($jsonData);
}

/**
 * smart crop photo to square ratio with focus on main faces
 */
function doCrop()
{
    if (fileValidate($filepath, $error)) {
        $success = true;
        $faces = face_detect($filepath, 'opencv-2.4.10-haarcascades/' . FACEDETECT_HAARCASCADE_XML);

        //Check if found face, need to crop
        if (!empty($faces)) {

            echo 'Now, Crop it!';

        } else {
            header('HTTP/1.1 422 Unprocessable Entity', true, 422);
            echo 'There is no face in uploaded image.';
        }
    } else {
        header('HTTP/1.1 422 Unprocessable Entity', true, 422);
        echo $message;
    }
}

/**
 * Return all faces information in uploaded photo
 */
function doDetect()
{
    $success = false;
    $message = '';
    $faces = array();


    if (fileValidate($filepath, $error)) {
        $success = true;
        $faces = face_detect($filepath, 'opencv-2.4.10-haarcascades/' . FACEDETECT_HAARCASCADE_XML);

    } else {
        $message = $error;
    }

    $jsonData = array(
        'success' => $success,
        'message' => $message,
        'faces' => $faces
    );

    header('Content-type: application/json');
    echo json_encode($jsonData);
}

/**
 * Validate uploaded image
 */
function fileValidate(&$filepath, &$error)
{
    $pass = true;

    if (empty($_FILES) || empty($_FILES['image'])) {
        $pass = false;
        $error = 'Image is required.';

    } else {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if ($ext != 'jpg') {
            $pass = false;
            $error = 'Image must be in JPG format.';

        } elseif ($_FILES['image']['size'] > MAX_IMAGE_SIZE) {
            $pass = false;
            $error = 'Image is too big, must be under '.MAX_IMAGE_SIZE.' bytes.';

        } else {
            $filepath = $_FILES['image']['tmp_name'];
        }
    }

    return $pass;
}
