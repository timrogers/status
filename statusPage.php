<?php
  class StatusPage {
    private $apiUrl;
    private $authorizationHeader;
    private $rawResult;
    private $jsonResult;

    public function __construct($apiUrl, $authorizationHeader) {
      $this->apiUrl = $apiUrl;
      $this->authorizationHeader = $authorizationHeader;
    }

    // Fetches StatusPage.io statuses fro each server from their API using the provided
    // URL and Authorization header value
    public function rawResult() {
      if (!$this->rawResult) {
        $options = array(
          'http' => array(
            'method' => "GET",
            'header' => "Authorization: " . $this->authorizationHeader
          )
        );

        $context = stream_context_create($options);
        $this->rawResult = file_get_contents($this->apiUrl, false, $context);
      }

      return $this->rawResult;
    }

    public function jsonResult() {
      if (!$this->jsonResult) {
        $this->jsonResult = json_decode($this->rawResult(), true);
      }

      return $this->jsonResult;
    }


  }
?>
