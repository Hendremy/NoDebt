<?php
include('session.inc.php');
?>
<?php if(isset($userId)) : ?>
<header>
    <a href="myGroups.php/?userId=<?php echo $userId ?>" class="nodebt"><img id="logo" src="images/icon.png" alt="logo"/>No D€bt</a>
    <nav class="website-nav">
        <ul class="nav-links">
            <li><a href="myGroups.php/?userId=<?php echo $userId ?>">Mes groupes</a></li>
            <li><a href="createGroup.php/?userId=<?php echo $userId ?>">Créer un groupe</a></li>
            <li><a href="contact.php/?userId=<?php echo $userId ?>">Contact</a></li>
        </ul>
    </nav>
    <nav class="profile-nav">
        <ul class="nav-links">
            <li><a href="editProfile.php/?userId=<?php echo $userId ?>">Machin Bidule</a></li>
            <li><a href="index.php">Se déconnecter</a></li>
        </ul>
    </nav>
</header>
<?php else : ?>
<header>
    <a href="index.php" class="nodebt"><img id="logo" src="images/icon.png" alt="Logo No Debt"/>No D€bt</a>
    <nav class="website-nav">
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <nav class="authentication-nav">
        <ul class="nav-links">
            <li><a href="index.php">Se connecter</a></li>
            <li><a href="signin.php">S'inscrire</a></li>
        </ul>
    </nav>
</header>
<?php endif ?>