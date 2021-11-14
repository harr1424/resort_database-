<html lang="en">
<head>
    <title>Assign Feedback</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$booking = $_POST["booking"];
$staff = $_POST["staff"];
$feedback = $_POST["feedback"];

$sanitized_booking =
    mysqli_real_escape_string($con, $booking);
$sanitized_staff =
    mysqli_real_escape_string($con, $staff);
$sanitized_feedback =
    mysqli_real_escape_string($con, $feedback);

$check_booking = "SELECT * FROM booking WHERE id = '$sanitized_booking'";
$check_booking_result = mysqli_query($con, $check_booking);
$booking_numrows = mysqli_num_rows($check_booking_result);
$check_staff = "SELECT * FROM staff WHERE id = '$sanitized_staff'";
$check_staff_result = mysqli_query($con, $check_staff);
$staff_numrows = mysqli_num_rows($check_staff_result);


if ($booking_numrows == 0) {
    echo "Booking ID does not exist";
}
elseif ($staff_numrows == 0) {
    echo "Staff ID does not exist";
}
else {
    $query = sprintf("UPDATE assign_staff SET feedback = '%s' 
WHERE staff_id = '$sanitized_staff' AND booking_id = '$sanitized_booking'", mysqli_real_escape_string($con, $feedback));


    if (mysqli_query($con, $query)) {
        echo "Feedback has been assigned.<br>";
    } else {
        echo "ERROR Making Assignment: ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
}
echo "<br>";
echo "<br>";


mysqli_free_result($result);

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>



