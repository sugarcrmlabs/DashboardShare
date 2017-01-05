<?php
require "modules/Home/clients/base/views/dashboard-headerpane/dashboard-headerpane.php";
$viewdefs["Home"]["base"]["view"]["dashboard-headerpane"]["buttons"][0]["buttons"][] =
    array(
        "name" => "share_button",
        "type" => "rowaction",
        "label" => "LBL_DASHBOARD_SHARE",
    );