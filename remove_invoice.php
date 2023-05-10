 <!-- Lisää koodiin muuttuja nimeltä invoice_item_id. Poista tietokannasta invoice_item tällä id:llä.

<?php
require "dbconnection.php";
$dbcon = createDbConnection();

 $invoice_item_id =  "DROP TABLE invoice_items";
 $dbcon->exec($invoice_item_id); 
