<?php
class WHMCS {
  private $whmcsUrl;
  private $username;
  private $password;

  public function __construct($whmcsUrl, $username, $password) {
    $this->whmcsUrl = $whmcsUrl;
    $this->username = $username;
    $this->password = $password;
  }

  public function getClientsProducts($clientId) {
    return $this->makeApiRequest("getclientsproducts", array('clientid' => $clientId));
  }

  private function makeApiRequest($action, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->whmcsUrl . 'includes/api.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $postfields = array(
      'username' => $this->username,
      'password' => md5($this->password),
      'action' => $action,
      'responsetype' => 'json'
    );

    $postfields = array_merge($postfields, $params);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));

    $response = curl_exec($ch);

    if (curl_error($ch)) {
      die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
    }

    curl_close($ch);

    if ($postfields["responsetype"] == "json") {
      return json_decode($response, true);
    } else {
      return $response;
    }
  }
}
?>
