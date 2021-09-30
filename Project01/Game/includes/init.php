<?php

session_start();

//DATABASE CONNECTION
$conn = mysqli_connect("localhost", "root", "", "game");



//Current Time
$timestamp = time();

// current file name 
$current_file_path = $_SERVER["PHP_SELF"];
$current_file = basename($current_file_path, ".php");


//JS ALERT
function JS_ALERT($msg, $redirect = ""){
    global $current_file_path;
    if(empty($redirect)){
        $redirect = $current_file_path;
    }
    echo "<script>alert('$msg');location.href='$redirect'</script>";
}

function points($player){
    global $conn;
    $user_id = $_SESSION["user_loggedin"];
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_array($sql);
        $col = $player . "_points";
        return $row[$col];
    }
}

function add_point($player){
    global $conn;
    $user_id = $_SESSION["user_loggedin"];
    $col = $player . "_points";
    $sql = mysqli_query($conn, "UPDATE users SET $col = $col + 1 WHERE id = '$user_id'");
}

?>