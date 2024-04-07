<?php
class Database
{
    public $servername;
    public $username;
    public $password;
    public $databasename;

    public function __construct()
    {

        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = 'mysql';
        $this->databasename = 'edustay';

    }
}
?>