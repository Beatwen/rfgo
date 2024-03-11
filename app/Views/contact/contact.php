<div class="mainBlock">
        <h1>Contact</h1>
        <form action="" id="contactForm" method="post">
            <label for="firstname">First Name*</label>
            <input type="text" minlength="2" maxlength="255" name="firstname" aria-invalid="false" value required <?php echo (isset($errors["firstname"])) ? true:false; ?>>
                <?php if (isset($errors["firstname"])) { ?><p><?php echo $errors["firstname"]; }?></p>

            <label for="lastname">Last Name*</label>
            <input type="text" minlength="2" maxlength="255" name="lastname" aria-invalid="false" value required <?php echo (isset($errors["lastname"])) ? true:false; ?>>
            <?php if (isset($errors["lastname"])) { ?><p><?php echo $errors["lastname"]; }?></p>

            <label>Age</label>
            <input name="age" type="number" min="1" max="120">

            <label for="email" >email*</label>
            <input type="email" name="email" aria-invalid="false" value required <?php echo isset($errors["email"]) ? true:false?>>
        <?php if (isset($errors["email"])) { ?><p> <?php  echo $errors["email"];} ?></p>

            <label>message*</label>
            <input name="message" type="message" minlength="10" maxlength="3000" aria-invalid="false" value required>
            
            <button type="submit">Submit</button>
        </form>
    </div>  
    <div id="images"></div> 
    