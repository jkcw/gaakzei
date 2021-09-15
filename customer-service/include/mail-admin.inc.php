<?php 

function mail_admin($to, $subject, $request_details, $ticket) {
    $message = '<html>
                    <body>
                        <p>「'.$request_details.'」</p>
                        <h2>'.$ticket.'</h2>
                    </body>
                </html>';

                $headers = 'From: New ticket <'.$to.'> \r\n';
                $headers .= 'Reply-To: '.$to.' \r\n';
                $headers .= "Content-type:text/html\r\n";

                if (mail('gaakzei@gmail.com', $subject, $message, $headers)) {
                    header("Location: https://www.gaakzei.com/customer-service/customer-service?request=success");
              
                  } else {
                    header("Location: https://www.gaakzei.com/customer-service/customer-service?rerequestset=fail");
                  }

}

?>