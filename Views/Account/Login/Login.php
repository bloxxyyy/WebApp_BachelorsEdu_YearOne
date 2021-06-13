<div class="hero is-fullheight">
    <div class="hero-body pt-1">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-6">

                    <?php if (isset($_GET['NewUser'])): ?>
                        <div class="notification is-success">
                            <button class="delete"></button>
                            Gelukt! Je bent nu succesvol geregistreerd. Er is een bevestiginsmail naar je opgegeven e-mail gestuurd.
                        </div>
                    <?php endif; ?>


                    <?php if ($args["error"] != null): ?>
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>Error!</p>
                            </div>
                            <div class="message-body">
                                <p><?= $args["error"]?></p>
                            </div>
                        </article>
                    <?php endif; ?>

                    <form action="/Login/Pagina" method="POST" class="box">

                        <p class="title">Ben je al lid? </p>
                        <p class="subtitle">Log dan nu in om verder te gaan</p>

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
                            <label class="label">Wachtwoord</label>
                            <div class="control has-icons-left">
                                <label>
                                    <input type="password" name="pass" class="input" placeholder="Wachtwoord">
                                </label>
                                <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
                            </div>
                        </div>

                        <div class="field">
                            <input type="submit" class="button is-success" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

