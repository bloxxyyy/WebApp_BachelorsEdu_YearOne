<div class="hero is-fullheight">
    <div class="hero-body pt-1">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-6">
                    <?php require_once("Error.php"); ?>


                    <form action="/Login/WachtwoordVergeten" method="POST" class="box">

                        <p class="title">Wachtwoord vergeten?</p>
                        <p class="subtitle">Vul je e-mail in om verder te gaan</p>

                        <div class="field">
                            <label class="label">E-mail</label>
                            <div class="control has-icons-left">
                                <label>
                                    <?php if ($args["email"] != null): ?>
                                        <input type="email" name="email" class="input" value="<?=$args["email"]?>">
                                    <?php else: ?>
                                        <input type="email" name="email" class="input" placeholder="john@voorbeeld.com">
                                    <?php endif; ?>
                                </label>
                                <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                            </div>
                        </div>



                        <div class="field">
                            <input type="submit" class="button is-success" value="Verstuur">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
