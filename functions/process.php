<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'edustay';
    public $conn;

    public function __construct()
    {
        $this->conn = $this->dbConnect();
    }

    public function dbConnect()
    {
        $conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
    public function signUp($role, $email, $password, $firstname, $lastname)
    {
        // Escape inputs to prevent SQL injection
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        $firstname = mysqli_real_escape_string($this->conn, $firstname);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);

        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $sql = "SELECT * FROM Users WHERE Email = '$email'";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return "The email already exists";
        }

        // Insert new user if email does not exist
        $sql = "INSERT INTO Users (Email, Password, FirstName, LastName, Role) VALUES ('$email', '$password', '$firstname', '$lastname', '$role')";
        if (mysqli_query($this->conn, $sql)) {
            return true;
        } else {
            return "Error: " . mysqli_error($this->conn);
        }
    }



    public function closeConnection()
    {
        mysqli_close($this->conn);
    }
}



?>

