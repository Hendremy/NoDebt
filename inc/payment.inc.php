<?php if(isset($payment) && isset($group)):?>
<li class="expense">
    <span class="expense-detail"><?php echo $payment->debtor?></span><span class="expense-detail"><?php echo $group->formatAmount($payment->amount)?></span>
    <span class="expense-detail"><?php echo $payment->creditor?></span>
    <?php if($ses_uid == $payment->creditorId) :?>
    <form method="post" action="<?php if(isset($actionSelf)) echo $actionSelf?>">
        <input type="hidden" name="gid" value="<?php echo $payment->gid?>"/>
        <input type="hidden" name="credId" value="<?php echo $payment->creditorId?>"/>
        <input type="hidden" name="debtId" value="<?php echo $payment->debtorId?>"/>
        <button type="submit" name="confirmPayment"><span>Reçu </span><img alt=" " class="iconx24" src="images/accept.png"/></button>
    </form>
    <?php else: ?>
        <?php if($payment->isConfirmed):?>
        <span>Confirmé le <?php echo $payment->dateHeure?></span>
        <?php else:?>
        <span>En attente de confirmation</span>
        <?php endif?>
    <?php endif?>
    <span></span>
</li>
<?php endif?>