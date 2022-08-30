<?php 

class Dbh {

    protected function connect() { 
        try {
            // Replace the variables values with your database details
            $serverName = 'localhost'; // Server Name
            $dbUsername = 'root'; // Database Username
            $dbPassword = ''; // Database Password
            $dbName = 'login'; // Database Name

            $dbh = new PDO('mysql:host=' . $serverName . ';dbname=' . $dbName, $dbUsername, $dbPassword);
            return $dbh;
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }

}