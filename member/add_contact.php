<?php require_once 'secure.php'; ?>
<?php
    function get_file_name($file_name){
        $str1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $str = str_shuffle($str1);
        $name = substr($str, 0,20);
        $i = strpos($file_name, '.');
        $ext_name = substr($file_name, $i);
        return $name.$ext_name;
    }
    $status = 0;
    if(isset($_POST['submit'])){
        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $mobile_number = $_POST['mobile_number'];
        $city = $_POST['city'];
        $dob = $_POST['date_of_birth'];
        $d = strtotime($dob);
        $date_of_birth = date('Y-m-d', $d);
        $file_name = $_FILES['photo']['name'];
        $photo = get_file_name($file_name);
        $tmp_location = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp_location, 'photos/'.$photo);
        $query = "insert into contacts(name,gender,email,mobile_number,city,date_of_birth,photo,user_id) values('$name','$gender','$email','$mobile_number','$city','$date_of_birth','$photo',$user_id)";    
        require_once '../db/db_settings.php';
        $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
        if(mysqli_query($db, $query)){
            header('Location: index.php');
        }else{
            $status=1;
        }
        mysqli_close($db);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Simplypink by TEMPLATED</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="../css/default.css" rel="stylesheet" type="text/css" />
        <link href="../css/base/jquery-ui-1.9.2.custom.css" rel="stylesheet">
        <script src="../js/jquery-1.8.3.js"></script>
        <script src="../js/jquery-ui-1.9.2.custom.js"></script>
        <script>
            $(function () {
                $("#datepicker").datepicker({
                    inline: true, changeMonth: true, changeYear: true, yearRange: '1970:2018', dateFormat: 'd-M-yy'
                });
            });
        </script>
        <style>
            td{
                padding: 10px;
            }
            .center{
                text-align: center;
            }
        </style>        
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <form action="add_contact.php" method="POST" enctype="multipart/form-data">
                <table>
                    <tbody>
                        <tr>
                            <td>Name : </td>
                            <td><input type="text" name="name" value="" /></td>
                        </tr>
                        <tr>
                            <td>Gender : </td>
                            <td>
                                <input type="radio" name="gender" value="Male" checked="checked" />Male
                                <input type="radio" name="gender" value="Female" />Female
                            </td>
                        </tr>
                        <tr>
                            <td>Email : </td>
                            <td><input type="text" name="email" value="" /></td>
                        </tr>
                        <tr>
                            <td>Mobile Number : </td>
                            <td><input type="text" name="mobile_number" value="" /></td>
                        </tr>
                        <tr>
                            <td>City : </td>
                            <td><input type="text" name="city" value="" /></td>
                        </tr>
                        <tr>
                            <td>Date Of Birth : </td>
                            <td><input readonly type="text" name="date_of_birth" id="datepicker" required /></td>
                        </tr>
                        <tr>
                            <td>Photo : </td>
                            <td><input type="file" name="photo" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <input type="submit" value="Save Contact" name="submit" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php if($status==1) { ?>
            <h2>Some Error occurred</h2>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
