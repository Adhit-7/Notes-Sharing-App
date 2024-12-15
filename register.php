<?php

@include 'config.php';

if(isset($_POST['submit'])){

    $username = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $user_type = $_POST['role'];

    $select = "SELECT *FROM user_form WHERE email = '$email' && password = '$pass'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result)> 0){
        $error[] = 'user already exist';
    }
    else{
        if($pass != $cpass){
            $error[] = 'Password not matched'; 
        }
        else{
            $insert = "INSERT INTO user_form(username,email,password,user_type) VALUES('$username','$email','$pass','$user_type')";
            mysqli_query($conn,$insert);
            header('location:login.php');
        }
    }
    session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];

}
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="img">
        <img src="assets/Figma_Bg.png">
    </div>
    <div class="container">
        <h1>Register</h1>

    <?php

    if(isset($error)){
        foreach($error as $error){
        echo '<span class = "error-msg">'.$error.'</span>';
    };
};

    ?>
        <form action="" method="POST" id="RegisterForm">

            <label for="name">Username</label>
            <input type="name" id="name" name="name" placeholder="Enter your Name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="cpassword">Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm password" required>

            <label for="role">Select your role</label>
            <select id="role" name="role"  required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
            <a href="login.php">Already have an account?</a>
            <button type="submit" name="submit">Register</button>
    </form>
    </div>

    <script src="login.js"></script>
</body>
</html>
