<?php if(isset($bill)) :?>
<li>
    <img src="<?php echo $bill->scanFilePath?>"/>
    <form method="post" action="billDelete.php">
        <input type="hidden" name="did" value="<?php echo $bill->did?>"
        <button class="decline" type="submit" name="deleteBtn"><img class="iconx32" src="images/delete.png" alt="Supprimer"/></button>
    </form>
</li>
<?php endif?>
