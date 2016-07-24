<?php
require('config.inc.php');
require('whmcs.php');
require('serverStatus.php');
require('utils.php');

$serverStatus = new ServerStatus(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE_NAME);
$whmcs = new Whmcs(WHMCS_API_URL, WHMCS_USERNAME, WHMCS_PASSWORD);
$results = $whmcs->getClientsProducts("1");
?>
<html>
<head>
  <style>
    .alert {
        padding: 20px;
        background-color: #e74c3c;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
    }

    .alert.degraded {background-color: #f1c40f;}
    .alert.partial {background-color: #e67e22;}

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
  </style>
</head>
<body>
<?php
if ($results["result"] == "success") {
  foreach($results["products"]["product"] as $product) {
    $status = $serverStatus->getServerStatus($product["servername"]);
    $humanizedStatus = Utils::humanize($status);
?>
<div class="alert <?php echo $status; ?>">
  <span class="closebtn">&times;</span>
  <strong>Warning!</strong> There is a <?php echo $humanizedStatus; ?> alert on the server where your <?php echo $product["translated_name"]; ?> product is hosted." ?>
</div>
<?php
  }
}
?>
