<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'mysql';
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

    public function logIn($email, $password)
    {
        // Escape inputs to prevent SQL injection
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);

        // Retrieve user data from database
        $sql = "SELECT * FROM Users WHERE Email = '$email'";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) != 0) {
            // Verify password
            if (password_verify($password, $row['Password'])) {
                // Set session variables
                $_SESSION['UserID'] = $row['UserID'];
                $login = true;
            } else {
                $login = false;
                return "Wrong password"; // Incorrect password
            }
        } else {
            $login = false;
            return "Email not found"; // Email does not exist
        }
        return $login;
    }

    // ADMIN ACCESS FUNCTION

    public function admin_access($id)
    {
        // Escape inputs to prevent SQL injection
        $id = mysqli_real_escape_string($this->conn, $id);

        // Retrieve user data from database
        $sql = "SELECT * FROM Users WHERE UserID = '$id'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            return "User not found"; // User ID does not exist in the database
        }

        $row = mysqli_fetch_assoc($result);
        $correctRole = 'admin';

        // Verify user role
        if ($row['Role'] == $correctRole) {
            return true; // User has admin access
        }

        return "Insufficient privileges"; // User does not have admin access
    }

    // LANDLORD ACCESS FUNCTION

    public function landlord_access($id)
    {
        // Escape inputs to prevent SQL injection
        $id = mysqli_real_escape_string($this->conn, $id);

        // Retrieve user data from database
        $sql = "SELECT * FROM Users WHERE UserID = '$id'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            return "User not found"; // User ID does not exist in the database
        }

        $row = mysqli_fetch_assoc($result);
        $correctRole = 'landloard';

        // Verify user role
        if ($row['Role'] == $correctRole) {
            return true; // User has admin access
        }

        return "Insufficient privileges"; // User does not have admin access
    }

    // WARDEN ACCESS FUNCTION

    public function warden_access($id)
    {
        // Escape inputs to prevent SQL injection
        $id = mysqli_real_escape_string($this->conn, $id);

        // Retrieve user data from database
        $sql = "SELECT * FROM Users WHERE UserID = '$id'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            return "User not found"; // User ID does not exist in the database
        }

        $row = mysqli_fetch_assoc($result);
        $correctRole = 'warden';

        // Verify user role
        if ($row['Role'] == $correctRole) {
            return true; // User has admin access
        }

        return "Insufficient privileges"; // User does not have admin access
    }

    // STUDENT ACCESS FUNCTION

    public function student_access($id)
    {
        // Escape inputs to prevent SQL injection
        $id = mysqli_real_escape_string($this->conn, $id);

        // Retrieve user data from database
        $sql = "SELECT * FROM Users WHERE UserID = '$id'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            return "User not found"; // User ID does not exist in the database
        }

        $row = mysqli_fetch_assoc($result);
        $correctRole = 'student';

        // Verify user role
        if ($row['Role'] == $correctRole) {
            return true; // User has admin access
        }

        return "Insufficient privileges"; // User does not have admin access
    }


    public function closeConnection()
    {
        mysqli_close($this->conn);
    }
    // Function to logout
    function logout()
    {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header("Location: login.php");
        exit();
    }
    // Check if the logout button is clicked
    function Logoutbutton()
    {
        // Check if the logout button is clicked
        if (isset($_POST['logout'])) {
            $this->logout();
        }
    }
    function checkLogout()
    {
        // Destroy session if the timeout is reached
        if (isset($_SESSION['timeout']) && time() > $_SESSION['timeout']) {
            $this->logout();
        }
    }
}

$database = new DataBase();
$database->checkLogout();
