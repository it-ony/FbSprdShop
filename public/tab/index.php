<?php
define("INDEX", 1);
session_start();
set_include_path("..");

include "config.php";

require_once "lib/sprd/controller/TabController.php";
require_once "lib/sprd/model/Tab.php";
require_once "lib/sprd/model/Page.php";

$tabController = new TabController($GLOBALS["APP"]);
$tab = $tabController->handleRequest();

$status = $tab === null ? Tab::UNCONFIGURED : $tab->getStatus();

switch ($status) {
    case Tab::UNCONFIGURED:
        echo "unconfigured";
        break;
    case Tab::SETUP:
        $user = $tab->getUser();
        include "setup.php";
        break;
    case TAB::LIVE:
        include "live.php";
}

?>