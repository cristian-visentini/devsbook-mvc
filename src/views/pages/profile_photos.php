<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

    <?= $render('sidebar', ['activeMenu' => 'photos']); ?>

    <section class="feed">

        <?= $render('perfil_header', ['User' => $User, 'LoggedUser' => $LoggedUser, 'IsFollowing' => $IsFollowing]); ?>

        <div class="row">
            <div class="column">

                <div class="box">
                    <div class="box-body">

                        <div class="full-user-photos">

                            <?php if (count($User->Photos) === 0) : ?>
                                <?= $User->Name; ?> Ainda não postou nenhuma foto!
                            <?php endif; ?>

                            <?php foreach ($User->Photos as $Photo) : ?>
                                <div class="user-photo-item">
                                    <a href="#modal-<?= $Photo->Id; ?>" rel="modal:open">
                                        <img src="<?= $base; ?>/media/uploads/<?= $Photo->Body; ?>" />
                                    </a>
                                    <div id="modal-<?= $Photo->Id; ?>" style="display:none">
                                        <img src="<?= $base; ?>/media/uploads/<?= $Photo->Body; ?>" />
                                    </div>
                                </div>
                            <?php endforeach; ?>


                        </div>


                    </div>
                </div>

            </div>

        </div>
    </section>
</section>

<?= $render('footer'); ?>