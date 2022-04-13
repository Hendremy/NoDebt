<?php
if(isset($participant) && isset($averageExp) && isset($group)){
    $name = $participant->name;
    $total = $participant->total;
    $totalString = $group->formatAmount($total);
    $diff = $total - $averageExp;
    $diffString = $group->formatAmount($diff);
    $diffEcho = "<span>$diffString</span>";
    if($diff > 0){
        $diffEcho = "<span class='pos-diff'>+$diffString</span>";
    }else if($diff < 0){
        $diffEcho = "<span class='neg-diff'>$diffString</span>";
    }

}
?>
<li class="participant">
    <span><?php echo $name ?></span>
    <p>Dépense totale : <span><?php echo $totalString ?></span></p>
    <p>Différence à la moyenne : <?php echo $diffEcho ?></p>
</li>