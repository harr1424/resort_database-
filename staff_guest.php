
<html lang="en">
<head>
    <title>Staff Assignment History</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$staff = $_POST["staff"];

$sanitized_staff =
    mysqli_real_escape_string($con, $staff);

$check = "SELECT fname, lname FROM staff WHERE id = '$sanitized_staff'";
$check_result = mysqli_query($con, $check);
$numrows = mysqli_num_rows($check_result);
$staff_name_query = mysqli_fetch_array($check_result);
$staff_name = $staff_name_query['fname'];
$staff_last_name = $staff_name_query['lname'];

if ($numrows == 0) {
    echo "Staff ID not found";
}
else {

    $query = "SELECT booking.arrive AS Guest_Arrival,
booking.depart AS Guest_Depart, guests.fname AS Guest_First_Name, guests.lname AS Guest_Last_Name, assign_staff.feedback AS Feedback
FROM staff, booking, guests, assign_staff, reservation
WHERE staff.id = '$sanitized_staff'
AND assign_staff.staff_id = staff.id
AND booking.id = assign_staff.booking_id
AND reservation.booking_id = booking.id
AND guests.id = reservation.guest_id";


    if (mysqli_query($con, $query)) {
        echo "<br>";
    } else {
        echo "ERROR Printing ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
    $num_relationships = mysqli_num_rows($result);

    if ($num_relationships == 0) {
        echo "No relationships found";
    }

// show results of table with new data inserted
    echo "All Guests Served By $staff_name $staff_last_name:<br>";
    echo 'Note that feedback is provided by booking, not individual guests.';
    echo " <table border='1'>\n";
    echo "\t<tr>\n";
    while ($fieldinfo = $result->fetch_field()) {
        echo "\t\t<td>$fieldinfo->name</td>\n";
    }
    echo "\t</tr>\n";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($row as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";
}
echo "<br>";
echo "<br>";
mysqli_free_result($result);

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>



