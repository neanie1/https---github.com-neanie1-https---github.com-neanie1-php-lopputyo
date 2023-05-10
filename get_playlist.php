<!-- Lisää koodiin muuttaja nimeltä playlist_id. Tiedosto hakee kyseisen soittolistan
kappaleiden nimet ja kappaleiden säveltäjät ja tulostaa ne echolla. 
<?php
require "dbconnection.php";
$dbcon = createDbConnection();

$sql = "SELECT * FROM tracks";

$statement = $dbcon->prepare($sql);
$statement->execute();

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $playlist_id) {
    echo "<h3>".$playlist_id["Name"]."</h3>"."(".$playlist_id["Composer"].")"."<br>";
}

