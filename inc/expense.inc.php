<?php
if(isset($expense)):
?>
<li class="expense">
    <span class="expense-detail"><?php echo $expense->spender?></span><span class="expense-detail"><?php echo $expense->libelle?></span>
    <span class="expense-detail"><?php echo $expense->montant?></span><span class="expense-detail"><?php echo $expense->paydate ?></span>
    <ul class="choices">
        <li>
            <form action="expenseBills.php" method="post">
                <input type="hidden" name="did" value="<?php echo $expense->did?>"/>
                <input type="hidden" name="label" value="<?php echo $expense->libelle?>"/>
                <button type="submit" name="billsBtn"><img class="iconx32" src="images/receipt.png" alt="Factures"/></button>
            </form>
        </li>
        <li>
            <form action="expenseEdit.php" method="post">
                <input type="hidden" name="did" value="<?php echo $expense->did?>"/>
                <input type="hidden" name="groupCurr" value="<?php if(isset($group))echo $group->name?>"/>
                <button type="submit" name="editBtn"><img class="iconx32"  src="images/edit.png" alt="Editer"/></button>
            </form>
        </li>
        <li>
            <form action="expenseDelete.php" method="post">
                <input type="hidden" name="label" value="<?php echo $expense->libelle?>"/>
                <input type="hidden" name="did" value="<?php echo $expense->did?>"/>
                <button class="decline" type="submit" name="deleteBtn"><img class="iconx32" src="images/delete.png" alt="Supprimer"/></button>
            </form>
        </li>
    </ul>
</li>
<?php endif?>
