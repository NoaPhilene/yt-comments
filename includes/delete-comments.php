<?php
include("connection.php");

try {

    $sql = "DELETE FROM comments";

    $stmt = $conn->prepare($sql);

    // Voert de SQL-code uit
    $stmt->execute();

    header("Location: ../index.php?save=alles-verwijderd");
    exit();
} catch (PDOException $e) {
    echo "Fout bij verwijderen: " . $e->getMessage();
}
