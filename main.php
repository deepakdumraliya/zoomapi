<?php

@session_start();

if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 1) {
?>
        <!DOCTYPE html>

        <head>
            <title>Zoom WebSDK</title>
            <meta charset="utf-8" />
            <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css" />
            <!-- <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css" /> -->
            <meta name="format-detection" content="telephone=no">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        </head>

        <body>
            <style>
                #zmmtg-root {
                    background-color: transparent !important;
                    position: relative !important;
                }

                .sdk-select {
                    height: 34px;
                    border-radius: 4px;
                }

                .websdktest button {
                    float: right;
                    margin-left: 5px;
                }

                #nav-tool {
                    margin-bottom: 0px;
                }

                #show-test-tool {
                    position: absolute;
                    top: 100px;
                    left: 0;
                    display: block;
                    z-index: 99999;
                }

                #display_name {
                    width: 250px;
                }


                #websdk-iframe {
                    width: 700px;
                    height: 500px;
                    border: 1px;
                    border-color: red;
                    border-style: dashed;
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    left: 50%;
                    margin: 0;
                }
            </style>
            <center>
                <div>

                    <div class="container">

                        <br>
                        <a href="createmeeting.php" class="btn btn-primary" id="createmeeting">Create meeting</a>
                        <hr>
                        <a href="index.php" class="btn btn-primary" id="createmeeting">Start Meeting</a>
                        <hr>
                        <form method="POST">
                        <input type="submit" class="btn btn-primary" name="btnlogout" value="logout"/>
                          </form>
                        <!--/.navbar-collapse -->
                    </div>
                </div>
            </center>

           
        </body>

        </html>

<?php
if(isset($_POST['btnlogout'])){
    session_destroy();
    header('location:login.php', true);
}

    }
} else {
    header('location:login.php', true);
    //   header('loaction:login.php');
}
?>