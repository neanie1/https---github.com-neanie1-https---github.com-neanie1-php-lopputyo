<!-- Lisää koodiin muuttaja nimeltä artist_id. Tiedosto hakee ja palauttaa JSON muodossa artistin nimen ja sekä artistin albumit ja albumien kappaleet. -->

<?php
require "dbconnection.php";
$dbcon = createDbConnection();

if (isset($_GET['artist_id'])) {
    $artistId = $_GET['artist_id'];

  
    $artistQuery = "SELECT Name FROM artists WHERE ArtistId = :artistId";
    $artistStatement = $dbcon->prepare($artistQuery);
    $artistStatement->bindValue(':artistId', $artistId, PDO::PARAM_INT);
    $artistStatement->execute();
    $artistName = $artistStatement->fetchColumn();

  
    $albumsQuery = "SELECT AlbumId, Title FROM albums WHERE ArtistId = :artistId";
    $albumsStatement = $dbcon->prepare($albumsQuery);
    $albumsStatement->bindValue(':artistId', $artistId, PDO::PARAM_INT);
    $albumsStatement->execute();
    $albums = $albumsStatement->fetchAll(PDO::FETCH_ASSOC);

   
    foreach ($albums as &$album) {
        $albumId = $album['AlbumId'];
        $tracksQuery = "SELECT Name FROM tracks WHERE AlbumId = :albumId";
        $tracksStatement = $dbcon->prepare($tracksQuery);
        $tracksStatement->bindValue(':albumId', $albumId, PDO::PARAM_INT);
        $tracksStatement->execute();
        $tracks = $tracksStatement->fetchAll(PDO::FETCH_COLUMN);
        $album['Tracks'] = $tracks;
    }

    $data = [
        'artistName' => $artistName, 
        'albums' => $albums
    ];
    $jsonData = json_encode($data);

    
    header('Content-Type: application/json');
    echo $jsonData;

} else {
    echo "Virhe";
}