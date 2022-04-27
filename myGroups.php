<?php
include('inc/session.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Mes groupes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Mes groupes</h1>
        <?php if(isset($ses_invites) && count($ses_invites) > 0) :?>
        <section class="invitationList">
            <h2>Mes invitations</h2>
            <ul id="invites">
                <?php
                foreach($ses_invites as $inviteId){
                    include("inc/groupInvite.inc.php");
                }
                ?>
            </ul>
        </section>
        <?php endif ?>
        <section class="groupList">
            <h2>Mes groupes</h2>
            <?php if(isset($ses_groups) && count($ses_groups) > 0) :?>
            <ul id="groups">
                <?php
                if(isset($ses_groups)){
                    foreach($ses_groups as $groupId){
                        include("inc/groupPreview.inc.php");
                    }
                }
                ?>
            </ul>
            <?php else:?>
            <span>Vous ne participez à aucun groupe</span>
            <?php endif?>
        </section>
    </main>
</body>
</html>