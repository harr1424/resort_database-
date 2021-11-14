<html lang="en">
<head>
    <title>Staff Roster</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$query = "SELECT * FROM staff";
if (mysqli_query($con,$query)){
    echo "All Staff Shown Below";
} else {
    echo "ERROR Querying Billable Items " , mysqli_error($con);
}

$result = mysqli_query($con, $query);

echo "<br>";
echo "<br>";

// show results of table with new data inserted
echo " <table border='1'>\n";
echo "\t<tr>\n";
while ($fieldinfo = $result -> fetch_field()){
    echo "\t\t<td>$fieldinfo->name</td>\n";
}
echo "\t</tr>\n";while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($row as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

echo "<br>";
echo "<br>";
mysqli_free_result($result);

mysqli_close($con);

echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>
