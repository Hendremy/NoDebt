<?php if(isset($payment)):?>
<li class="expense">
    <span class="expense-detail"><?php echo $payment->debtor?></span><span class="expense-detail"><?php echo $payment->amount?></span>
    <span class="expense-detail"><?php echo $payment->creditor?></span>
</li>
<?php endif?>