<?php

//fonctions utiles
function connecter()
{
    try {

        //A compléter 
        $dns = 'mysql:host=mysql.info.unicaen.fr;port=3306;dbname=genesti211_prod;charset=utf8';
        $utilisateur = 'genesti211';
        $motDePasse = 'Vu7yieh5zae6ooTh';
        
        // Options de connection
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        );
        $connection = new PDO( $dns, $utilisateur, $motDePasse, $options );
        return($connection);
    
    
    } catch ( Exception $e ) {
        echo "Connection à MySQL impossible : ", $e->getMessage();
        die();
    }
}

class Menu
{
    private $idMenu;
    private $ENTREE;
    private $PLAT;
    private $DESSERT;
    private $BOISSON;
    private $NOM_DU_MENU;

    //Constructeur
    public function __construct($idMenu,$ENTREE,$PLAT,$DESSERT,$BOISSON,$NOM_DU_MENU)
    {
        $this->idMenu=$idMenu;
        $this->ENTREE=$ENTREE;
        $this->PLAT=$PLAT;
        $this->DESSERT=$DESSERT;
        $this->BOISSON=$BOISSON;
        $this->NOM_DU_MENU=$NOM_DU_MENU;
    }

    //
    public function __toString()
    {
        $ligneT= "(<u><b>".$this->idMenu."</b></u>, ".$this->ENTREE."," .$this->PLAT.", ". $this->DESSERT.", ". $this->BOISSON.", ".$this->NOM_DU_MENU. " )<br>";
        return $ligneT;
    }
}



$idMenu=null;$ENTREE=null;$PLAT = null;$DESSERT = null;$BOISSON = null;$NOM_DU_MENU = null;			
$erreur=array("ENTREE"=>null,"PLAT"=>null,"DESSERT"=>null,"BOISSON"=>null,"NOM_DU_MENU"=>null);
$tab_menus=array();
?>
