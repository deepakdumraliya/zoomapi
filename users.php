<?php
require_once 'class-db.php';
require_once 'config.php';
@session_start();
if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 0) {
        $db = new DB;
        $res = $db->getuserbyid($_SESSION['id']);
        $name = "";
        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $name = $row['Name'];
        }
?>
        <!DOCTYPE html>

        <head>
            <title>POTENZA ZOOM</title>
            <meta charset="utf-8" />
            <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css" />
            <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css" />
            <meta name="format-detection" content="telephone=no">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        </head>

        <body>
            <style>
                .fullScreen {
                    width: 100vw;
                    height: 100vh;
                }

                .vertical-scrollable>.row {
                    position: absolute;
                    top: 120px;
                    bottom: 100px;
                    left: 180px;
                    width: 50%;
                    overflow-y: scroll;
                }

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

            <div>
                <div class="container">
                    <hr>
                    <h1>Users Joining Page</h1>
                    <hr>
                    <form method="POST">
                        <input type="submit" class="btn btn-primary" name="btnlogout" value="logout" />
                    </form>
                    <hr>
                    <div>
                        <table class="table" id="meeting">
                            <tr>
                                <th>Topic</th>
                                <th>Meeting Id</th>
                                <th>Password</th>
                                <th>Join Meeting</th>

                            </tr>



                        </table>

                    </div>


                </div>
            </div>
            </div>
           
            <div class="vertical-scrollable row text-center">
                
                <iframe class="responsive-iframe " height=" 300" width="600" title="Iframe Example" name="theFrame"></iframe>
            </div>




            <script src="https://source.zoom.us/1.9.0/lib/vendor/react.min.js"></script>
            <script src="https://source.zoom.us/1.9.0/lib/vendor/react-dom.min.js"></script>
            <script src="https://source.zoom.us/1.9.0/lib/vendor/redux.min.js"></script>
            <script src="https://source.zoom.us/1.9.0/lib/vendor/redux-thunk.min.js"></script>
            <script src="https://source.zoom.us/1.9.0/lib/vendor/lodash.min.js"></script>
            <script src="https://source.zoom.us/zoom-meeting-1.9.0.min.js"></script>
            <script src="js/tool.js"></script>
            <script src="js/vconsole.min.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                var name = "<?php echo $name;   ?>";
                var base_uri = "<?php echo BASE_URI;   ?>";
                var api = "<?php echo API_KEY;   ?>";
                var api_secret = "<?php echo SECRET_KEY;   ?>";
            </script>
            <script src="js/index.js"></script>
            <script>
                var url_get = base_uri + "/getallmeeting.php";

                $.ajax({
                    type: "POST",
                    url: url_get,
                    dataType: 'json',
                    success: function(result) {
                        $.each(result, function(i, item) {
                            $('#meeting').append("<tr><td>" + item.topic + "</td><td>" + item.meeting_id + "</td><td>" + item.passcode + "</td><td> <button type='button' name=" + item.id + " class='btn btn-primary getmeeting' id=" + item.id + " >Join</button></td></tr>");
                            console.log(item);

                        });

                    }
                });

                $(document).ready(function() {

                    $(document).on('click', '.getmeeting', function() {
                        var val = $(this).attr('id');
                        var url_get = base_uri + "/getmeeting.php";
                        $.ajax({
                            type: "POST",
                            data: {
                                'id': val
                            },
                            url: url_get,
                            dataType: 'json',
                            success: function(result) {
                                console.log(result);
                                websdkready(result.meeting_id, result.passcode, 0, name);
                            }
                        });

                    });
                });
            </script>
        </body>

        </html>

<?php
        if (isset($_POST['btnlogout'])) {
            session_destroy();
            header('location:login.php', true);
        }
    }
} else {
    header('location:login.php', true);
    //   header('loaction:login.php');
}

?>