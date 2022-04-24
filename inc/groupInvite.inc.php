<article class="invitation">
<header class="invitation-proposition">
    <span>Nono Debt vous a invité à rejoindre le groupe <span class="groupe">"Soirée jeux de société"</span></span>
    <ul class="invitationChoice choices">
        <li>
            <form action="group03.php" class="accept-invite">
                <button type="submit" class="accept">Accepter</button>
            </form>
        </li>
        <li>
            <form action="group03Peek.php" class="decline-invite">
                <button type="submit" class="decline">Refuser</button>
            </form>
        </li>
    </ul>
</header>
<article class="groupPreview">
    <header><span>Soirée jeux de société | Créé par: Nono Debt | Montant total des dépenses : 150 €</span>
    </header>
    <h3>Dernières dépenses</h3>
    <ul class="choices">
        <?php
        include("inc/expensesHead.inc.php");
        ?>
    </ul>
</article>
</article>