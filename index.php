<?php
    include 'php/sqlPHP.php';
?>
<html class="login">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/login.css">

    <head>
       <div topnav = "topnav.php"></div>
       <link rel="icon" href="css/icon.png">
       <title>BDD Pautas</title>
    </head>

    <body>
        <div class="loginPage">
            <div class="loginForm">
                <form action="index.php" method="post">
                    <table style="width:30%" class="loginTable">
                        <tr>
                            <th><p>User</p></th>
                            <th><input type="text" name="user"><br></th>
                        </tr>
                        <tr>
                            <th><p>Password</p></th>
                            <th><input type="password" name="pwd"><br></th>
                        </tr>

                        <tr><th></th><th><input type="submit" value="Login" name="login"></th></tr>
                        <th>
                    </table>
                </form>
            </div>
            <div class="registerLogin">
                <form action="index.php" method="post">
                <input type="submit" value="Register" name="register">
                </form>
            </div>
        </div>

    </body>



</html>
