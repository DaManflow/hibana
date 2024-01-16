<?php
require_once "view_begin.php";
?>
<style>
    .icone { width: 16px; }
    .listePages { width : 400px; margin : auto; padding-top : 20px; text-align: center; }
    .listePages p { color : blue; padding: 0px; margin:0px;}
    a.lienStart { text-decoration: none; display: inline-block; width : 25px; font-size: smaller; color : blue;}
    a.active { color : red;}
</style>
<h1>Tous les formateurs</h1>
<div>
    Filtrer :
    <select name="action">
        <option value ="list_all_formers_pagination_admin">Tous les formateurs</option>
        <option value ="list_formers_moderators_pagination_admin">Uniquement les modérateurs</option>
        <option value ="list_formers_not_moderators_pagination_admin">Uniquement les non modérateurs</option>
    </select>
</div>
<br/>
<div>
    <tab>
        <tr>
            <td>Nom </td><td>est un Modérateur</td>
        </tr>
        <tr>
        <?php  foreach($tab as $ligne): ?>
            <td>
                <?= $ligne["nom"] ?><?= $ligne["prenom"] ?>
            </td>
            <?php                

                if ($ligne["est_moderateur"]){
                    echo '<td>Oui (cocher pour enlever le statut)<img class="icone" src="Content/images/case_cochee.png"/></td><br/>';
                }
                else{
                    echo '<td>Non (Cocher pour promouvoir en modérateur)<img class="icone" src="Content/images/case_vide.png"/></td><br/>';
                }
            ?>
        <?php endforeach ?>
        </tr>
    </tab>
</div>

<div class="page_suivante">
    <form method="post" action="Controllers/Controller_list_formers_pagination_admin.php">
    <a href="?controller=list_formers_pagination_admin&action=list_all_formers_pagination_admin"></a>
        <img class="icone" src="Content/images/previous-icon.png"/> 1/1 <img class="icone" src="Content/images/next-icon.png"/>
    </form>  
</div>

<?php
require_once "view_end.php";
?>
