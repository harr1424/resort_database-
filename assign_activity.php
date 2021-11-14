<html lang="en">
<head>
    <title>Assign Activity</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$guest = $_POST["guest"];
$activity = $_POST["activity"];
$timestamp = $_POST["timestamp"];
$status = $_POST["status"];

$sanitized_guest =
    mysqli_real_escape_string($con, $guest);
$sanitized_activity =
    mysqli_real_escape_string($con, $activity);
$sanitized_timestamp =
    mysqli_real_escape_string($con, $timestamp);
$sanitized_status =
    mysqli_real_escape_string($con, $status);

$check_guest = "SELECT * FROM guests WHERE id = '$sanitized_guest'";
$check_guest_result = mysqli_query($con, $check_guest);
$guest_numrows = mysqli_num_rows($check_guest_result);
$check_activity = "SELECT * FROM activities WHERE name = '$sanitized_activity'";
$check_activity_result = mysqli_query($con, $check_activity);
$activity_numrows = mysqli_num_rows($check_activity_result);

if ($guest_numrows == 0) {
    echo "The guest ID you enetered does not exist";
}
else if ($activity_numrows == 0) {
    echo "The activity name you entered does not exist";
}
else {

    $insert_activities = "INSERT INTO assign_activities (id, name, scheduled, status) VALUES ('$sanitized_guest', '$sanitized_activity','$sanitized_timestamp', '$sanitized_status')";
    if (mysqli_query($con, $insert_activities)) {
        echo "<br>";
    } else {
        echo "ERROR Updating Table ", mysqli_error($con);
    }

    $show_activities = "SELECT * FROM assign_activities WHERE id = '$sanitized_guest'";
    $result_show_activities = mysqli_query($con, $show_activities);

    echo "<br>";
    echo "<br>";

// show results of table with new data inserted
    echo "All Guest Activities <br>";
    echo " <table border='1'>\n";
    echo "\t<tr>\n";
    while ($fieldinfo = $result_show_activities->fetch_field()) {
        echo "\t\t<td>$fieldinfo->name</td>\n";
    }
    echo "\t</tr>\n";
    while ($row = mysqli_fetch_array($result_show_activities, MYSQLI_ASSOC)) {
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


mysqli_free_result($result_show_activities);

mysqli_close($con);
echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>