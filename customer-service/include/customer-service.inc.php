<?php
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");

    require '../../INCLUDES/dbh.inc.php';
    require 'mail-admin.inc.php';

    /* function */

    /* session */
    function sessionCheck() {

        if(isset($_SESSION['usersEmail'])) {

            $userEmail = $_SESSION['usersEmail'];
            $userName = $_SESSION['userName'];
            $userID = $_SESSION['uid'];

            //$session_array = array($userEmail, $userName, $userID);
            $session_info = $userEmail.$userName.$userID;

            return $session_info;

        } else {

            return 0;

        }
    }

    /* post */
    function postCheck() {

        if(!isset($_POST['title-cs']) || !isset($_POST['category-cs']) || !isset($_POST['details-cs']) || !isset($_POST['email-cs']) || !isset($_POST['name-cs'])) {
            header("Location: https://www.gaakzei.com/customer-service/customer-service");

        } else {

            $title_cs = $_POST['title-cs'];
            $category_cs = $_POST['category-cs'];
            $details_cs = $_POST['details-cs'];
            $email_cs = $_POST['email-cs'];
            $name_cs = $_POST['name-cs'];

            $post_array = array($title_cs, $category_cs, $details_cs, $email_cs, $name_cs);

            return $post_array;
        }
    }

    //insert data to database
    function insertData($postArr, $sessionStr, $conn) {

        $classification = "cs";
        $date = date("Y-m-d H:i:s");

        $insert_sql = "INSERT INTO customerservice (classification, title, category, details, email, nameUser, sessionInfo, dateCS) VALUES (?, ?, ?, ?, ?, ?, ?, ?); ";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $insert_sql)) {
            header("Location: https://www.gaakzei.com/customer-service/customer-service");
            
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssss", $classification, $postArr[0], $postArr[1], $postArr[2], $postArr[3], $postArr[4], $sessionStr, $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return $date;
        }
    }

    function getTicketNum($title_fc, $email_fc, $date_fc, $conn) {

        $gtn_sql = "SELECT primaryKey FROM customerservice WHERE title = ? AND email = ? AND dateCS = ?;";
        $gtn_stmt = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($gtn_stmt, $gtn_sql)) {
            header("Location: https://www.gaakzei.com/customer-service/customer-service");
            
        } else {
            mysqli_stmt_bind_param($gtn_stmt, "sss", $title_fc, $email_fc, $date_fc);
            mysqli_stmt_execute($gtn_stmt);

            $gtn_result = mysqli_stmt_get_result($gtn_stmt);
            $gtn_row = mysqli_fetch_array($gtn_result);

            mysqli_stmt_close($gtn_stmt);

            return $gtn_row['primaryKey'] ;
        }
    }

    function sendMail($to, $subject, $user_name, $request_details, $ticket) {
        $message = '<html>
                        <body>
                            <p>尊敬的'.$user_name.'</p> <br>
                            <p>非常感謝您提出的請求，'.$ticket.' 為您的請求號碼，您的請求將會在3個工作天内處理。</p> <br>
                    
                            <p>「'.$request_details.'」</p> <br>
                            <br>
                    
                            <p>GaaiZei 客服部門</p>
                    
                            <br>
                            <p>=======================================================================================</p>
                            <br>
                    
                            <p>Dear '.$user_name.'</p> <br>
                            <p>The request has been accepted，'.$ticket.' will be your ticket number，we will reply you within 3 working days.</p> <br>
                    
                            <p>「'.$request_details.'」</p> <br>
                            
                            <p>Thank you for your patience.</p>
                    
                            <p>Yours sincerely,</p>
                            <p>GaaiZei Customer Service Department</p>
                        </body>
                    </html>';

                    $headers = "From: GaakZei <customer-service@gaakzei.com> \r\n";
                    $headers .= "Reply-To: customer-service@gaakzei.com \r\n";
                    $headers .= "Content-type:text/html\r\n";

                    if (mail($to, $subject, $message, $headers)) {
                        header("Location: https://www.gaakzei.com/customer-service/customer-service?request=success");
                  
                      } else {
                        header("Location: https://www.gaakzei.com/customer-service/customer-service?rerequestset=fail");
                      }

    }


    //start procedure

    $post_arr = postCheck();
    $session_str = sessionCheck();
    $dateNow = insertData($post_arr, $session_str, $conn);
    $ticket_number = getTicketNum($post_arr[0], $post_arr[3], $dateNow, $conn);
    sendMail($post_arr[3], $post_arr[0], $post_arr[4], $post_arr[2], $ticket_number);
    mail_admin($post_arr[3], $post_arr[0], $post_arr[2], $ticket_number);