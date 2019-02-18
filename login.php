<?php
    $email = '';
    $password = '';
    $status = 0;
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $passwd = sha1($_POST['password']);    
        require_once 'db/db_settings.php';
        $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
        $query = "select * from users where email='$email' and password='$passwd'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==0){
            $status = 1;
        }else{
            $row = mysqli_fetch_array($result);
            if($row['active']==0){
                $status=2;
            }
            else{
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                if($row['role']=='member'){
                    header('Location: member/');
                }else if($row['role']=='admin'){
                    header('Location: admin/');
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Simplypink by TEMPLATED</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="css/default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <h2>Login Page</h2>
            <form action="login.php" method="POST">
                <table>
                    <tbody>
                        <tr>
                            <td>Email Id : </td>
                            <td><input type="text" name="email" value="ndhagarra@gmail.com" /></td>
                        </tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" name="password" value="abc#123" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Login" name="submit" />
                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>
            <h3><a href="forgot_password.php">Forgot Password</a></h3>
            <?php if($status==1) { ?>
            <h3 style="color:red">Email ID / Password is Incorrect</h3>
            <?php } ?>
            <?php if($status==2) { ?>
            <h3 style="color:red">Your Email ID has not been verified yet.</h3>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
