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


$check = "SELECT * FROM assign_role WHERE staff_id = '$sanitized_staff'";
$check_result = mysqli_query($con, $check);
$numrows = mysqli_num_rows($check_result);

if ($numrows == 0) {
    echo "Staff ID not found";
}

    $query = "SELECT staff.fname AS Staff_Fiest_Name, staff.lname AS Staff_Last_Name, assign_role.role_name AS Role, assign_role.start AS Start, assign_role.end AS End
            FROM staff, assign_role
                WHERE staff.id = '$sanitized_staff'
                AND staff.id = assign_role.staff_id";

    if (mysqli_query($con, $query)) {
        echo "<br>";
    } else {
        echo "ERROR Printing ", mysqli_error($con);
    }

    $result = mysqli_query($con, $query);
    $num_assign = mysqli_num_rows($result);
    if ($num_assign == 0) {
        echo "No assignment history found";
    } else {

        echo "<br>";
        echo "<br>";

// show results of table with new data inserted
        echo "All Staff Assignment History <br>";
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



