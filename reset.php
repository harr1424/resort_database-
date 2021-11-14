<html lang="en">
<head>
    <title>Reset Database to Default State</title>
</head>
<body>
<?php
$con=mysqli_connect("localhost", "username", "password", "username");

if($con == false){
    die("ERROR COULD NOT CONNECT");
}

$script = file_get_contents("/home/username/public_html/reset.sql", false, null);

mysqli_multi_query($con, $script);

mysqli_close($con);

echo "Database State Reset <br>";

echo " <a href='home.html'>Main Menu</a>";

?>

</body>
</html>