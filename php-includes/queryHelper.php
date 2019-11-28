<?php

    class QueryHelper
    {
        private $conn;

        public function __construct()
        {
            require_once 'connect.php';
            global $con;
            $this->conn = $con;
        }

        public function getUserCounts($userId)
        {
            $query = mysqli_query($this->conn, "SELECT * FROM tree WHERE userident='{$userId}'");

            return mysqli_fetch_array($query);
        }
    }