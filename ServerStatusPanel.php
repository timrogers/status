<?php
require('/home/freetime/server_status/config.inc.php');
require('/home/freetime/server_status/serverStatus.php');

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\User\Client;
use WHMCS\Product\Product;
use WHMCS\View\Menu\Item;

function humanize($str) {
  $str = trim(strtolower($str));
	$str = preg_replace('/[^a-z0-9\s+]/', ' ', $str);
	return preg_replace('/\s+/', ' ', $str);
}

add_hook('ClientAreaHomepagePanels', 1, function (Item $homePagePanels) {
  $currentUser = Client::find($_SESSION['uid']);

  $serverStatus = new ServerStatus(STATUS_MYSQL_HOST, STATUS_MYSQL_USERNAME, STATUS_MYSQL_PASSWORD, STATUS_MYSQL_DATABASE_NAME);

  foreach ($currentUser->services as $service) {
    // Look up the server this service is on in tblservers, so we can grab its name
    $server = Capsule::table('tblservers')->where('id', $service->server)->first();

    // If we don't know anything about this server, just move on
    if (!$server) { continue; }

    $status = $serverStatus->getServerStatus($server->name);

    // If the server is operational, we don't need to display an alert
    if ($status == "operational") { continue; }

    $humanizedStatus = humanize($status);

    $homePagePanels->addChild('service status', array(
        'label' => 'Service Status',
        'icon' => 'fa-cloud',
        'extras' => array(
            'color' => 'blue',
        ),
        'bodyHtml' => "<p><strong>Warning!</strong> There is a " . $humanizedStatus . " alert on the server where " . $service->domain . " is hosted.</p>"
    ));
  }
});
?>
