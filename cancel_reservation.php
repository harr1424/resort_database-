
<html lang="en">
<head>
    <title>Cancel Reservation</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$booking = $_POST["booking"];

$sanitized_booking =
    mysqli_real_escape_string($con, $booking);

$check = "SELECT * FROM booking WHERE id = '$sanitized_booking'";

$check_result = mysqli_query($con, $check);

$check_numrows = mysqli_num_rows($check_result);

if ($check_numrows == 0) {
    echo "The booking ID you entered does not exist";
}
else {

    $update_reservation = "UPDATE reservation
        SET reservation.status = 'cancelled'
        WHERE reservation.booking_id = '$sanitized_booking'";

    $update_activities = "UPDATE assign_activities SET status = 'cancelled' 
                        WHERE assign_activities.id IN (SELECT guest_id 
                            FROM reservation WHERE booking_id = '$sanitized_booking')";

    $update_staff = "UPDATE assign_staff SET feedback = 'Reservation cancelled by guest'
                        WHERE booking_id = '$sanitized_booking'";


    if (mysqli_query($con, $update_reservation)) {
        echo "Reservation table updated<br>";
    } else {
        echo "ERROR updating table reservation ", mysqli_error($con);
    }

    if (mysqli_query($con, $update_activities)) {
        echo "Activities table updated<br>";
    } else {
        echo "ERROR updating table assign_activities ", mysqli_error($con);
    }

    if (mysqli_query($con, $update_staff)) {
        echo "Staff table updated<br>";
    } else {
        echo "ERROR updating table assign_staff ", mysqli_error($con);
    }

    $delete = "DELETE FROM assign_lodging WHERE booking_id = '$sanitized_booking'";
    if (mysqli_query($con, $delete)) {
        echo "Lodging assignments cancelled<br>";
    } else {
        echo "ERROR cancelling lodging assignments", mysqli_error($con);
    }
}

echo "<br>";
echo "<br>";

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>
