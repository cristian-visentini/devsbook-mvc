<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

    <?= $render('sidebar', ['activeMenu' => 'search']); ?>

    <section class="feed mt-10">

        <div class="row">
            <div class="column pr-5">

                <h1>Você pesquisou por: <?= $SearchTerm; ?></h1>

                <div class="full-friend-list">

                    <?php foreach ($Users as $User) : ?>
                        <div class="friend-icon">
                            <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>">
                                <div class="friend-icon-avatar">
                                    <img src="<?= $base; ?>/media/avatars/<?= $User->Avatar; ?>" />
                                </div>
                                <div class="friend-icon-name">
                                    <?= $User->Name; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>


            </div>
            <div class="column side pl-5">
                <?= $render('right_side'); ?>
            </div>
    </section>
</section>

<?= $render('footer'); ?>