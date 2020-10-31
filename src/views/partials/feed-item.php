<div class="box feed-item" data-id="<?= $data->Id; ?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?= $base; ?>/perfil/<?= $data->User->Id ?>"><img src="<?= $base; ?>/media/avatars/<?= $data->User->Avatar; ?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?= $base; ?>/perfil/<?= $data->User->Id ?>"><span class="fidi-name"><?= $data->User->Name; ?></span></a>
                <span class="fidi-action">
                    <?php
                    switch ($data->Type) {
                        case 'text':
                            echo ' Fez um Post';
                            break;
                        case 'photo':
                            echo ' Postou uma foto';
                            break;
                    }
                    ?></span>
                <br />
                <span class="fidi-date"><?php date('d/m/Y', strtotime($data->Created_At)) ?></span>
            </div>

           <?php if($data->Mine):?>
            <div class="feed-item-head-btn">
                <img src="<?= $base; ?>/assets/images/more.png" />
                <div class="feed-item-more-window">
                    <a href="<?=$base;?>/post/<?=$data->Id;?>/delete">Excluir Post</a>
                </div>
            </div>
           <?php endif;?>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?php
            switch ($data->Type) {
                case 'text':
                    echo nl2br($data->Body);
                    break;
                case 'photo':
                    echo '<img src="' . $base . '/media/uploads/' . $data->Body . '" />';
                    break;
            }
            ?>
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= ($data->Liked ? 'on' : '') ?>"><?= $data->LikeCount; ?></div>
            <div class="msg-btn"><?= count($data->Coments); ?></div>
        </div>
        <div class="feed-item-comments">

            <div class="feed-item-comments-area">

                <?php foreach ($data->Coments as $Item) : ?>

                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href="<?= $base; ?>/perfil/<?= $Item['user']['id'] ?>"><img src="<?= $base; ?>/media/avatars/<?= $Item['user']['avatar'] ?>" /></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?= $base; ?>/perfil/<?= $Item['user']['id'] ?>"><?= $Item['user']['name'] ?></a>
                            <?= $Item['body']; ?>
                        </div>
                    </div>


                <?php endforeach; ?>
            </div>

            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?= $base; ?>/perfil/<?= $data->User->Id ?>"><img src="<?= $base; ?>/media/avatars/<?= $LoggedUser->Avatar ?>" /></a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>