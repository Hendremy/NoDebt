<?php

if(isset($_GET['expenseId'])){
    $expenseId = $_GET['expenseId'];
    $amount = $_GET['amount'];
    $date = $_GET['date'];
    $label = $_GET['label'];
    $spender = $_GET['spender'];
}
?>
<li class="expense">
    <span><?php echo $spender?></span> - <a href="expenseEdit.php/?did=<?php echo $expenseId ?>"><?php echo $label?></a>
    - <span><?php echo $amount?></span> - <span><?php echo isset($date) ? $date : 'fuck' ?></span>
    - <a href="expenseBills.php?did=<?php echo $expenseId?>">Factures</a>
</li>
