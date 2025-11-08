<?php
$act = isset($_GET['act']) ? $_GET['act'] : '/';
ob_start();
echo match ($act) {
    '/' => (function () {
        require_once "./views/Admin/signin.php";
    })(),
    default => 'admin',
};
$content_views = ob_get_clean();
?>

<?php
if ($act == 'showfromloginAdmin' || $act == "/") {
    echo $content_views;
    exit;
}
?>
<main class="contentAdmin">
    <?= $content_views; ?>
</main>
<?php exit; ?>
?>