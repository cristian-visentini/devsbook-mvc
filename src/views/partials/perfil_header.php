<div class="row">
    <div class="box flex-1 border-top-flat">
        <div class="box-body">
            <div class="profile-cover" style="background-image: url('<?= $base; ?>/media/covers/<?= $User->Cover; ?>');"></div>
            <div class="profile-info m-20 row">
                <div class="profile-info-avatar">
                    <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>">
                        <img src="<?= $base; ?>/media/avatars/<?= $User->Avatar; ?>" />
                    </a>
                </div>
                <div class="profile-info-name">
                    <div class="profile-info-name-text">
                        <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>">
                            <?= $User->Name; ?>
                        </a>

                    </div>
                    <div class="profile-info-location"><?= $User->City; ?></div>
                </div>
                <div class="profile-info-data row">

                    <?php if ($User->Id != $LoggedUser->Id) : ?>
                        <div class="profile-info-item m-width-20">

                            <a class="button" href="<?= $base; ?>/perfil/<?= $User->Id; ?>/follow"><?= (!$IsFollowing) ? 'seguir' : 'Deixar de Seguir'; ?></a>

                        </div>
                    <?php endif; ?>

                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>/amigos">
                            <div class="profile-info-item-n"><?= count($User->Followers); ?></div>
                            <div class="profile-info-item-s">Seguidores</div>
                        </a>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>/amigos">
                            <div class="profile-info-item-n"><?= count($User->Following); ?></div>
                            <div class="profile-info-item-s">Seguindo</div>
                        </a>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <a href="<?= $base; ?>/perfil/<?= $User->Id; ?>/fotos">
                            <div class="profile-info-item-n"><?= count($User->Photos); ?></div>
                            <div class="profile-info-item-s">Fotos</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>