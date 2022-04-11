<?php

namespace NoDebt;

class TemplateCreator
{
    public function echoGroupPreview($group, $expenses){
        echo '<li>';
        echo "<header><span><a href='group.php/?gid=$group->gid'>$group->name</a> | Créé par: $group->owner_name | Total : $group->total €</span></header>";
        //echo expenses;
        echo '</li>';
    }
}