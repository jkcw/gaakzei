<?php
    
    date_default_timezone_set("Asia/Hong_Kong");

    require '../../../INCLUDES/dbh.inc.php';

    function duplicate_validation($conn ,$input) {
        $sql = "SELECT COUNT(*) FROM users WHERE uidUsers = ?;";
        $stmt = mysqli_stmt_init($conn);
    
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return "error";
    
        } else {
            mysqli_stmt_bind_param($stmt, "s", $input);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
    
            $status = $row['COUNT(*)'];
            $bool = ($status == 0) ? true : false;
        }
    
        return $bool;
    }

    function date_validation($conn ,$userID) {
        $sql = "SELECT primaryKey, dateChange FROM usernameRecord WHERE userID = ? ORDER BY primaryKey DESC LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);
    
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return "error";
    
        } else {
            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);

            $changeDate = strtotime($row['dateChange']);
            $date_check = count_date($changeDate);
            $bool = ($date_check > 2) ? true : false;
        }
        return $bool;
    }

    function count_date($changeDate) {
        $date_now = strtotime(date('Y-m-d H:i:s'));
        $timeDiff = abs($date_now - $changeDate);
        $numberDays = $timeDiff/86400;
        return intval($numberDays);
    }

    function update_username($conn, $input, $userID) {
        $sql = "UPDATE users SET uidUsers = ? WHERE idusers = ?;";
        $stmt = mysqli_stmt_init($conn);
    
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return "error";
    
        } else {
            mysqli_stmt_bind_param($stmt, "si", $input, $userID);
            mysqli_stmt_execute($stmt);
        }

        $sql1 = "INSERT INTO usernameRecord (userID, userNameChanged, dateChange) VALUES (?,?,?)";
        $stmt1 = mysqli_stmt_init($conn);
    
        if (!mysqli_stmt_prepare($stmt1, $sql1)) {
            return "error";
    
        } else {
            $date = date("Y-m-d H:i:s");
            mysqli_stmt_bind_param($stmt1, "iss", $userID, $input, $date);
            mysqli_stmt_execute($stmt1);
        }
        return true;
    }

    if (!isset($_POST['input-username']) && !isset($_POST['username-userID'])) {
        header("Location: ../profile-edit?error=empty");
    } else {
        $input = $_POST['input-username'];
        $userID = $_POST['username-userID'];
    }
    
    if (!duplicate_validation($conn ,$input)) {
        header("Location: ../profile-edit?error=duplicate");
    } elseif (!date_validation($conn ,$userID)) {
        header("Location: ../profile-edit?error=dateUsr");
    } else {
      update_username($conn, $input, $userID);
      header("Location: ../profile-edit?success=username");
    }