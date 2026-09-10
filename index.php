<?php
include("includes/connection.php");
include("includes/header.php");

function tijdGeleden($datum)
{
    $postTijd = new DateTime($datum);
    $nu = new DateTime();

    $verschil = $nu->getTimestamp() - $postTijd->getTimestamp();

    $minuten = floor($verschil / 60);
    $uren = floor($verschil / 3600);
    $dagen = floor($verschil / 86400);

    if ($minuten < 1) {
        return "zojuist";
    } elseif ($minuten < 60) {
        return $minuten . " minuten geleden";
    } elseif ($uren < 24) {
        return $uren . ($uren == 1 ? " uur geleden" : " uur geleden");
    } elseif ($dagen < 7) {
        return $dagen . ($dagen == 1 ? " dag geleden" : " dagen geleden");
    } else {
        return $postTijd->format("d-m-Y");
    }
}

?>

<body>

    <iframe
        width="560"
        height="315"
        src="https://www.youtube.com/embed/6_hl8AB7Uf0"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen>
    </iframe>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 'email') {
        echo "<p class='error'>Vul een geldig e-mailadres in.</p>";
    }
    ?>

    <form action="includes/insert-comment.php" method="POST">

        <div id=new-comment>
            <h2>Nieuwe comment</h2>

            <input type="text" name="naam-comment" placeholder="Naam" required>

            <input type="email" name="email-comment" placeholder="email" required>

            <textarea id="bericht-comment" name="bericht-comment" placeholder="Beschrijving" cols="32" rows="6" required></textarea>
            <br>

            <button type="submit" name="submit">Opslaan</button>
            <br>
        </div>
    </form>
    <form action="includes/delete-comments.php" method="POST">
        <button type="submit">Alle comments verwijderen</button>
    </form>
    <br>

    <?php
    //laat de comments in
    try {
        $stmt = $conn->prepare("SELECT * FROM comments ORDER BY `post-tijd` DESC");
        $stmt->execute();

        //zet alle rijen in een array
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$comments) {
            echo "Geen comments gevonden";
            exit;
        }

        //weergeeft de comments
        foreach ($comments as $comment) { ?>
            <div id=comment-box>
                <h2> <?= $comment['naam']; ?></h2>
                <h4> <?= tijdGeleden($comment['post-tijd']); ?> </h4>
                <p> <?= $comment['bericht']; ?> </p>
            </div>
    <?php }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    ?>
    </div>


</body>