<html lang="en">
<head>
    <title>New Reservation</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$occurred = $_POST["occurred"];
$arrive = $_POST["arrive"];
$depart = $_POST["depart"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$dob = $_POST["dob"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$street = $_POST["street"];
$city = $_POST["city"];
$state = $_POST["state"];
$country = $_POST["country"];
$postal = $_POST["postal"];
$status = $_POST["status"];
$bank = $_POST["bank"];
$account = $_POST["account"];
$special = $_POST["special"];
$type = $_POST["type"];
$event = $_POST["event"];
$referral = $_POST["referral"];

$sanitized_occurred =
    mysqli_real_escape_string($con, $occurred);
$sanitized_arrive =
    mysqli_real_escape_string($con, $arrive);
$sanitized_depart =
    mysqli_real_escape_string($con, $depart);
$sanitized_fname =
    mysqli_real_escape_string($con, $fname);
$sanitized_lname =
    mysqli_real_escape_string($con, $lname);
$sanitized_dob =
    mysqli_real_escape_string($con, $dob);
$sanitized_phone =
    mysqli_real_escape_string($con, $phone);
$sanitized_email =
    mysqli_real_escape_string($con, $email);
$sanitized_street =
    mysqli_real_escape_string($con, $street);
$sanitized_city =
    mysqli_real_escape_string($con, $city);
$sanitized_state =
    mysqli_real_escape_string($con, $state);
$sanitized_country =
    mysqli_real_escape_string($con, $country);
$sanitized_postal =
    mysqli_real_escape_string($con, $postal);
$sanitized_status =
    mysqli_real_escape_string($con, $status);
$sanitized_bank =
    mysqli_real_escape_string($con, $bank);
$sanitized_account =
    mysqli_real_escape_string($con, $account);
$sanitized_special =
    mysqli_real_escape_string($con, $special);
$sanitized_type =
    mysqli_real_escape_string($con, $type);
$sanitized_event =
    mysqli_real_escape_string($con, $event);
$sanitized_referral =
    mysqli_real_escape_string($con, $referral);


if (empty($occurred)) {
    echo "Current Time is a required field<br><br>";
}

if (empty($arrive)){
    echo "Arrive is a required field<br><br>";
}

if (empty($depart)) {
    echo "Depart is a required field<br><br>";
}

if (empty($fname)) {
    echo "First Name(s) is a required field<br><br>";
}

if (empty($lname)) {
    echo "Last Name is a required field<br><br>";
}

if (empty($status)) {
    echo "Status is a required field<br><br>";
}

$guest_insert = "REPLACE INTO guests (fname, lname, dob, phone, email, street, city, state, country, postal) VALUES ('$fname', '$lname', '$dob', '$phone', '$email', '$street', '$city', '$state', '$country', '$postal')";

if (mysqli_query($con,$guest_insert)){
    echo "Table guests Updated....<br>";
} else {
    echo "ERROR Updating Table Guests" , mysqli_error($con);
}

$guest_id = mysqli_insert_id($con);

$booking_insert = "REPLACE INTO booking (arrive, depart, special, type, event, referral) VALUES ('$arrive', '$depart', '$special', '$type', '$event', '$referral')";

if (mysqli_query($con,$booking_insert)){
    echo "Table Booking Updated....<br>";
} else {
    echo "ERROR Updating Table Booking" , mysqli_error($con);
}

$booking_id = mysqli_insert_id($con);


$reservation_insert = "REPLACE INTO reservation (guest_id, booking_id, occurred, status, bank, acct) VALUES ('$guest_id', '$booking_id','$occurred', '$status', '$bank', '$account')";

if (mysqli_query($con,$reservation_insert)){
    echo "Table Reservation Updated....<br>";
} else {
    echo "ERROR Updating Table Reservation" , mysqli_error($con);
}

$show_guests = "SELECT * FROM guests WHERE id = '$guest_id'";
$show_booking = "SELECT * FROM booking WHERE id = '$booking_id'";
$show_reservation = "SELECT * FROM reservation WHERE guest_id = '$guest_id' AND booking_id = '$booking_id'";

$result_show_guests = mysqli_query($con, $show_guests);
$result_show_booking = mysqli_query($con, $show_booking);
$result_show_reservation = mysqli_query($con, $show_reservation);

echo "<br>";
echo "<br>";


// show results of table with new data inserted
echo "Guest Information <br>";
echo " <table border='1'>\n";
echo "\t<tr>\n";
while ($fieldinfo = $result_show_guests -> fetch_field()){
    echo "\t\t<td>$fieldinfo->name</td>\n";
}
echo "\t</tr>\n";
while ($row = mysqli_fetch_array($result_show_guests, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($row as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

echo "<br>";
echo "<br>";

// show results of table with new data inserted
echo "Booking Information <br>";
echo " <table border='1'>\n";
echo "\t<tr>\n";
while ($fieldinfo = $result_show_booking -> fetch_field()){
    echo "\t\t<td>$fieldinfo->name</td>\n";
}
echo "\t</tr>\n";
while ($row = mysqli_fetch_array($result_show_booking, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($row as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";


echo "<br>";
echo "<br>";

// show results of table with new data inserted
echo "Reservation Information <br>";
echo " <table border='1'>\n";
echo "\t<tr>\n";
while ($fieldinfo = $result_show_reservation -> fetch_field()){
    echo "\t\t<td>$fieldinfo->name</td>\n";
}
echo "\t</tr>\n";
while ($row = mysqli_fetch_array($result_show_reservation, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($row as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

mysqli_free_result($result_show_reservation);
mysqli_free_result($result_show_booking);
mysqli_free_result($result_show_guests);

mysqli_close($con);

echo " <a href='home.html'>Main Menu</a>";

?>
</body>
</html>

