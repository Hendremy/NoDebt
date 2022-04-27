<?php
if(isset($participant) && isset($averageExp) && isset($group)){
    $name = $participant->name;
    $total = $participant->total;
    $totalString = $group->formatAmount($total);
    $diff = $total - $averageExp;
    $diffString = $group->formatAmount($diff);
    $diffEcho = "<span>$diffString</span>";
    if($diff > 0){
        $diffEcho = "<span class='pos-diff'>&#9650; $diffString</span>";
    }else if($diff < 0){
        $diffEcho = "<span class='neg-diff'>&#9660; $diffString</span>";
    }

}
?>
<li class="participant">
    <span><?php echo $name ?></span>
    <p>Total : <span><?php echo $totalString ?></span></p>
    <p>Différence : <?php echo $diffEcho ?></p>
</li>