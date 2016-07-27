<?php
require('config.inc.php');
require('ServerStatus.php');
require('StatusPage.php');

$serverStatus = new ServerStatus(STATUS_MYSQL_HOST, STATUS_MYSQL_USERNAME, STATUS_MYSQL_PASSWORD, STATUS_MYSQL_DATABASE_NAME);
$statusPage = new StatusPage(STATUS_STATUSPAGE_API_URL, STATUS_STATUSPAGE_AUTHORIZATION_HEADER);

foreach ($statusPage->jsonResult() as $statusPageItem) {
  $serverStatus->setServerStatus($statusPageItem["name"], $statusPageItem["status"]);
}
?>
