<?php
/*Connection à la base de donnée*/
$mysqli = new mysqli("localhost", "root", "Tr14-upA", $argv[1]);
if ($mysqli->connect_errno) {
    echo "Échec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

/*Ouverture du fichier .csv*/

$data = @fopen($argv[2], "r");
if ($data == null) {
    echo "FAILED";
    exit(1);
}

/*Initialisation et/ou initialisation de la base de données*/
$mysqli->query("CREATE TABLE if not exists data(strategy_id INT, Updated DATE, Confirmed INT, ConfirmedChange INT, Deaths INT, DeathsChange INT, Recovered INT, RecoveredChange INT, Gps POINT, Iso2 VARCHAR(10), Iso3 VARCHAR(10), CountryRegion VARCHAR (50), AdminRegion1 VARCHAR (100), AdminRegion2 VARCHAR (100))");
$last_id =  mysqli_fetch_row($mysqli->query("SELECT MAX(id) FROM data"))[0];

/*Affichage*/
date_default_timezone_set("Europe/Paris");
echo "Ne surtout pas arreter le programme lors de l'update sinon il faudra recommencer depuis le debut.\nLa première initialisation dure environ 1h\n";
echo "Il est ". date("H:i:s",time()).", debut du transfert\n";

/*Update*/
$first_line = fgetcsv($data, 160, ",");
while ($first_line = fgetcsv($data, 160, ",")) {

    if ($first_line[0] > $last_id) {

        $date =  '"' . date("Y-m-d", strtotime($first_line[1])) . '"';
        $location = 'NULL';
        if ($first_line[8] != '' && $first_line[9] != '') {
            $location = 'POINT(' . $first_line[8] . ' ' . $first_line[9] . ')';
            $location = '"' . $location . '"';
        }
        for ($col = 0; $col < 15; $col++) {
            if ($first_line[$col] == '')
                $first_line[$col] = 'NULL';
            else
                $first_line[$col] = '"' . $first_line[$col] . '"';
        }
        if (!$mysqli->query("INSERT INTO data VALUES ($first_line[0],$date,$first_line[2],$first_line[3],$first_line[4],$first_line[5],$first_line[6],$first_line[7],ST_PointFromText($location),$first_line[10],$first_line[11],$first_line[12],$first_line[13],$first_line[14])"))
            echo "Échec lors de l'insertion' de la table : (" . $mysqli->errno . ") " . $mysqli->error . "\n";
    }
}
fclose($data);
