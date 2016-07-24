<?php
require('config.inc.php');
require('serverStatus.php');
require('statusPage.php');

$serverStatus = new ServerStatus(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE_NAME);
$statusPage = new StatusPage(STATUSPAGE_AUTHORIZATION_HEADER);

foreach ($statusPage->jsonResult() as $statusPageItem) {
  $serverStatus->setServerStatus($statusPageItem["name"], $statusPageItem["status"]);
}
?>
