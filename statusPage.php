<?php
  class StatusPage {
    const STATUS_PAGE_URL = "https://api.statuspage.io/v1/pages/xnsxlfgbqz6k/components.json";

    private $authorizationHeader;
    private $rawResult;
    private $jsonResult;

    public function __construct($authorizationHeader) {
      $this->authorizationHeader = $authorizationHeader;
    }

    public function rawResult() {
      if (!$this->rawResult) {
        $options = array(
          'http' => array(
            'method' => "GET",
            'header' => "Authorization: " . $this->authorizationHeader
          )
        );

        $context = stream_context_create($options);
        $this->rawResult = file_get_contents(self::STATUS_PAGE_URL, false, $context);
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
