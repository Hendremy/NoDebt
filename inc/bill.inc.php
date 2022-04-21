<?php if(isset($bill) && isset($fileStorage)) :?>
<li class="bill-li">
    <img class="bill-scan" alt="Scan facture" src="<?php echo $fileStorage->getRelativePath($bill->filename)?>"/>
    <form method="post" action="billDelete.php">
        <input type="hidden" name="fid" value="<?php echo $bill->fid?>"/>
        <button class="decline" type="submit" name="deleteBtn"><img class="iconx32" src="images/delete.png" alt="Supprimer"/></button>
    </form>
</li>
<?php endif?>
