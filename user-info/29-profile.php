<?php
                        session_start();
                        require '../INCLUDES/dbh.inc.php';
                        require '../INCLUDES/header.php';

                        $uid = 29;
                        $uEmail = "a1770747276z@gmail.com";
                        $id = $uid;

                        require 'include/profile-permission.inc.php';

                        require 'profile-new-ui.inc.php';
                        require '../INCLUDES/footer.php';
                     ?>
