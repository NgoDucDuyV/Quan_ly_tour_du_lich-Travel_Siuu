<?php
$act = isset($_GET['act']) ? $_GET['act'] : '/';

ob_start();
echo match ($act) {
    '/' => 'anh yeu em',
    default => 'anh yeu em',
};
$content_views =  ob_get_clean();
// var_dump((new UserLoginSiginController())->ShowFromLogin());
// die;
?>
<main class="contentClient">
    <?= $content_views ?>
</main>