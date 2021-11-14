<html lang="en">
<head>
    <title>Cancel Activity</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$guest = $_POST["guest"];
$activity = $_POST["activity"];
$date = $_POST["date"];

$sanitized_guest =
    mysqli_real_escape_string($con, $guest);
$sanitized_activity =
    mysqli_real_escape_string($con, $activity);
$sanitized_date =
    mysqli_real_escape_string($con, $date);


$query = "SELECT * FROM assign_activities WHERE id = '$sanitized_guest' AND name = '$sanitized_activity' AND scheduled = '$sanitized_date'";

$query_result = mysqli_query($con, $query);

$query_numrows = mysqli_num_rows($query_result);

if ($query_numrows == 0) {
    echo "The activity information you entered does not exist";
}
else {
    $update = "UPDATE assign_activities SET status = 'cancelled' WHERE id = '$sanitized_guest' AND name = '$sanitized_activity' AND scheduled = '$sanitized_date'";
    if (mysqli_query($con, $update)) {
        echo "Activity assignment cancelled<br>";
    } else {
        echo "ERROR cancelling activity ", mysqli_error($con);
    }

}

echo "<br>";
echo "<br>";

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>


