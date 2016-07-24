<?php
  class ServerStatus {
    private $connection;

    public function __construct($host, $username, $password, $databaseName) {
      $this->connection = new mysqli($host, $username, $password, $databaseName);

      if (mysqli_connect_error()) {
			  trigger_error("Failed to connect to MySQL: " . mysql_connect_error(), E_USER_ERROR);
		  }
    }

    public function getServerStatus($name) {
      $statement = $this->connection->prepare("SELECT status FROM server_statuses WHERE name = ?");
      $statement->bind_param('s', $name);

      if ($statement->execute()) {
        return $statement->get_result()->fetch_assoc()["status"];
      } else {
        return false;
      }
    }

    public function setServerStatus($name, $status) {
      $statement = $this->connection->prepare("SELECT status FROM server_statuses WHERE name = ?");
      $statement->bind_param('s', $name);
      $statement->execute();

      $result = $statement->get_result();

      if ($result->num_rows == 0) {
        $insertStatement = $this->connection->prepare("INSERT INTO server_statuses (name, status) VALUES (?, ?)");
        $insertStatement->bind_param('ss', $name, $status);
        return $insertStatement->execute();
      } else {
        $updateStatement = $this->connection->prepare("UPDATE server_statuses SET status = ? WHERE name = ?");
        $updateStatement->bind_param('ss', $status, $name);
        return $updateStatement->execute();
      }
    }
  }
?>
