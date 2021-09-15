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

        if(!isset($_POST['productID-report']) || !isset($_POST['reviewerID-report'])  || !isset($_POST['title-report']) || !isset($_POST['reason-report']) || !isset($_POST['name-report']) || !isset($_POST['email-report'])) {
            header("Location: https://www.gaakzei.com/customer-service/customer-service");

        } else {

            $productID = $_POST['productID-report'];
            $reviewerID = $_POST['reviewerID-report'];
            $title = $_POST['title-report'];
            $reason = $_POST['reason-report'];
            $name = $_POST['name-report'];
            $email = $_POST['email-report'];

            $post_array = array($productID, $reviewerID, $title, $reason, $name, $email);

            return $post_array;
        }
    }

    //insert data to database
    function insertData($postArr, $sessionStr, $conn) {

        $user_reported = $postArr[0].$postArr[1];
        $classification = "c-report";
        $date = date("Y-m-d H:i:s");

        $insert_sql = "INSERT INTO customerservice (classification, title, category, details, email, nameUser, sessionInfo, dateCS) VALUES (?, ?, ?, ?, ?, ?, ?, ?); ";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $insert_sql)) {
            header("Location: https://www.gaakzei.com/customer-service/customer-service");
            
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssss", $classification, $postArr[2], $user_reported, $postArr[3], $postArr[5], $postArr[4], $sessionStr, $date);
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

    function sendMail($to, $subject, $user_name, $request_details, $ticket, $product_id, $reviewer_id) {
        $message = '<html>
                        <body>
                            <p>尊敬的'.$user_name.'</p> <br>
                            <p>非常感謝您提出的檢舉請求，'.$ticket.' 為您的檢舉請求號碼，您的檢舉請求將會在3個工作天内處理。</p> <br>

                            <p>商品ID：'.$product_id.'</p>
                            <p>評論者ID：'.$reviewer_id.'</p>
                            <br>
                    
                            <p>「'.$request_details.'」</p> <br>
                            <br>
                    
                            <p>GaaiZei 客服部門</p>
                    
                            <br>
                            <p>=======================================================================================</p>
                            <br>
                    
                            <p>Dear '.$user_name.'</p> <br>
                            <p>The report request has been accepted，'.$ticket.' will be your ticket number，we will reply you within 3 working days.</p> <br>

                            <p>Product ID：'.$product_id.'</p>
                            <p>Reviewer ID：'.$reviewer_id.'</p>
                            <br>

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

    $post_arr = postCheck();

    print_r($post_arr);
    $session_str = sessionCheck();
    $dateNow = insertData($post_arr, $session_str, $conn);
    $ticket_number = getTicketNum($post_arr[2], $post_arr[5], $dateNow, $conn);
    sendMail($post_arr[5], $post_arr[2], $post_arr[4], $post_arr[3], $ticket_number, $post_arr[0], $post_arr[1]);
    mail_admin($post_arr[5], $post_arr[2], $post_arr[3], $ticket_number);