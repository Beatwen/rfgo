<h1>Log in</h1>
<div class="mainBlock">
    <form method="post" action="">
        
        <input type=hidden value="connexion" name="connexion">
        <label>Pseudo*</label>
        <input type="texte" name="pseudo" value="<?=$pseudo ?? ''?>" minlength="2" maxlength="255">
        <span style="color: red"><?= $pseudoError ?? ''?></span>
        <label>Mot de passe*</label>
        <input type="password" name="password" minlength="8" maxlength="72">
        <span style="color: red"><?= $passwordError ?? '' ?></span>
        <label for="rememberMe">Remember Me</label>
        <input type="checkbox" name="rememberMe" value="true">
        <button type="submit">Submit</button>
    </form>
</div>
<a href='signin'>Create an account here</a>

