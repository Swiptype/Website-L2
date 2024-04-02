<?php
require_once("Lib.php");

$action = key_exists('action',$_GET)? trim ($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
switch($action) {

    case "":
        $zonePrincipale = "<h2>Pages visitables : </h2>";
        break;

    case "liste":
        $corps="<h1>Liste des menus</h1>";
        $connection = connecter();
        $requete="SELECT * FROM MENU";

        $query = $connection->query($requete);
        
        $query->setFetchMode(PDO::FETCH_OBJ);

        $corps.= "<h4>
        <span class='c1'><b>IdMenu</span> 
        <span class='c1'>Nom du menu</b></span>
        </h4>";

        while($enregistrement = $query->fetch())
        {
            $idMenu=$enregistrement->idMenu;
            $ENTREE=$enregistrement->ENTREE;
            $PLAT=$enregistrement->PLAT;
            $DESSERT=$enregistrement->DESSERT;
            $BOISSON=$enregistrement->BOISSON;
            $NOM_DU_MENU=$enregistrement->NOM_DU_MENU;

            $tab_menus[$idMenu]=array($ENTREE,$PLAT,$DESSERT,$BOISSON,$NOM_DU_MENU);

            $corps.= "<span class='c1'>".$enregistrement->idMenu."</span> <span class='c1'>". $enregistrement->NOM_DU_MENU."</span>";
			$corps.=  '<span class=\'c1\'><a href="index.php?action=select&idMenu='. $enregistrement->idMenu.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
			$corps.=  '<a href="index.php?action=update&idMenu='. $enregistrement->idMenu.'"><span class="glyphicon glyphicon-pencil"></span></a>';
			$corps.=  '<a href="index.php?action=delete&idMenu='. $enregistrement->idMenu.'"><span class="glyphicon glyphicon-trash"></span></a></span>';
			$corps.="<br>";
        }
        $zonePrincipale=$corps;
        $query=null;
        $connection=null;
        break;
    
    case "insert":
        $cible='insert';
        if(!isset($_POST["ENTREE"]) && !isset($_POST["PLAT"]) && !isset($_POST["DESSERT"]) && !isset($_POST["BOISSON"]) && !isset($_POST["NOM_DU_MENU"]))
        {
            include("formulaireMenu.html");
        }
        else{
            $ENTREE = key_exists('ENTREE', $_POST)? trim($_POST['ENTREE']):null;
            $PLAT = key_exists('PLAT', $_POST)? trim($_POST['PLAT']):null;
            $DESSERT = key_exists('DESSERT', $_POST)? trim($_POST['DESSERT']):null;
            $BOISSON = key_exists('BOISSON', $_POST)? trim($_POST['BOISSON']):null;
            $NOM_DU_MENU = key_exists('NOM_DU_MENU', $_POST)? trim($_POST['NOM_DU_MENU']):null;
            if ($ENTREE=="") $erreur["ENTREE"] = "Il manque l'entrée. Entrez 'aucun' si vous souhaitez ne pas en mettre.";
            if ($PLAT=="") $erreur["PLAT"] = "Il manque le plat.";
            if ($DESSERT=="") $erreur["DESSERT"] = "Il manque le dessert. Entrez 'aucun' si vous souhaitez ne pas en mettre";
            if ($BOISSON=="") $erreur["BOISSON"] = "Il manque la boisson.";
            if ($NOM_DU_MENU=="") $erreur["NOM_DU_MENU"] = "Veuillez nommer votre menu.";
            $compter_erreur = count($erreur);
            foreach($erreur as $cle=>$valeur){
                if ($valeur==null){
                    $compter_erreur=$compter_erreur-1;
                }
            }
            if ($compter_erreur == 0){
                $connection = connecter();

                $requete = "INSERT INTO MENU (`entree`,`plat`,`dessert`,`boisson`,`nom_du_menu`) VALUES ('" . $ENTREE . "', '" . $PLAT . "', '" . $DESSERT . "', '" . $BOISSON . "', '" . $NOM_DU_MENU . "')";
                $query = $connection->query($requete);

                $zonePrincipale="";
                $connection=null;
            }
            else{
                include("formulaireMenu.html");
            }
        }
        break;

    case "select":
        $corps = "<h2>Détails</h2>";
        $idMenu = key_exists('idMenu', $_GET)? trim($_GET['idMenu']): null;
        $connection = connecter();
        $requete = "SELECT * FROM MENU WHERE `idMenu` = '" . $idMenu . "';";

        $query = $connection->query($requete);
    
        $query->setFetchMode(PDO::FETCH_OBJ);

        $corps.= "<h4>
        <span class='c1'><b><u>IdMenu</u></b></span>
        <span class='c1'><b><u>Entrée</u></b></span>
        <span class='c1'><b><u>Plat</u></b></span>
        <span class='c1'><b><u>Dessert</u></b></span>
        <span class='c1'><b><u>Boisson</u></b></span>
        <span class='c1'><b><u>Nom du menu</u></b></span>
        </h4>";
    
        while( $enregistrement = $query->fetch() )
        {
            $idMenu=$enregistrement->idMenu;
            $ENTREE=$enregistrement->ENTREE;
            $PLAT=$enregistrement->PLAT;
            $DESSERT=$enregistrement->DESSERT;
            $BOISSON=$enregistrement->BOISSON;
            $NOM_DU_MENU=$enregistrement->NOM_DU_MENU;

            $tab_menus[$idMenu]=array($ENTREE,$PLAT,$DESSERT,$BOISSON,$NOM_DU_MENU);
            $corps.= "<span class='c1'>".$enregistrement->idMenu."</span> <span class='c1'>".$enregistrement->ENTREE." </span><span class='c1'>". $enregistrement->PLAT."</span>  <span class='c1'>".$enregistrement->DESSERT."</span>  <span class='c1'>".$enregistrement->BOISSON."</span>  <span class='c1'>".$enregistrement->NOM_DU_MENU."</span>";
            $corps.="<br>";
      
        }
    
        $zonePrincipale=$corps ;
        $query = null;
        $connection = null;
    
        break;    
    
    case 'sauvegarde':
        $connection =connecter();
        $idMenu = key_exists('idMenu',$_POST)? $_POST['idMenu']: null;
        $type = $_POST["type"];
        $sql = $_POST["sql"];
        if ($type =='confirmupdate'){
            $corps="<h1>Mise à jour du menu n° ".$idMenu."</h1>" ;
        }
        else{
            $corps="<h1>Suppression du menu n° ".$idMenu."</h1>" ;
        }
        $query = $connection->query($sql);
        $zonePrincipale=$corps;
        $connection = null;
        break;
    
    case "update":
        $cible='update';
        $idMenu=$_GET["idMenu"];
        $connection =connecter();

        $requete="SELECT * FROM MENU where idMenu=$idMenu";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() )
        {
            $idMenu=$enregistrement->idMenu;
            $ENTREE=$enregistrement->ENTREE;
            $PLAT=$enregistrement->PLAT;
            $DESSERT=$enregistrement->DESSERT;
            $BOISSON=$enregistrement->BOISSON;
            $NOM_DU_MENU=$enregistrement->NOM_DU_MENU;
            
        }

        if(!isset($_POST["ENTREE"]) && !isset($_POST["PLAT"]) && !isset($_POST["DESSERT"]) && !isset($_POST["BOISSON"]) && !isset($_POST["NOM_DU_MENU"])){
            include("formulaireMenu.html");
        }
        else{
            
            $ENTREE = key_exists('ENTREE', $_POST)? trim($_POST['ENTREE']): null;
            $PLAT = key_exists('PLAT', $_POST)? trim($_POST['PLAT']): null;
            $DESSERT = key_exists('DESSERT', $_POST)? trim($_POST['DESSERT']): null;
            $BOISSON = key_exists('BOISSON', $_POST)? trim($_POST['BOISSON']): null;
            $NOM_DU_MENU = key_exists('NOM_DU_MENU', $_POST)? trim($_POST['NOM_DU_MENU']): null;
                    
            if ($ENTREE=="") $erreur["ENTREE"] ="il manque une entrée";  
            if ($PLAT=="") $erreur["PLAT"] ="il manque un plat";    
            if ($DESSERT=="") $erreur["DESSERT"] ="il manque un horaire dessert"; 
            if ($BOISSON=="") $erreur["BOISSON"] ="il manque une boisson";
            if ($NOM_DU_MENU=="") $erreur["NOM_DU_MENU"] ="il manque un nom pour le menu";	
                        
            $compteur_erreur=count($erreur);

            foreach ($erreur as $cle=>$valeur){
                if ($valeur==null) $compteur_erreur=$compteur_erreur-1;
            }

            if ($compteur_erreur == 0) {
                $connection = connecter();

                $sql="UPDATE MENU SET ENTREE='$ENTREE' WHERE idMenu=$idMenu";

                include("formulaireUpdate.html");

                $zonePrincipale=$corps;
                $connection=null;
            }
            else {
                include("formulaireMenu.html");
            }
        }

        break;
    
    case "delete":
        $idMenu = key_exists('idMenu', $_GET)? trim($_GET['idMenu']): null;
        $sql = "DELETE FROM MENU WHERE `idMenu` like " . $idMenu . ";";
        $connection = connecter();
        include("formulaireDelete.html");
    
        break;
    
    case "about":

        $NOM_DU_MENU = key_exists('NOM_DU_MENU', $_GET) ? trim($_GET['NOM_DU_MENU']) : null;
        $ENTREE = key_exists('ENTREE', $_GET) ? trim($_GET['ENTREE']) : null;
        $PLAT = key_exists('PLAT', $_GET) ? trim($_GET['PLAT']) : null;
        $DESSERT = key_exists('DESSERT', $_GET) ? trim($_GET['DESSERT']) : null;
        $BOISSON = key_exists('BOISSON', $_GET) ? trim($_GET['BOISSON']) : null;
        
        $corps="<h1>Liste des menus</h1>";
        
        $corps= "<h1>A propos</h1>";
        $corps.= "22106104";
        $corps.= "<br>";
        $corps.= "Genestier Théo";
        $corps.= "<br>";
        $corps.= "Le update ne fonctionne pas";
        $corps.= "<br>";
        $corps.= "Le complément est visible quand on clique sur le lien complement dans la case à droite.";
        $corps.= "<br>";
        $corps.= "il s'agit d'un système de recherche de menu. Ecrivez le nom d'un menu et une nouvelle page s'affiche avec les détails du menu recherché.";

        $zonePrincipale=$corps;
        $query=null;
        $connection=null;
                
        break;

    case "complement":

        $NOM_DU_MENU = key_exists('NOM_DU_MENU', $_GET) ? trim($_GET['NOM_DU_MENU']) : null;
        $ENTREE = key_exists('ENTREE', $_GET) ? trim($_GET['ENTREE']) : null;
        $PLAT = key_exists('PLAT', $_GET) ? trim($_GET['PLAT']) : null;
        $DESSERT = key_exists('DESSERT', $_GET) ? trim($_GET['DESSERT']) : null;
        $BOISSON = key_exists('BOISSON', $_GET) ? trim($_GET['BOISSON']) : null;
            
        $corps="<h1>Liste des menus</h1>";
        $connection = connecter();
            
        $requete = "SELECT * FROM MENU WHERE NOM_DU_MENU LIKE '$NOM_DU_MENU%' OR ENTREE LIKE '$ENTREE%' OR PLAT LIKE '$PLAT%' OR DESSERT LIKE '$DESSERT%' OR BOISSON LIKE '$BOISSON%'";
            
        $query = $connection->query($requete);
            
        $query->setFetchMode(PDO::FETCH_OBJ);
            
        $corps.= "<form method='get' action='result.php'>";
        $corps.= "<input type='text' placeholder='Rechercher...' name='search'>";
        $corps.= "<input type='submit' value='Rechercher'";
        $corps.= "</form>";
        $corps.= "<br>";
                    
        while ($row = $query->fetch()) {
            $idMenu=$row->idMenu;
            $NOM_DU_MENU = $row->NOM_DU_MENU;
            $ENTREE = $row->ENTREE;
            $PLAT = $row->PLAT;
            $DESSERT = $row->DESSERT;
            $BOISSON = $row->BOISSON;
    
        }
            
        $zonePrincipale=$corps;
        $query=null;
        $connection=null;
                    
        break;

        
   
default:
        $zonePrincipale="";
        break;
}

include("squelette.php");

?>