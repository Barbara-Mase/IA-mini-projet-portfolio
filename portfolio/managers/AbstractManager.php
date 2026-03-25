<?php
abstract class AbstractManager{
    
    
   protected PDO $pdo;

    public function __construct()
    {
      
        $host = "db.3wa.io";
        $port = "3306";
        //à compléter
        $dbname = "barbaramase";

        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = "barbaramase_ia_portfolio";
        $password = "a00b6c174df6836deabe8330debe5e49";

        $this->pdo = new PDO(
            $connexionString,
            $user,
            $password
            );
    } 
 
}
?>