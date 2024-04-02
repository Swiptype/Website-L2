<?php
require_once("Lib.php");

$search = key_exists('search', $_GET) ? trim($_GET['search']) : null;

$connection = connecter();
$requete = "SELECT * FROM MENU WHERE NOM_DU_MENU LIKE '$search%' OR ENTREE LIKE '$search%' OR PLAT LIKE '$search%' OR DESSERT LIKE '$search%' OR BOISSON LIKE '$search%'";
$query = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);

if($query->rowCount() == 0){
    $corps = "<span class='c1'>Aucun resultat</span>";
}else{
    $corps="<h1>Résultats de la recherche</h1>";

    $corps.= "<h4>
            <span class='c1'><b><u>IdMenu</u></b></span>
            <span class='c1'><b><u>Entrée</u></b></span>
            <span class='c1'><b><u>Plat</u></b></span>
            <span class='c1'><b><u>Dessert</u></b></span>
            <span class='c1'><b><u>Boisson</u></b></span>
            <span class='c1'><b><u>Nom du menu</u></b></span>
            </h4>";
    while ($row = $query->fetch()) {
        
        $corps.= "<tr><td class='tdM'><span class='c1'>".$row->idMenu."</span> <span class='c1'>".$row->ENTREE." </span><span class='c1'>". $row->PLAT."</span>  <span class='c1'>".$row->DESSERT."</span>  <span class='c1'>".$row->BOISSON."</span>  <span class='c1'>".$row->NOM_DU_MENU."</span></tr></td>";
        $corps.="<br>";
    }
}

$zonePrincipale = $corps;
$query=null;
$connection=null;

include("squeletteres.php");
?>
