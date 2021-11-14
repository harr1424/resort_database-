<html lang="en">
<head>
    <title>Staff Feedback</title>
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

$check = "SELECT * FROM assign_staff WHERE staff_id = '$sanitized_staff'";
$check_result = mysqli_query($con, $check);
$numrows = mysqli_num_rows($check_result);

if ($numrows == 0) {
    echo "Staff ID not found";
}
else {
    $query = "SELECT feedback FROM assign_staff WHERE staff_id = '$sanitized_staff'";
    if (mysqli_query($con, $query)) {
        echo "<br>";
    } else {
        echo "ERROR Printing ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
    $num_feedback = mysqli_num_rows($result);

    if ($num_feedback == 0) {
        echo "Staff has not yet received feedback";
    } else {

        echo "<br>";
        echo "<br>";

// show results of table with new data inserted
        echo "All Feedback  <br>";
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

