<html lang="en">
<head>
    <title>Guest Activity History</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$guest = $_POST["guest"];

$sanitized_guest =
    mysqli_real_escape_string($con, $guest);

$check = "SELECT * FROM guests WHERE id = '$sanitized_guest'";
$check_result = mysqli_query($con, $check);
$numrows = mysqli_num_rows($check_result);


if ($numrows == 0) {
    echo "Guest ID not found";
}
else {

    $query = "SELECT distinct guests.fname AS Guest_First_Name, guests.lname AS Guest_Last_Name, booking.arrive, booking.depart, 
booking.type AS Type_Of_Stay, booking.event AS Special_Event, 
assign_activities.name AS Activity_Name, assign_activities.scheduled AS Activity_Date, 
assign_activities.status AS Activity_Status
FROM guests, booking, assign_activities, reservation
WHERE guests.id = '$sanitized_guest'
AND guests.id = assign_activities.id
AND guests.id = reservation.guest_id
AND booking.id = reservation.booking_id";

    if (mysqli_query($con, $query)) {
        echo "<br>";
    } else {
        echo "ERROR Printing ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
    $num_activity = mysqli_num_rows($result);
    if ($num_activity == 0) {
        echo "Guest does not have history yet";
    } else {

        echo "<br>";
        echo "<br>";

// show results of table with new data inserted
        echo "All Guest Activity History <br>";
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
}
echo "<br>";
echo "<br>";
mysqli_free_result($result);

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>



