<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <center>
        <hr>
        <h2>Login</h2>
        <hr>
        <form method="post" action="#">
            <table cellpadding="20px">
                <tr>
                    <td>
                        <label>Username:-</label>
                        <input type="text" class="form-control" id="username" name="txtusername" placeholder="Enter Username">
                    </td>

                </tr>
                <tr>
                    <td>
                        <label>Password:-</label>
                        <input type="password" class="form-control" id="pass" name="txtpasscode" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Login ">
                    </td>
                </tr>
            </table>
        </form>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>

</html>
<?php
require_once "class-db.php";
if (isset($_POST['submit'])) {
    $username = trim($_POST['txtusername']);
    $password = trim($_POST['txtpasscode']);
    $db = new DB;
    $res = $db->login($username, $password);

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        print_r($row);
        @session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['type'] = $row['type'];
        if ($row['type'] == 1) {
            header('location:main.php', true);
        } else {
            header('location:users.php', true);
        }
    }
    // while ($row = $res->fetch_assoc()) {
    //     print_r($row);
    // }
}

?>