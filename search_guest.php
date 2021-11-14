<html lang="en">
<head>
    <title>Searching For Guest....</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$phone = $_POST["phone"];
$email = $_POST["email"];

$sanitized_fname =
    mysqli_real_escape_string($con, $fname);
$sanitized_lname =
    mysqli_real_escape_string($con, $lname);
$sanitized_phone =
    mysqli_real_escape_string($con, $phone);
$sanitized_email =
    mysqli_real_escape_string($con, $email);

$search = "SELECT * FROM guests WHERE fname = '$sanitized_fname' OR lname = '$sanitized_lname' OR phone = '$sanitized_phone' OR email = '$sanitized_email'";

if (mysqli_query($con,$search)){
    echo "<br>";
} else {
    echo "ERROR Searching " , mysqli_error($con);
}

$result = mysqli_query($con, $search);

$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    echo "No guests found";
} else {

    echo "<br>";
    echo "<br>";

// show results of table with new data inserted
    echo "The Following Guests Were Found: <br>";
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