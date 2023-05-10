<!-- Tiedostossa on parametreina playlistId. Poista koodilla tietokannasta kyseinen
soittolista ja soittolistabiisit (playlists, playlist_track) -->

<?php

require "dbconnection.php";
$dbcon = createDbConnection();



if (isset($_GET['playlistId'])) {
    $playlistId = $_GET['playlistId'];

    $deleteTracksQuery = "DELETE FROM playlist_track WHERE playlistId = :playlistId";
    $deleteTracksStatement = $dbcon->prepare($deleteTracksQuery);
    $deleteTracksStatement->bindValue(':playlistId', $playlistId, PDO::PARAM_INT);
    $deleteTracksStatement->execute();

    echo "Kaikki rivit, joissa playlistId on $playlistId, on poistettu onnistuneesti.";
} else {
    echo "Tarkista parametri";
}



