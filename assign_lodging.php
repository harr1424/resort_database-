<html lang="en">
<head>
    <title>Assign Lodging</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$booking = $_POST["booking"];
$guest = $_POST["guest"];
$site = $_POST["site"];
$number = $_POST["number"];

$sanitized_guest =
    mysqli_real_escape_string($con, $guest);
$sanitized_booking =
    mysqli_real_escape_string($con, $booking);
$sanitized_site =
    mysqli_real_escape_string($con, $site);
$sanitized_number =
    mysqli_real_escape_string($con, $number);

$check_guest = "SELECT * FROM guests WHERE id = '$sanitized_guest'";
$check_guest_result = mysqli_query($con, $check_guest);
$guest_numrows = mysqli_num_rows($check_guest_result);
$check_booking = "SELECT * FROM booking WHERE id = '$sanitized_booking'";
$check_booking_result = mysqli_query($con, $check_booking);
$booking_numrows = mysqli_num_rows($check_booking_result);
$check_site = "SELECT * FROM lodging WHERE site_name = '$sanitized_site'";
$check_site_result = mysqli_query($con, $check_site);
$site_numrows = mysqli_num_rows($check_site_result);
$check_number = "SELECT * FROM lodging where number = '$sanitized_number'";
$check_number_result = mysqli_query($con, $check_number);
$number_numrows = mysqli_num_rows($check_number_result);

if ($guest_numrows == 0) {
    echo "Guest ID not found";
}
elseif ($booking_numrows == 0) {
    echo "Booking ID not found";
}
elseif ($site_numrows == 0) {
    echo "Site Name not found";
}
elseif ($number_numrows == 0) {
    echo "Lodging Number not found";
}
else {

    $insert_lodging = "INSERT INTO assign_lodging (booking_id, guest_id, site_name, lodging_number) VALUES ('$sanitized_booking', '$sanitized_guest', '$sanitized_site', '$sanitized_number')";
    if (mysqli_query($con, $insert_lodging)) {
        echo "<br>";
    } else {
        echo "ERROR Updating Table ", mysqli_error($con);
    }

    $show_lodging = "SELECT * FROM assign_lodging WHERE booking_id = '$sanitized_booking' AND guest_id = '$sanitized_guest' AND site_name = '$sanitized_site' AND lodging_number = '$sanitized_number'";
    $result_show_lodging = mysqli_query($con, $show_lodging);

    echo "<br>";
    echo "<br>";

// show results of table with new data inserted
    echo "Lodging Assignment:<br>";
    echo " <table border='1'>\n";
    echo "\t<tr>\n";
    while ($fieldinfo = $result_show_lodging->fetch_field()) {
        echo "\t\t<td>$fieldinfo->name</td>\n";
    }
    echo "\t</tr>\n";
    while ($row = mysqli_fetch_array($result_show_lodging, MYSQLI_ASSOC)) {
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
mysqli_free_result($result_show_lodging);

mysqli_close($con);

?>

</body>
</html>

