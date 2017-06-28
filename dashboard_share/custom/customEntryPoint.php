<?php
if (!empty($_GET['dashId'])) {
    $updateQuery = "UPDATE dashboards SET deleted = 0 WHERE id = '" . $GLOBALS['db']->quote($_GET['dashId']) . "'";

    if ($GLOBALS['db']->query($updateQuery)) {
        echo "The dashboard was successfully accepted.";
    } else {
        echo "There was an error please try again later.";
    }
} else {
    echo "Please provide the dashboard's ID.";
}
