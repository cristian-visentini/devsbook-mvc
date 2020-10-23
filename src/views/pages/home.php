<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

<?= $render('sidebar', ['activeMenu' => 'home']); ?>
    <section class="feed mt-10">

        <div class="row">
            <div class="column pr-5">

                <?= $render('feed-editor', ['User' => $LoggedUser]); ?>

                <?php foreach ($Feed['Posts'] as $FeedItem) : ?>
                    <?= $render('feed-item', [
                        'data' => $FeedItem,
                        'LoggedUser' => $LoggedUser
                    ]); ?>
                <?php endforeach; ?>

                <div class="feed-pagination">
                    <?php for ($q = 0; $q < $Feed['PageCount']; $q++) : ?>
                        <a class="<?=($q==$Feed['CurrentPage'] ? 'active': '')?>" href="<?= $base ?>/?page=<?= $q; ?>"><?= $q + 1; ?></a>
                    <?php endfor; ?>
                </div>



            </div>
            <div class="column side pl-5">
                <?=$render('right_side');?>
        </div>

    </section>
</section>
<?= $render('footer'); ?>