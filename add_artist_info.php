<?php
require "dbconnection.php";
$dbcon = createDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tarkista, että tarvittavat tiedot ovat saatavilla
    if (!isset($_POST['artistName']) || !isset($_POST['albumTitle'])) {
        echo "Virhe: Pakollisia tietoja puuttuu.";
        exit;
    }

    // Hae parametrit
    $artistName = $_POST['artistName'];
    $albumTitle = $_POST['albumTitle'];

    try {
        // Aloita transaktio
        $dbcon->beginTransaction();

        // Lisää uusi artisti
        $artistQuery = "INSERT INTO artists (Name) VALUES (:artistName)";
        $artistStatement = $dbcon->prepare($artistQuery);
        $artistStatement->bindValue(':artistName', $artistName, PDO::PARAM_STR);
        $artistStatement->execute();

        // Hae lisätyn artistin ID
        $artistId = $dbcon->lastInsertId();

        // Lisää uusi albumi artistille
        $albumQuery = "INSERT INTO albums (ArtistId, Title) VALUES (:artistId, :albumTitle)";
        $albumStatement = $dbcon->prepare($albumQuery);
        $albumStatement->bindValue(':artistId', $artistId, PDO::PARAM_INT);
        $albumStatement->bindValue(':albumTitle', $albumTitle, PDO::PARAM_STR);
        $albumStatement->execute();

        // Sitouta transaktio
        $dbcon->commit();

        echo "Uusi artisti ja albumi on lisätty onnistuneesti.";
    } catch (PDOException $e) {
        // Peruuta transaktio ja tulosta virheilmoitus
        $dbcon->rollBack();
        echo "Virhe tietokantatoiminnassa: " . $e->getMessage();
    }
} else {
    echo "Virhe: Tiedostoon tulee tehdä POST-pyyntö.";
}