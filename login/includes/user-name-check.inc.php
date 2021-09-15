<?php 

function check_user_name_available($conn, $usr_name) {

    $sql = "SELECT COUNT(*) FROM users WHERE uidUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "error";

    } else {
        mysqli_stmt_bind_param($stmt, "s", $usr_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);

        $status = $row['COUNT(*)'];
    }

    return $status;

}

function check_email_available($conn, $usr_email) {

    $sql = "SELECT COUNT(*) FROM users WHERE emailUsers = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "error";

    } else {
        mysqli_stmt_bind_param($stmt, "s", $usr_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);

        $status = $row['COUNT(*)'];
    }

    return $status;

}

?>