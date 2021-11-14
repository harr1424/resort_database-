<html lang="en">
<head>
    <title>Staff Assignment</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$booking = $_POST["booking"];
$staff = $_POST["staff"];

$sanitized_booking =
    mysqli_real_escape_string($con, $booking);
$sanitized_staff =
    mysqli_real_escape_string($con, $staff);

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
    $query = "INSERT INTO assign_staff (staff_id, booking_id) VALUES ('$sanitized_staff', '$sanitized_booking')";

    if (mysqli_query($con, $query)) {
        echo "Staff has been assigned.<br>";
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



