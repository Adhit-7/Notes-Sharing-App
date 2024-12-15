<?php
@include 'config.php';
session_start();               //storing user data 

if(isset($_POST['submit'])){                
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = $_POST['password'];
    $user_type = $_POST['role'];

    $select = "SELECT * FROM user_form WHERE (username = '$username_email' OR email = '$username_email') AND password = '$password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        
        if($row['user_type'] == 'admin' && $user_type == 'admin') {
           
            header('Location: admin_page.php');
            exit; 
        }
        elseif($row['user_type'] == 'student' && $user_type == 'student') {
            
            $_SESSION['student_email'] = $row['email'];
            header('Location: student_page.php');
            exit;
        } 
        elseif($row['user_type'] == 'teacher' && $user_type == 'teacher') {
    
            $_SESSION['teacher_email'] = $row['email'];
            header('Location: teacher_page.php');
            exit;
        } 
        else {
            
            $error[] = 'User not found';
        }
    } 
    else {
        $error[] = 'Incorrect username or email or password';
    }

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Check if form is submitted
       
        $_SESSION['username_email'] = $_POST['username_email'];     // Store form data in session variable.
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="img">
        <img src="assets/Figma_Bg.png">
    </div>
    
    <div class="container">
        <h1>Log in</h1>
    <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
    ?>

    <form action="" method="POST" id="loginForm">
        <label for="username_email">Username or Email</label>
        <input type="text" id="username_email" name="username_email" placeholder="Enter your Username or Email" value="<?php echo isset($_SESSION['username_email']) ? $_SESSION['username_email'] : ''; ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <label for="role">Select your role</label>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>
        
        <a href="register.php">Don't have an account?</a>
        <button type="submit" name="submit">Login</button>
    </form>
    </div>
</body>
</html>
