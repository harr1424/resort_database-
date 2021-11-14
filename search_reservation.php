<html lang="en">
<head>
    <title>Searching....</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$guest = $_POST["guest"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$booking = $_POST["booking"];

$sanitized_fname =
    mysqli_real_escape_string($con, $fname);
$sanitized_lname =
    mysqli_real_escape_string($con, $lname);
$sanitized_guest =
    mysqli_real_escape_string($con, $guest);
$sanitized_phone =
    mysqli_real_escape_string($con, $phone);
$sanitized_email =
    mysqli_real_escape_string($con, $email);
$sanitized_booking =
    mysqli_real_escape_string($con, $booking);

$search_reservation = "SELECT * FROM reservation WHERE guest_id = '$sanitized_guest' OR booking_id = '$sanitized_booking'";

if (mysqli_query($con,$search_reservation)){
    echo "Searching Reservations Complete <br>";
} else {
    echo "ERROR Searching " , mysqli_error($con);
}

$reservation_result = mysqli_query($con, $search_reservation);

$numrowsreservation = mysqli_num_rows($reservation_result);

$search_guest = "SELECT * FROM reservation WHERE guest_id IN (SELECT id FROM guests 
    WHERE fname = '$sanitized_fname' OR lname = '$sanitized_lname' OR phone = '$sanitized_phone' OR email = '$sanitized_email')";

if (mysqli_query($con,$search_guest)){
    echo "Searching Guests Complete <br>";
} else {
    echo "ERROR Searching " , mysqli_error($con);
}

$guest_result = mysqli_query($con, $search_guest);

$numrowsguest = mysqli_num_rows($guest_result);


echo "<br>";
echo "<br>";

if ($numrowsguest == 0 and $numrowsreservation == 0) {
    echo "No guests or reservations found with information provided <br> <br> ";
}
else {

// show results of table with new data inserted
    echo "The Following Reservations Were Found via the Guest or Booking ID You Entered: <br>";
    echo " <table border='1'>\n";
    echo "\t<tr>\n";
    while ($fieldinfo = $reservation_result->fetch_field()) {
        echo "\t\t<td>$fieldinfo->name</td>\n";
    }
    echo "\t</tr>\n";
    while ($row = mysqli_fetch_array($reservation_result, MYSQLI_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($row as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";
    if ($numrowsreservation == 0) {
        echo "No results";
    }

    echo "<br>";
    echo "<br>";
    mysqli_free_result($reservation_result);

// show results of table with new data inserted
    echo "The Following Reservations Were Found by Querying Guest Information You Submitted: <br>";
    echo " <table border='1'>\n";
    echo "\t<tr>\n";
    while ($fieldinfo = $guest_result->fetch_field()) {
        echo "\t\t<td>$fieldinfo->name</td>\n";
    }
    echo "\t</tr>\n";
    while ($row = mysqli_fetch_array($guest_result, MYSQLI_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($row as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";
    if ($numrowsguest == 0) {
        echo "No results";
    }
}

echo "<br>";
echo "<br>";
mysqli_free_result($guest_result);

mysqli_close($con);

echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>