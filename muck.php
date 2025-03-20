<?php
## 👉👈just a file php to insert data auto :)👉👈
$con = new mysqli('172.22.0.2', 'root', '12345', 'food-house', '3306');

if($con->connect_error) {
    echo 'conexão não encontrada, por favor verifique novamente';die;
}

$dateToday = date('Y:m:d');
echo $dateToday;exit;

// function putUser() {
//     $sql = 
// }

function putAddess() {
    $sql = "INSERT INTO user_id, status, payment_method, description, created_at, udpatad_at VALUES '1', '1', '1', 'this is just test', ";
}