<!doctype html>
<html lang="fr">

<head>
    <!-- Encodage utf-8 -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <!-- Auteur du site -->
    <meta name="author" content="Delhaye Martin" />
    <!-- Description -->
    <meta name="description" content="Site de présentaion de l'attraction Tonnerre 2 Zeus" />
    <!-- Mots clé -->
    <meta name="keywords" content="tonerre, ZEUS, manège, roller coaster, Parc, Astérix " />
    <!-- link favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../Image/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Image/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Image/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="../Image/favicon_io/site.webmanifest">
    <!-- Link CSS -->
    <link href="../CSS/Style.css" rel="stylesheet" type="text/css">
    <!-- Titre -->
    <title>Avis</title>
</head>

<body>
    <header class="bordure">
        <a href="../index.html" title="retour acceuil">
            <img class="logo" src="../Image/nv_logo_T2Z.png" alt="logo Tonnerre de Zeus" title="logo Tonnerre de Zeus" />
        </a>
        <nav>
            <ul>
                <li>
                    <a class="bordure_interaction" href="../histoire.html"> Histoire </a>
                </li>
                <li>
                    <a class="bordure_interaction" href="../Caracteristique.html"> Caracteristiques</a>
                </li>
                <li>
                    <a class="bordure_interaction" href="../position.html">Position</a>
                </li>
                <li>
                    <a class="bordure_interaction" href="../Formulaire.html">Formulaire</a>
                </li>
                <li>
                    <a class="bordure_interaction" href="../PHP/recuperation_donnees_formulaire_T2Z.php">Avis</a>
                </li>
            </ul>
        </nav>
    </header>
    <img class="img_perso" src="../Image/assurancetourix.png" alt="assurancetourix" title="assurancetourix" />
    <div id="block_central" class="bordure">
        <h1> Les avis </h1>
        <p>
            <?php
                if(isset($_POST["prenom"]) && isset($_POST["nom"])){       //vérifie si "prenom" et "nom" sont définie, donc si on a rempli le formulaire car ils sont en required
                    echo "Merci ". $_POST["prenom"] ." ". $_POST["nom"] ." d'avoir rempli notre formulaire <br>";    

                    // Définie les clés spécifiques de bases que je veux sauvegarder dans un tableau
                    $clesAConserver = ["nom", "prenom", "Ancienne", "Nouvelle"];

                    // Rajoute les clés à sauvegarder en fonction de la case cocher 
                    if(isset($_POST["Ancienne"])) {
                        echo "Nous espérons que l'ancienne version ne vous manque pas trop <br>";
                        $clesAConserver[] = "anc_note";
                        $clesAConserver[] = "anc_resenti";
                        $clesAConserver[] = "anc_avis";
                        echo "Vous avez mit une note de : ". $_POST["anc_note"]. "/10 à l'ancienne version <br>";
                    }
                    if(isset($_POST["Nouvelle"])) {
                        $clesAConserver[] = "nvl_note";
                        $clesAConserver[] = "nvl_resenti";
                        $clesAConserver[] = "nvl_avis";
                        $clesAConserver[] = "nvl_recommendation";
                        echo "Vous avez mit une note de : ". $_POST["nvl_note"]. "/10 à la nouvelle version <br>";
                    }
                    if(isset($_POST["Nouvelle"]) && isset($_POST["Ancienne"])) {
                        $clesAConserver[] = "preferer";
                        echo "Votre version favorite est : ". $_POST["preferer"];
                    }
                    // Créer un tableau avec les valeurs spécifiques de $_POST
                    $valeursAConserver = [];
                    foreach ($clesAConserver as $cle) {
                        if (isset($_POST[$cle])) {
                            $valeursAConserver[$cle] = $_POST[$cle];
                        }
                    }
                    //enregistre les données du formulaire dans le fichier Tableau_formulaire.txt
                    $savetab = serialize($valeursAConserver);
                    $fichier = fopen("Tableau_formulaire.txt", "a+");
                    fwrite($fichier, $savetab . PHP_EOL);  // PHP_EOL sépare les sérialisations par des sauts à la ligne 
                    fclose($fichier);
                }

                // Défini certaines variables pour éviter des erreurs
                $sommeAncNote = 0;
                $nombreAncNote = 0;
                $sommeNvlNote = 0;
                $nombreNvlNote = 0;
                $nombreAncienne = $nombreNouvelle = 0;
                $nombreAns_resenti_oui = 0;
                $nombreAns_resenti_peu = 0;
                $nombreAns_resenti_non = 0;
                $nombreAns_resenti_nsp = 0;

                $nombreNvl_resenti_oui = 0;
                $nombreNvl_resenti_peu = 0;
                $nombreNvl_resenti_non = 0;
                $nombreNvl_resenti_nsp = 0;

                $nombreNvl_recommendation_oui = 0;
                $nombreNvl_recommendation_non = 0;

                if (file_exists("Tableau_formulaire.txt")) {                //vérifie si le fichier existe 
                                   
                    // Lire le contenu du fichier
                    $contenu = file_get_contents("Tableau_formulaire.txt");  //$contenu récupère le contenue du mon fichier text Tableau_formulaire.txt

                    // Diviser le contenu en lignes
                    $tab = explode(PHP_EOL, $contenu); // explode divise la chaîne $contenu en un tableau ou chaque élément correspond à une ligne séparer par PHP_EOL
                    
                    
                    // Parcourir chaque ligne
                    foreach ($tab as $ligne) {
                        // Désérialiser la ligne
                        $donnees = unserialize($ligne);

                        // Vérifier si la clé "anc_note" existe
                        if (isset($donnees["anc_note"])) {
                            // Ajouter la valeur à la somme et augmente le nombre de note de 1
                            $sommeAncNote += $donnees["anc_note"];
                            $nombreAncNote++;
                        }
                        // Vérifier si la clé "nvl_note" existe
                        if (isset($donnees["nvl_note"])) {
                            $sommeNvlNote += $donnees["nvl_note"];
                            $nombreNvlNote++;
                        }
                        // Vérifier si la clé "preferer" existe
                        if (isset($donnees["preferer"])) {
                            // Vérifier la valeur de "preferer" et incrémenter le compteur associé
                            if ($donnees["preferer"] == "Ancienne") {
                                $nombreAncienne++;
                            } 
                            elseif ($donnees["preferer"] == "Nouvelle") {
                                $nombreNouvelle++;
                            }
                        }
                        // Vérifier si la clé "anc_resenti" existe
                        if (isset($donnees["anc_resenti"])){
                            if ($donnees["anc_resenti"] == "Oui, beaucoup") {
                                $nombreAns_resenti_oui++;
                            }
                            if ($donnees["anc_resenti"] == "Un peu") {
                                $nombreAns_resenti_peu++;
                            }
                            if ($donnees["anc_resenti"] == "Non, pas tu tout") {
                                $nombreAns_resenti_non++;
                            }
                            if ($donnees["anc_resenti"] == "Ne sais pas") {
                                $nombreAns_resenti_nsp++;
                            }
                        }
                        // Vérifier si la clé "anc_resenti" existe
                        if (isset($donnees["nvl_resenti"])){
                            if ($donnees["nvl_resenti"] == "Oui, beaucoup") {
                                $nombreNvl_resenti_oui++;
                            }
                            if ($donnees["nvl_resenti"] == "Un peu") {
                                $nombreNvl_resenti_peu++;
                            }
                            if ($donnees["nvl_resenti"] == "Non, pas tu tout") {
                                $nombreNvl_resenti_non++;
                            }
                            if ($donnees["nvl_resenti"] == "Ne sais pas") {
                                $nombreNvl_resenti_nsp++;
                            }
                        }
                        // Vérifier si la clé "anc_resenti" existe
                        if (isset($donnees["nvl_recommendation"])){
                            if ($donnees["nvl_recommendation"] == "Oui") {
                                $nombreNvl_recommendation_oui++;
                            }
                            if ($donnees["nvl_recommendation"] == "Non") {
                                $nombreNvl_recommendation_non++;
                            }                       
                        }
                    }
                }
                // Calculer la moyenne des notes de l'ancienne version 
                if ($nombreAncNote > 0){
                    $moyenneAncNote = number_format(($sommeAncNote / $nombreAncNote), 2, ',', '');
                }
                else{
                    $moyenneAncNote = 0;
                }
                // Calculer la moyenne des notes de la nouvelle version 
                if ($nombreNvlNote > 0){
                    $moyenneNvlNote = number_format(($sommeNvlNote / $nombreNvlNote), 2, ',', '');
                }
                else{
                    $moyenneNvlNote = 0;
                }
                // Calculer les pourcentages pour le préféré 
                $totalPreferer = $nombreAncienne + $nombreNouvelle;
                if ($totalPreferer > 0) {
                    $pourcentageAncienne = number_format(($nombreAncienne / $totalPreferer * 100), 2, ',', '');
                    $pourcentageNouvelle = number_format(($nombreNouvelle / $totalPreferer * 100), 2, ',', '');
                }
                else{
                    $pourcentageAncienne = 0;
                    $pourcentageNouvelle = 0;
                }                

                // Calculer les pourcentages pour les resentis de l'ancienne version
                $totalAnc_resenti = $nombreAns_resenti_oui + $nombreAns_resenti_peu + $nombreAns_resenti_non + $nombreAns_resenti_nsp;
                if ($totalAnc_resenti > 0) {
                    $pourcentageAnc_resenti_oui = number_format(($nombreAns_resenti_oui / $totalAnc_resenti * 100), 2, ',', '');
                    $pourcentageAnc_resenti_peu = number_format(($nombreAns_resenti_peu / $totalAnc_resenti * 100), 2, ',', '');
                    $pourcentageAnc_resenti_non = number_format(($nombreAns_resenti_non / $totalAnc_resenti * 100), 2, ',', '');
                    $pourcentageAnc_resenti_nsp = number_format(($nombreAns_resenti_nsp / $totalAnc_resenti * 100), 2, ',', '');
                }
                else{
                    $pourcentageAnc_resenti_oui = 0;
                    $pourcentageAnc_resenti_peu = 0;
                    $pourcentageAnc_resenti_non = 0;
                    $pourcentageAnc_resenti_nsp = 0;
                }
                // Calculer les pourcentages pour les resentis de la nouvelle version
                $totalNvl_resenti = $nombreNvl_resenti_oui + $nombreNvl_resenti_peu + $nombreNvl_resenti_non + $nombreNvl_resenti_nsp;
                if ($totalNvl_resenti > 0) {
                    $pourcentageNvl_resenti_oui = number_format(($nombreNvl_resenti_oui / $totalNvl_resenti * 100), 2, ',', '');
                    $pourcentageNvl_resenti_peu = number_format(($nombreNvl_resenti_peu / $totalNvl_resenti * 100), 2, ',', '');
                    $pourcentageNvl_resenti_non = number_format(($nombreNvl_resenti_non / $totalNvl_resenti * 100), 2, ',', '');
                    $pourcentageNvl_resenti_nsp = number_format(($nombreNvl_resenti_nsp / $totalNvl_resenti * 100), 2, ',', '');
                }
                else{
                    $pourcentageNvl_resenti_oui = 0;
                    $pourcentageNvl_resenti_peu = 0;
                    $pourcentageNvl_resenti_non = 0;
                    $pourcentageNvl_resenti_nsp = 0;
                }
                // Calculer les pourcentages pour les recommendations de la nouvelle version
                // Calculer les pourcentages pour le préféré 
                $totalRecommendation = $nombreNvl_recommendation_oui + $nombreNvl_recommendation_non;
                if ($totalRecommendation > 0) {
                    $pourcentage_recommendation_oui = number_format(($nombreNvl_recommendation_oui / $totalRecommendation * 100), 2, ',', '');
                }
                else{
                    $pourcentage_recommendation_oui = 0;
                }    
                
            ?>
        </p>
        <div class="comparatif">
            <section class="bordure">
                <h3> Ancienne Version : </h3>
                <!-- Afficher la moyenne -->
                <p>La moyenne des notes de l'ancienne version est de  : <?php echo $moyenneAncNote; ?></p>
                <p>Pour les resentis : </p>
                <p> <?php echo $pourcentageAnc_resenti_oui; ?>% on répondu "Oui, beaucoup"</p>
                <p> <?php echo $pourcentageAnc_resenti_peu; ?>% on répondu "Un peu"</p>
                <p> <?php echo $pourcentageAnc_resenti_non; ?>% on répondu "Non, pas tu tout"</p>
                <p> <?php echo $pourcentageAnc_resenti_nsp; ?>% on répondu "Ne sais pas"</p>
                <p>Nombre total de personnes ayant donnée une note : <?php echo $nombreAncNote; ?></p>


            </section>
            <section class="bordure">
                <h3> Nouvelle Version : </h3>
                <!-- Afficher la moyenne -->
                <p>La moyenne des notes de la nouvelle version est de : <?php echo $moyenneNvlNote; ?></p>
                <p>Pour les resentis : </p>
                <p> <?php echo $pourcentageNvl_resenti_oui; ?>% on répondu "Oui, beaucoup"</p>
                <p> <?php echo $pourcentageNvl_resenti_peu; ?>% on répondu "Un peu"</p>
                <p> <?php echo $pourcentageNvl_resenti_non; ?>% on répondu "Non, pas tu tout"</p>
                <p> <?php echo $pourcentageNvl_resenti_nsp; ?>% on répondu "Ne sais pas"</p>
                <p><?php echo $pourcentage_recommendation_oui; ?>% des personnes l'ayant tester la recommande</p>
                <p>Nombre total de personnes ayant testé cette version : <?php echo $nombreNvlNote; ?></p> 
                <p>De plus <?php echo $pourcentage_recommendation_oui; ?>% des personnes l'ayant tester la recommande</p>
                

            </section>
        </div>
        <div class="bordure">
            <h3> Pourcentages des votes de la meilleurs version  : </h3>
            <p>Ancienne version : <?php echo $pourcentageAncienne; ?>%</p>
            <p>Nouvelle version : <?php echo $pourcentageNouvelle; ?>%</p>
            <p>Nombre total de personnes ayant voté : <?php echo $totalPreferer; ?></p>
        </div>
        <!-- Permet de remonter la page -->
        <a id="retour_top" class="bordure_interaction" href="#" title=" retour haut de la page">
            <img src="../Image/fleche_retour_top.png" alt="fleche qui pointe vers le haut" title="retour haut de la page">
            Haut de la page
        </a>
    </div>
    <a class="retour_index bordure_interaction" href="../index.html" title="Retour page d'acceuil">
        <img src="../Image/retour_index_unscreen.gif" alt="bâtiment Grec en 3D" title="Retour acceuil" />
        Acceuil
    </a>


</body>