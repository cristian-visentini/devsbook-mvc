<?= $render('header', ['LoggedUser' => $LoggedUser]); ?>
<section class="container main">

<?php 
/*
echo "<pre>";
print_r($LoggedUser);
print_r($User);
exit;
*/

?>
    <?= $render('sidebar', ['activeMenu' => 'configuration']); ?>

    <section class="feed mt-10">

        <div class="row">
            <div class="column pr-5">

                <h1>Configurações</h1>
                <?php if (!empty($Flash)) : ?>
                <div class="flash"><?php echo $Flash; ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= $base; ?>/configuration" enctype="multipart/form-data">

                    <label>
                        Nova foto: <br>
                        <input type="file" name="cover">
                    </label>
                    <br>
                    <label>
                        Nova Capa: <br>
                        <input type="file" name="avatar">
                    </label>
                    <hr>

                    <label>
                        * Nome Completo: <br>
                        <input type="text" name="name" value="<?=$LoggedUser->Name;?>">
                    </label>

                    <br>

                    <label>
                        * Data de Nascimento: <br>
                        <input type="text" id="birthdate" name="birthdate" value="<?=$User->BirthDate;?>">
                    </label>

                    <br>

                    <label>
                        * Email: <br>
                        <input type="email" name="email" value="<?=$LoggedUser->Email;?>">
                    </label>
                    <br>

                    <label>
                        Cidade: <br>
                        <input type="text" name="city">
                    </label>
                    <br>

                    <label>
                        Trabalho: <br>
                        <input type="text" name="work">
                    </label>
                    <br>

                    <label>
                        Senha: <br>
                        <input type="password" name="password">
                    </label>
                    <br>

                    <label>
                        Confirme a nova Senha: <br>
                        <input type="password" name="new_password">
                    </label>
                    <br>
                    <input type="submit" value="Salvar">
                </form>



            </div>

            <div class="column side pl-5">
                <?= $render('right_side'); ?>
            </div>
    </section>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
IMask(
    document.getElementById('birthdate'),
    {
        mask:'00/00/0000'
    }
);
</script>

<?= $render('footer'); ?>