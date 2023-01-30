<?php
$connection = mysqli_connect('localhost', 'Solaire', '123456a', 'solaire_pizza');
if (!$connection) {
    echo 'Connection error: ' . mysqli_connect_error();
}
?>