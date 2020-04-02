<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="stylesheet.css" />
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <?php include("fonctions.php"); ?>

    <title>Synthèse</title>

    <script> 
        $(document).ready(function() {
            /* Raffraichissement des messages */
                function refresh() {
                    $.ajax({ //appelle à la fonction ajax par jquery
                        url: "recuperer.php", //emplacement du fichier
                        success:
                            function(retour) {  
                                $("#div_messages").html(retour); //rafraichit le contenu de la div
                            }
                    })
                }
                setInterval(refresh, 1000); //répéte la fonction toutes les 3 secondes
                //utiliser setInterval : pas de () sur la fonction sauf pour la déclarer dans le setInterval
                //setInterval(function(){ alert("Hello"); }, 3000);
            

            /* Activation du formulaire avec Enter */
                $("#zoneEcriture").keypress(function(e) {
                    if(e.which == 13) {
                        $("#boutonEnvoi").click();
                    }
                });
            
        });

        /*ecriture d'un message */
            function ecrireMessage() {
                var auteurV = $("#auteurForm").val();
                //alert("Ecrire auteur "+auteur);
                var texteV = $("#zoneEcriture").val();
                //alert("Ecrire texte "+ texte);
                $.get("enregistrement.php", {auteurForm : auteurV, zoneEcriture : texteV});
                
                //vider zone de texte
                $('#zoneEcriture').val('');
            }
            

        /*choix de l'auteur du message*/
            function changerAuteur() {
                select = document.getElementById("Select_contact");
                choice = select.selectedIndex;
                valeur = select.options[choice].value; // apparait auteur changé 
                //document.getElementById("Select_contact").value = valeur;
                //texte = select.options[choice].text;
                alert(valeur);
                document.getElementById('auteurForm').value = valeur;
                //ajouter l'affectation au hidden
                
            }
    </script>
</head>
<body>
    <h1>Page synthèse</h1>
    <!-- Utiliser un input pour choisir l'user -->
    <div id="div_contact">
        <p><label for="auteur">Auteur :</label>
            <select name="Select_contact" id="Select_contact" onchange="changerAuteur();">
                <?php
                $conn = connecterBDD();
                $listeContact="SELECT DISTINCT auteur from chat order by auteur";
                $reponse = $conn->query($listeContact);
                while ($donnees = $reponse->fetch())
                {
                    ?>
                    <option id="choixAuteur" value="<?php echo($donnees['auteur'])?>">
                        <?php echo($donnees['auteur'])?>
                    </option>
                <?php } ?>
            </select>
        </p>
    </div>
    <div class="chat">
        <div id="div_messages"></div>
    </div>
    <div id="div_nv_message">
        <!-- <form id="enregistrement_form" method="get" action="page_synthese.php"> 
                enlever le form et le get. Utiliser get dans le xhr jquery (voir tp3, ex1)-->
        <!--<form id="enregistrement_form" method="get" action="enregistrement.php">
            <p><input type="hidden" name="auteurForm" id='auteurForm' value=''></p>
            <p class="titre">Message</p>
            <textarea id="zoneEcriture" name="zoneEcriture" rows="5" cols="40" form="enregistrement_form"></textarea>
            <p id="buttons">
                <input id="boutonEnvoi" type="submit" value="Enregistrer"/>
            </p> 
        </form> -->
        <p><input type="hidden" name="auteurForm" id='auteurForm' value=''></p>
        <p class="titre">Message</p>
        <textarea id="zoneEcriture" name="zoneEcriture" rows="5" cols="40" form="enregistrement_form"></textarea>
        <p id="buttons">
            <input id="boutonEnvoi" type="submit" value="Enregistrer" onclick="ecrireMessage();"/>
        </p> 
    </div>
</body>
</html>