<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

    <?= $render('sidebar', ['activeMenu' => 'friends']); ?>

    <section class="feed">

        <div class="row">
            <div class="box flex-1 border-top-flat">
                <div class="box-body">
                    <div class="profile-cover" style="background-image: url('<?= $base; ?>/media/covers/<?= $User->Cover; ?>');"></div>
                    <div class="profile-info m-20 row">
                        <div class="profile-info-avatar">
                            <img src="<?= $base; ?>/media/avatars/<?= $User->Avatar; ?>" />
                        </div>
                        <div class="profile-info-name">
                            <div class="profile-info-name-text"><?= $User->Name; ?></div>
                            <div class="profile-info-location"><?= $User->City; ?></div>
                        </div>
                        <div class="profile-info-data row">

                            <?php if ($User->Id != $LoggedUser->Id) : ?>
                                <div class="profile-info-item m-width-20">

                                    <a class="button" href="<?= $base; ?>/perfil/<?= $User->Id; ?>/follow"><?= (!$IsFollowing) ? 'seguir' : 'Deixar de Seguir'; ?></a>

                                </div>
                            <?php endif; ?>

                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($User->Followers); ?></div>
                                <div class="profile-info-item-s">Seguidores</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($User->Following); ?></div>
                                <div class="profile-info-item-s">Seguindo</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($User->Photos); ?></div>
                                <div class="profile-info-item-s">Fotos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="column">

                <div class="box">
                    <div class="box-body">

                        <div class="tabs">
                            <div class="tab-item" data-for="followers">
                                Seguidores
                            </div>
                            <div class="tab-item active" data-for="following">
                                Seguindo
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-body" data-item="followers">

                                <div class="full-friend-list">

                                    <?php foreach ($User->Followers as $Follower) : ?>
                                        <div class="friend-icon">
                                            <a href="">
                                                <div class="friend-icon-avatar">
                                                    <img src="<?= $base; ?>/media/avatars/<?= $Follower->Avatar; ?>" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?= $Follower->Name; ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>



                                </div>

                            </div>
                            <div class="tab-body" data-item="following">

                                <div class="full-friend-list">

                                <?php foreach ($User->Following as $Follower) : ?>
                                        <div class="friend-icon">
                                            <a href="">
                                                <div class="friend-icon-avatar">
                                                    <img src="<?= $base; ?>/media/avatars/<?= $Follower->Avatar; ?>" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?= $Follower->Name; ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
</section>

<?= $render('footer'); ?>