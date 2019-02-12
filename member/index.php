<?php require_once 'secure.php'; ?>
<?php
$user_id = $_SESSION['user_id'];
require_once '../db/db_settings.php';
$db = @mysqli_connect($server, $user, $password, $database) or die('We are having some error with the Server.Please try later');
$query = "select * from contacts where user_id=$user_id order by name";
$result = mysqli_query($db, $query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Simplypink by TEMPLATED</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="../css/default.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <?php
            if (mysqli_num_rows($result) == 0) {
                ?>
                <h2>There are no contacts in your address book.</h2>
            <?php } else { ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Mobile Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                    <a href="view_contact.php?contact_id=<?php echo $row['contact_id']; ?>">
                                    <?php echo $row['name']; ?>
                                    </a>
                                </td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile_number']; ?></td>
                                <td>
                                    <a href="edit_contact.php?contact_id=<?php echo $row['contact_id']; ?>" title="Edit"><img src="../images/edit.png" alt=""/></a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="return confirm('Are you sure');" href="delete_contact.php?contact_id=<?php echo $row['contact_id']; ?>" title="Delete"><img src="../images/delete.png" alt=""/></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
