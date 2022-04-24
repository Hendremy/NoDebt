<ul class="participants-list">
    <?php
    foreach ($group->participants as $participant){
        include('inc/participant.inc.php');
    }
    ?>
</ul><?php
