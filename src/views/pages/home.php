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
                <div class="box banners">
                    <div class="box-header">
                        <div class="box-header-text">Patrocinios</div>
                        <div class="box-header-buttons">

                        </div>
                    </div>
                    <div class="box-body">
                        <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                        <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body m-10">
                        Criado com ❤️ Cristian Visentini
                    </div>
                </div>
            </div>
        </div>

    </section>
</section>
<?= $render('footer'); ?>