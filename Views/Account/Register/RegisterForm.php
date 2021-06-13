<?php
$countryOptions = ["Nederland", "Belgie", "United Kingdom"];
?>

<?php if (isset($args["error"]) && ($args["error"] != null)): ?>
<?php if ($args["error"][0]): ?>
<div class="notification is-success">
    <?php else: ?>
    <div class="notification is-danger">
        <?php endif; ?>
        <button class="delete"></button>
        <?=$args["error"][1]?>
    </div>
    <?php endif; ?>

<div class="title">Vul hieronder je gegevens in</div>
<div class="columns is-centered">
    <div class="column is-12">
        <form action="/RegisterForm/Pagina" method="POST" class="box">

            <div class="field">
                <label class="label">E-mail*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="email" name="email" class="input" value="<?=$_SESSION["MailboxRegister"]?>" disabled>
                    </label>
                    <span class="icon is-small is-left">
                                    <i class="fa fa-envelope"></i>
                                    </span>
                </div>
            </div>


            <div class="field">
                <label class="label">Gebruikersnaam* (Moet minimaal 4 karakters hebben)</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="text" name="Username" value="<?php if (!empty($args["post"])) {echo $args["post"]["Username"];}?>" class="input" placeholder="Gebruikersnaam">
                    </label>
                    <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Voornaam*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="text" name="Name" value="<?php if (!empty($args["post"])) {echo $args["post"]["Name"];}?>" class="input" placeholder="Voornaam">
                    </label>
                    <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Achternaam*</label>
                <div class="control has-icons-left">
                    <input type="text" name="Surname" value="<?php if (!empty($args["post"])) {echo $args["post"]["Surname"];}?>" class="input" placeholder="Achternaam">
                    <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Geboortedatum*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="Date" name="date" value="<?php if (!empty($args["post"])) {echo $args["post"]["date"];}?>" class="input">
                    </label>
                    <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Plaatsnaam*</label>
                <div class="control has-icons-left">
                    <input type="text" name="City" class="input" value="<?php if (!empty($args["post"])) {echo $args["post"]["City"];}?>" placeholder="Plaatsnaam">
                    <span class="icon is-small is-left">
                                    <i class="fas fa-globe"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Adres en Huisnummer*</label>
                <div class="control has-icons-left">
                    <input type="text" name="address" class="input" value="<?php if (!empty($args["post"])) {echo $args["post"]["address"];}?>" placeholder="Adres">
                    <span class="icon is-small is-left">
                                    <i class="fas fa-globe"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Evt toevoegingen</label>
                <div class="control has-icons-left">
                    <input type="text" name="address2" class="input" value="<?php if (!empty($args["post"])) {echo $args["post"]["address2"];}?>" placeholder="Evt toevoegingen">
                    <span class="icon is-small is-left">
                                    <i class="fas fa-globe"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Postcode*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="text" name="postalCode" value="<?php if (!empty($args["post"])) {echo $args["post"]["postalCode"];}?>" class="input" placeholder="Postcode">
                    </label>
                    <span class="icon is-small is-left">
                                    <i class="fas fa-globe"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label ">Land*</label>
                <div class="control has-icons-left ">
                    <div class="select ">
                        <select name="Country" value="<?php if (!empty($args["post"])) {echo $args["post"]["Country"];} else echo 'Nederland';?>">
                            <?php foreach ($countryOptions as $option): ?>
                                <?php if (!empty($args["post"])): ?>
                                    <?php if($args["post"]["Country"] == $option): ?>
                                        <option selected><?=$option?></option>
                                    <?php else: ?>
                                        <option><?=$option?></option>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <option><?=$option?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="icon is-small is-left">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Wachtwoord *(Moet minimaal 7 karakters hebben)</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="password" name="password" class="input" placeholder="Wachtwoord">
                    </label>
                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Herhaal Wachtwoord*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="password" name="re-password" class="input" placeholder="Herhaal Wachtwoord">
                    </label>
                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label ">Vraag indien wachtwoord vergeten*</label>
                <div class="control has-icons-left ">
                    <div class="select ">
                        <label>
                            <select name="question" value="<?php if (!empty($args["post"])) {echo $args["post"]["question"];} ?>">
                                <option selected>Selecteer vraag</option>
                                <?php

                                for($i = 0; $i < count($args["vraag"]); $i++) { ?>
                                    <?php if (!empty($args["post"])): ?>
                                        <?php if($args["post"]["question"] == $args["vraagnummer"][$i][0]): ?>
                                            <option selected value="<?=$args["vraagnummer"][$i][0]?>"><?=$args["vraag"][$i][0]?></option>
                                        <?php else: ?>
                                        <option value="<?=$args["vraagnummer"][$i][0]?>"><?=$args["vraag"][$i][0]?></option>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <option value="<?=$args["vraagnummer"][$i][0]?>"><?=$args["vraag"][$i][0]?></option>
                                    <?php endif; ?>
                                <?php } ?>
                            </select>
                        </label>
                    </div>
                    <div class="icon is-small is-left">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Antwoord op vraag*</label>
                <div class="control has-icons-left">
                    <label>
                        <input type="text" name="answer" value="<?php if (!empty($args["post"])) {echo $args["post"]["answer"];}?>" class="input" placeholder="Vul hier antwoord op de vraag in">
                    </label>
                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                </div>
            </div>
            <div class="field">
                <input type="submit" value="Registreer" class="button is-success">
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
