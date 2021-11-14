
<html lang="en">
<head>
    <title>All Reservations</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$update = "SELECT * FROM reservation";

if (mysqli_query($con,$update)){
    echo "<br>";
} else {
    echo "ERROR querying reservations " , mysqli_error($con);
}

$result = mysqli_query($con, $update);

$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    echo "Something has gone wrong, please reset the database state";
    }
else {

// show results of table with new data inserted
    echo "All Reservations <br>";
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

    echo "<br>";
    echo "<br>";

}
mysqli_free_result($result);


mysqli_close($con);


echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>
