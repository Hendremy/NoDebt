<?php if(isset($ses_uid)) : ?>
<header class="nav-header">
    <a href="myGroups.php" class="nodebt"><img id="logo" src="images/icon.png" alt="logo"/>No D€bt</a>
    <nav class="website-nav">
        <ul class="nav-links">
            <li><a href="myGroups.php">Mes groupes</a></li>
            <li><a href="createGroup.php">Créer un groupe</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <nav class="profile-nav">
        <ul class="nav-links">
            <li><a href="editProfile.php"><?php echo isset($ses_lastName) && isset ($ses_firstName) ? $ses_firstName.' '.$ses_lastName : 'Profil' ?></a></li>
            <li><a href="disconnect.php">Se déconnecter</a></li>
        </ul>
    </nav>
</header>
<?php else : ?>
<header class="nav-header">
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
            <li><a href="signup.php">S'inscrire</a></li>
        </ul>
    </nav>
</header>
<?php endif ?>