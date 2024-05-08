<?php

require __DIR__ . '/connection.php';

// define admins here
$admins = array(
    array(
        "name" => "Adam",
        "surname" => "Jánoš",
        "email" => "xjanosa@stuba.sk",
        "password" => "heslo_jako_kreslo"
    ),
    array(
        "name" => "Root",
        "surname" => "Root",
        "email" => "root@example.com",
        "password" => "root_password"
    ),
);


// add admins to database (if not present yet)
foreach ($admins as $admin) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(":email", $admin['email'], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        continue;
    }

    $stmt = $pdo->prepare("INSERT INTO users (email, name, surname, password, admin) VALUES (:email, :name, :surname, :password, 1)");
    $hashed_password = password_hash($admin['password'], PASSWORD_ARGON2ID);
    $stmt->bindParam(":email", $admin['email'], PDO::PARAM_STR);
    $stmt->bindParam(":name", $admin['name'], PDO::PARAM_STR);
    $stmt->bindParam(":surname", $admin['surname'], PDO::PARAM_STR);
    $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
    $stmt->execute();
}