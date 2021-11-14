<html lang="en">
<head>
    <title>Print Charges</title>
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

$check = "SELECT * FROM charge WHERE booking_id = '$sanitized_booking'";
$check_result = mysqli_query($con, $check);
$numrows = mysqli_num_rows($check_result);

if ($numrows == 0) {
    echo "Booking ID has not been charged";
}
else {
    $query = "SELECT billables.description AS Item, billables.location AS Location, billables.amount AS Price,
charge.occurred AS Occurred FROM billables, charge WHERE charge.booking_id = '$sanitized_booking'
AND charge.billable_id = billables.id";

    if (mysqli_query($con, $query)) {
        echo "<br>";
    } else {
        echo "ERROR Printing ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
    $num_charges = mysqli_num_rows($result);

    if ($num_charges == 0) {
        echo "This booking doesn't have any posted charges";
    } else {

        echo "<br>";
        echo "<br>";

// show results of table with new data inserted
        echo "All Booking Charges <br>";
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

