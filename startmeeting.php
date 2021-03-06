   <?php
    require_once 'class-db.php';
    ?>
   <!DOCTYPE html>

   <head>

       <meta charset="utf-8" />
       <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css" />
       <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css" />
       <meta name="format-detection" content="telephone=no">
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
   </head>

   <body>
       <hr>
       My Meeting
       <hr>
       <div>
           <?php if (isset($_GET['url'])) {
                print_r($_GET['url']);
            }  ?>
           <!-- <iframe height="600" width="1500" title="Iframe Example" name="theFrame"></iframe> -->
       </div>
       <hr>
       Footer
       <hr>




       <script src="https://source.zoom.us/1.9.0/lib/vendor/react.min.js"></script>
       <script src="https://source.zoom.us/1.9.0/lib/vendor/react-dom.min.js"></script>
       <script src="https://source.zoom.us/1.9.0/lib/vendor/redux.min.js"></script>
       <script src="https://source.zoom.us/1.9.0/lib/vendor/redux-thunk.min.js"></script>
       <script src="https://source.zoom.us/1.9.0/lib/vendor/lodash.min.js"></script>
       <script src="https://source.zoom.us/zoom-meeting-1.9.0.min.js"></script>
       <script src="js/tool.js"></script>
       <script src="js/vconsole.min.js"></script>
       <script src="js/index.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   </body>

   </html>