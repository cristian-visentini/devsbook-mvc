<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

    <?= $render('sidebar', ['activeMenu' => 'profile']); ?>

    <section class="feed">

    <?=$render('perfil_header', ['User'=>$User, 'LoggedUser'=>$LoggedUser, 'IsFollowing' =>$IsFollowing]);?>

        <div class="row">

            <div class="column side pr-5">

                <div class="box">
                    <div class="box-body">

                        <div class="user-info-mini">
                            <img src="<?= $base; ?>/assets/images/calendar.png" />
                            <?= date('d/m/Y', strtotime($User->BirthDate)); ?>(<?= $User->AgeYears ?> anos)
                        </div>

                        <?php if (!empty($User->City)) : ?>
                            <div class="user-info-mini">
                                <img src="<?= $base; ?>/assets/images/pin.png" />
                                <?= $User->City; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($User->Work)) : ?>
                            <div class="user-info-mini">
                                <img src="<?= $base; ?>/assets/images/work.png" />
                                <?= $User->Work; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Seguindo
                            <span><?= count($User->Following); ?></span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>/amigos">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body friend-list">

                        <?php for ($q = 0; $q < 9; $q++) : ?>
                            <?php if (isset($User->Following[$q])) : ?>
                                <div class="friend-icon">
                                    <a href="<?= $base; ?>/perfil/<?= $User->Following[$q]->Id; ?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?= $base; ?>/media/avatars/<?= $User->Following[$q]->Avatar; ?>" />
                                        </div>
                                        <div class="friend-icon-name">
                                            <?= $User->Following[$q]->Name; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>

                    </div>

                </div>
            </div>
            <div class="column pl-5">

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Fotos
                            <span><?= count($User->Photos); ?></span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>/fotos">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body row m-20">

                        <?php for ($q = 0; $q < 4; $q++) : ?>
                            <?php if (isset($User->Photos[$q])) : ?>
                                <div class="user-photo-item">
                                    <a href="#modal-<?= $User->Photos[$q]->Id; ?>" rel="modal:open">
                                        <img src="<?= $base; ?>/media/uploads/<?= $User->Photos[$q]->Body; ?>" />
                                    </a>
                                    <div id="modal-<?= $User->Photos[$q]->Id; ?>" style="display:none">
                                        <img src="<?= $base; ?>/media/uploads/<?= $User->Photos[$q]->Body; ?>" />
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endfor; ?>

                    </div>
                </div>

                <?php if ($User->Id == $LoggedUser->Id) : ?>
                    <?= $render('feed-editor', ['User' => $LoggedUser]); ?>
                <?php endif; ?>

                <?php foreach ($Feed['Posts'] as $FeedItem) : ?>
                    <?= $render('feed-item', [
                        'data' => $FeedItem,
                        'LoggedUser' => $LoggedUser
                    ]); ?>
                <?php endforeach; ?>

                <div class="feed-pagination">
                    <?php for ($q = 0; $q < $Feed['PageCount']; $q++) : ?>
                        <a class="<?= ($q == $Feed['CurrentPage'] ? 'active' : '') ?>" href="<?= $base ?>/perfil/<?= $User->Id; ?>?page=<?= $q; ?>"><?= $q + 1; ?></a>
                    <?php endfor; ?>
                </div>


            </div>

    </section>
</section>

<?= $render('footer'); ?>