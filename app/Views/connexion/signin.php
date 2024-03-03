<div class="mainBlock">
    <h1>Sign In</h1>
    <form action="" method="post">
        <label>Pseudo*</label>
        <input type="texte" name="pseudo" value="<?=$pseudo ?? ''; ?>" minlength="2" maxlength="255">
        <span style="color: red"><?= $pseudoError ?? '' ?></span>

        <label>Email*</label>
        <input type="texte" name="email" value="<?=$email ?? ''?>" minlength="2" maxlength="255">
        <span style="color: red"><?= $emailError ?? '' ?></span>

        <label>Mot de passe*</label>
        <input type="password" name="password" value="<?=$password ?? ''?>" minlength="8" maxlength="72">
        <span style="color: red"><?= $passwordError ?? ''?></span>

        <label>Vérification du mot de passe*</label>
        <input type="password" name="confirmPassword" value="<?=$confirmPassword ?? ''?>" minlength="8" maxlength="72">
        <button type="submit">Submit</button>
        <span style="color: red"><?= $confirmPasswordError ?? '' ?></span>
    </form>
    <span style="color: green"><?= $message ?? '' ?></span>
</div>