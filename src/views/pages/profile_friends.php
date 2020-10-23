<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

    <?= $render('sidebar', ['activeMenu' => 'friends']); ?>

    <section class="feed">

    <?=$render('perfil_header', ['User'=>$User, 'LoggedUser'=>$LoggedUser, 'IsFollowing' =>$IsFollowing]);?>

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
                                            <a href="<?= $base; ?>/perfil/<?= $Follower->Id; ?>">
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