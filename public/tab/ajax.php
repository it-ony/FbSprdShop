<?php
session_start();

set_include_path("..");

include "config.php";

require_once "lib/sprd/controller/SetupController.php";
require_once "lib/sprd/model/Tab.php";
require_once "lib/sprd/model/Page.php";

$controller = new SetupController($GLOBALS["APP"]);
if (!$controller->handleRequest()) {
    header('HTTP/1.1 403 Forbidden');
}

?>