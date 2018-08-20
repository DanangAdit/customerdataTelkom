<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <title>Cek Alamat</title>
    </head>

    <body style="background-color: #e8e8e8">
        <div class="kotak">
            <img src="assets\img\telkom.png" alt="Image">
            <form name="A" method="post" action="cek_login.php">
                <div class="username">
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="pass">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="tbl">
                    <button type="submit" name="login" class="btn btn-danger">Login</button>
                </div>
                <?php
                if (isset($_GET["login_error"])) {
                    echo "<label style='color:red;margin-left:32px';>Username atau password salah</label>";
                }
                ?>
                <?php
//echo $sql1;   
                ?>
            </form>
        </div>
        <a href="http://danangaditya.co.nf/" style="font-size: 11px; color: black; position: absolute; bottom: 0%; right: 50%; z-index: 2;">DEV</a>
    </body>
</html>
<style media="screen">
    html body .form1{
        position: absolute;
    }
    html body .kotak{
        width: 300px;
        left: 40%;
        position: absolute;
        top: 20%;
    }
    html body .username{
        padding-bottom: 15px;
        margin-left: 30px; 
    }
    html body .pass{
        padding-bottom: 15px;
        margin-left: 30px;
    }
    html body .tbl{
        padding-bottom: 15px;
        padding-left: 35%;
    }
    html body img{
        padding-bottom: 30px;
        width: 305px;
        height: 160px;
    }
</style>
