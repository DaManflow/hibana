<?php
require_once "view_begin.php";
?>
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
                <td>
                    De Nazareth Jésus
                </td>
                <td><img src="Content/images/case_cochee.png"/></td>
           </tr>
    </tab>
</div>
<div class="page_suivante">
    <form method="post" action="Controllers/Controller_list_formers_pagination_admin.php">
    <a href="?controller=list_list_formers_admin&action=list_all_formers_admin&"></a>
        <img src="Content/images/previous-icon.png"/> 1/1 <img src="Content/images/next-icon.png"/>
    </form>  
</div>

<?php
require_once "view_end.php";
?>
