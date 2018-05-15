<?php
    namespace Framework;
    class database{
        private $servername;
        private $username;
        private $password;
        private $database;
        private $encoding;

        private $conn;

        public function __construct($servername='localhost', $username, $password, $database, $encoding)
        {
            $this->servername= $servername;
            $this->username= $username;
            $this->password= $password;
            $this->database= $database;
            $this->encoding= $encoding;

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $database);

            // Check connection
            if (!$conn) {
                throw new Exception('Connection failed: ' . mysqli_connect_error());
            }
            else {
                $this->conn = $conn;
                $this->query('SET NAMES '. $encoding);
            }
        }

        public function query($sql)
        {
            $query=mysqli_query($this->conn, $sql);
            if (!($query)) {
                throw new \Exception(mysqli_error($this->conn));
            }
            return $query;
        }

        public function insert($table, $parameters)
        {
            $indexStr=null;
            $keyStr=null;

            foreach ($parameters as $index=>$key)
            {
                $indexStr.= "$index, ";
                $keyStr.= "'$key', ";
            }

            $indexStr=rtrim($indexStr, ', ');
            $keyStr=rtrim($keyStr, ', ');

            $sql= "INSERT INTO `$table` ($indexStr) VALUES ($keyStr); ";
            $this->query($sql);
        }

        public function create_database($dbName)
        {
            $sql = "CREATE DATABASE $dbName";
            $this->query($sql);
        }

        public function table_exists($table)
        {
            $sql = "SELECT count(*) FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '{$this->database}') AND (TABLE_NAME = '$table')";
            $query= $this->query($sql);

			$row=mysqli_fetch_row($query);
			return $row[0];
        }

        public function __destruct()
        {
            mysqli_close($this->conn);
        }
    }