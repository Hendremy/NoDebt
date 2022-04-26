<?php
use NoDebt\GroupRepository;

if(isset($inviteId)):?>

    <?php
    require_once'php/repository/GroupRepository.php';

    $groupRepo = new GroupRepository();
    $group = $groupRepo->getGeneralInfo($inviteId);
    ?>
<article class="invitation">
    <span>Vous a invité à rejoindre le groupe <span class="groupe"><?php echo $group->name?></span> créé par <?php echo $group->owner_name?></span>
    <ul class="invitationChoice choices">
        <li>
            <form action="inviteAccept.php" class="accept-invite" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
                <button type="submit" class="accept" name="inviteAccept"><img src="images/accept.png" alt="Accepter" class="iconx32"/></button>
            </form>
        </li>
        <li>
            <form action="groupPeek.php" class="decline-invite" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
                <button type="submit" class="decline"><img src="images/refuse.png" alt="Refuser" class="iconx32"/></button>
            </form>
        </li>
    </ul>
</article>
<?php endif?>