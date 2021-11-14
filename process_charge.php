<html lang="en">
<head>
    <title>Process Charge</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$booking = $_POST["booking"];
$billable = $_POST["billable"];
$occurred = $_POST["occurred"];

$sanitized_booking =
    mysqli_real_escape_string($con, $booking);
$sanitized_billable =
    mysqli_real_escape_string($con, $billable);
$sanitized_occurred =
    mysqli_real_escape_string($con, $occurred);

$charge = "INSERT INTO charge (booking_id, billable_id, occurred) VALUES ('$sanitized_booking', '$sanitized_billable', '$sanitized_occurred')";

if (mysqli_query($con,$charge)){
    echo "Charge Posted";
} else {
    echo "ERROR Updating Table " , mysqli_error($con);
}

$show_charges = "SELECT * FROM charge WHERE booking_id = '$sanitized_booking'";
$result_charge = mysqli_query($con, $show_charges);

echo "<br>";
echo "<br>";

// show results of table with new data inserted
echo "All Booking Charges <br>";
echo " <table border='1'>\n";
echo "\t<tr>\n";
while ($fieldinfo = $result_charge -> fetch_field()){
    echo "\t\t<td>$fieldinfo->name</td>\n";
}
echo "\t</tr>\n";while ($row = mysqli_fetch_array($result_charge, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($row as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

echo "<br>";
echo "<br>";
mysqli_free_result($result_charge);

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>

