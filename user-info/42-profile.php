<?php
                        session_start();
                        require '../INCLUDES/dbh.inc.php';
                        require '../INCLUDES/header.php';

                        $uid = 42;
                        $uEmail = "jacky.lai.ggo@gmail.com";
                        $id = $uid;

                        require 'include/profile-permission.inc.php';

                        require 'profile-new-ui.inc.php';
                        require '../INCLUDES/footer.php';
                     ?>