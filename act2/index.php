<?php
    session_start();

    $conn = new mysqli("localhost", "root", "", "act2");

    $msg = "";
    $len = isset($cOTLdata['char_data']) ? count($cOTLdata['char_data']) : 0;
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = sha1($password);
        $userType = $_POST['userType'];

        $sql = "SELECT * FROM users WHERE username=? AND password=? AND user_type=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username,$password,$userType);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        session_regenerate_id();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['user_type'];
        session_write_close();
        
        if($result->num_rows==1 && $_SESSION['role'] == "admin"){
            header("location:admin.php");
        }
        else if($result->num_rows==1 && $_SESSION['role'] == "accountant"){
            header("location:accountant.php");
        }
        else if($result->num_rows==1 && $_SESSION['role'] == "cashier"){
            header("location:cashier.php");
        }
        else if($result->num_rows==1 && $_SESSION['role'] == "secretary"){
            header("location:secretary.php");
        }
        else if($result->num_rows==1 && $_SESSION['role'] == "student"){
            header("location:student.php");
        }
        else {
            $msg = "Username or Password is Incorrect";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    *{
        padding:0px;
        margin:0;
        box-sizing:border-box;
    }
    body{
        background: rgb(219,226,226);
    }
    .row{
        background-color:white;
        border-radius:5px;
        box-shadow: 12px 12px 22px #222222;
    }
    .btn1{
        border:none;
        outline:none;
        height:50px;
        width:100%;
        background: #1b1b1b;
        color:white;
        border-radius: 4px;
        font-weight: bold;
    }
    .btn1:hover{
        background-color: white;
        border:1px solid;
        color: #03c04a;
    }

</style>
</head>

<body class="bg-dark m-5">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>


        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <img src = "p2.jpg" class = "img-fluid">
                </div>
                <div class="col-lg-7 px-5 pt-5">
                    <h1 class = "font-weight-bold py-3"> Login </h1>

                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="p-4 login">
                        <div class="form-row">
                            <div class="col-lg-12">
                                <input type="text" name="username" class="form-control  my-3 p-2" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-12">
                            <input type="password" name="password" class="form-control form-control  my-3 p-2 " placeholder="Password" required>
                            </div>
                        </div>

                        <div class="form-group lead p-3">
                        <label form="userType">User: </label>
                        <input type="radio" name="userType" value="admin" class="custom-radio" required>&nbsp;Admin |
                        <input type="radio" name="userType" value="accountant" class="custom-radio" required>&nbsp;Accountant |
                        <input type="radio" name="userType" value="cashier" class="custom-radio" required>&nbsp;Cashier |
                        <input type="radio" name="userType" value="secretary" class="custom-radio" required>&nbsp;Secretary |
                        <input type="radio" name="userType" value="student" class="custom-radio" required>&nbsp;Student |
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="login" class="btn1 btn-danger btn-block">
                    </div>
                    <h5 class="text-danger text-center"><?= $msg; ?></h5>
                    </form>
                </div>
            </div>
        </div>
    </section>
</html>

