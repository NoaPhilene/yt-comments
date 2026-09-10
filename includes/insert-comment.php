<?php
include("connection.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $naam = test_input($_POST['naam-comment']);
    $email = test_input($_POST['email-comment']);
    $bericht = test_input($_POST['bericht-comment']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=email");
        exit();
    }

    try {

        $sql = "INSERT INTO comments (naam, bericht, email) 
        VALUES (:naam, :bericht, :email)";

        $stmt = $conn->prepare($sql);

        // koppelt de variable met een $ aan de variable voor in sql met :
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':bericht', $bericht);
        $stmt->bindParam(':email', $email);

        // voert het stukje sql code uit
        $stmt->execute();

        header("Location: ../index.php?save=toegevoegd");
        exit();
    } catch (PDOException $e) {
        echo "Fout bij invoegen: " . $e->getMessage();
    }
}
