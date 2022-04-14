<?php
if(isset($expense)):
?>
<li class="expense">
    <span class="expense-detail"><?php echo $expense->spender?></span><span class="expense-detail"><?php echo $expense->libelle?></span>
    <span class="expense-detail"><?php echo $expense->montant?></span><span class="expense-detail"><?php echo $expense->paydate ?></span>
    <ul class="choices">
        <li>
            <form action="expenseBills.php?did=<?php echo $expense->did?>" method="post">
                <button type="submit" name="billsBtn"><img class="iconx32" src="images/receipt.png" alt="Factures"/></button>
            </form>
        </li>
        <li>
            <form action="expense.php?did=<?php echo $expense->did?>" method="post">
                <button type="submit" name="editBtn"><img class="iconx32"  src="images/edit.png" alt="Editer"/></button>
            </form>
        </li>
        <li>
            <form action="expenseDelete.php?did=<?php echo $expense->did?>" method="post">
                <button class="decline" type="submit" name="billsBtn"><img class="iconx32" src="images/delete.png" alt="Supprimer"/></button>
            </form>
        </li>
    </ul>
</li>
<?php endif?>
