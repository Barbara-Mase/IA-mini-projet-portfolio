<?php
abstract class AbstractManager{
    
    
   protected PDO $db;

    public function __construct()
    {
      
        $host = "db.3wa.io";
        $port = "3306";
        //à compléter
        $dbname = "barbaramase";

        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = "barbaramase";
        $password = "a00b6c174df6836deabe8330debe5e49";

        $this->db = new PDO(
            $connexionString,
            $user,
            $password
            );
    } 
 
}
?>