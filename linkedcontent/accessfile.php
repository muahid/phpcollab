<?php
#Application name: PhpCollab
#Status page: 0
// no caching to keep phpCollab 2.0 behaviour
session_cache_limiter('none');		// suppress error messages for PHP version < 4.0.2
error_reporting(0);

$id = $_GET["id"];

$checkSession = "true";
include '../includes/library.php';		// starts session and writes session cache headers

$files = new \phpCollab\Files\Files();
$fileDetail = $files->getFileById($id);

// serve the requested file
include '../includes/download.php';
