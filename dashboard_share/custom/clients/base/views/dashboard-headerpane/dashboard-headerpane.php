<?php
require "clients/base/views/dashboard-headerpane/dashboard-headerpane.php";
$viewdefs["base"]["view"]["dashboard-headerpane"]["panels"][0]["fields"] =  array(
    array(
        'name' => 'sidebar_toggle_both',
        'type' => 'sidebartoggle-both',
        'span' => 2,
    ),
    array(
        "type" => "dashboardtitle",
        "name" => "name",
        "placeholder" => "LBL_DASHBOARD_TITLE",
        'span' => 6,
    ),
    array(
        "type" => "layoutbutton",
        "name" => "layout",
    ),
);
