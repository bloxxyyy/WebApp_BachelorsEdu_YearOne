<?php
$beginDag = date("Y-m-d");
$beingTijd = date("H:i:s");
$data = $args["VeilingData"];
$countryOptions = ["Nederland", "Belgie", "United Kingdom"];
$dagenOptions = ["1 dag", "3 dagen", "5 dagen", "7 dagen", "10 dagen"];
$betalingsOptions = ["Bank", "Giro", "Paypal", "Anders"];
$rubrieken = $args['Rubrieken'];
?>

<script>
    function update_textlen(field, label) {
        var len = field.value.replace(/\n/g, "\r\n").length;
        document.getElementById(label).innerHTML = label + "("+len+") *";
    }
</script>

<script>
    const fileInput = document.querySelector('#file-js input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js .file-name');
            fileName.textContent = fileInput.files[0].name;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            const $notification = $delete.parentNode;

            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
        });
    });
</script>

<div class="section">
    <div class="container pt-4">

        <?php if (isset($_GET['success'])): ?>
            <div class="notification is-success">
                <button class="delete"></button>
                Gelukt! Uw veiling is geplaatst!
            </div>
        <?php elseif ($args["error"] != null): ?>
            <div class="notification is-danger">
                <button class="delete"></button>
                <?=$args["error"]?>
            </div>
        <?php else: ?>
            <article class="message is-primary">
                <div class="message-header">
                    <p>Plaats een veiling 😀</p>
                </div>
            </article>
        <?php endif; ?>

        <form class="veilingform" method="POST" action="/Veiling/Pagina/" enctype="multipart/form-data">
            <div class="columns">
                <div class="column">

                    <div class="box">

                        <label class="label">Product foto's</label>
                        <div class="field">
                            <!--<figure class="image is-1by1">
                                <img src="https://i.ebayimg.com/t/leren-bank-enjoy-3-zits-bruin-leer-bankstel-bruine-kleur/00/s/MTAwMFgxMDAw/z/bUIAAOSwU21fUbrF/$_84.JPG" alt="Afbeelding Veiling Artikel">
                            </figure>-->
                        </div>
                        <div class="field">
                            <div id="file-js" class="file has-name is-fullwidth is-info">
                                <label class="file-label">
                                    <input class="file-input" name="fileToUpload[]" id="fileToUpload" type="file" multiple>
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Kies bestanden..
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <p class="label is-small pl-2">Let op: Er kunnen meerdere bestanden toegevoegd worden door deze gezamelijk in de file browser te selecteren. (Maximaal 3 bestanden van maximaal 1 mb groot)</p>
                    </div>

                    <div class="box">
                        <h2 class="title">Helemaal klaar?</h2>
                        <div class="field">
                            <label class="label">Naam verkoper</label>
                            <div class="control">
                                <input class="input" type="text" placeholder=<?= $_SESSION['Gebruikersnaam']; ?> disabled>
                            </div>
                        </div>

                        <div class="field" style="display: none">
                            <label class="label">Voorwerpnummer</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="7325314744" disabled>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Begin looptijd</label>
                            <div class="control">
                                <input class="input" type="text" placeholder=<?= date("Y-m-d H:i:s"); ?> disabled>
                            </div>
                        </div>

                        <button name="btnSubmit" class="button is-primary">Doorgaan</button>

                    </div>
                </div>

                <div class="column">

                    <div class="box">
                        <div class="field">
                            <label class="label" id="Titel">
                                <?php if (!empty($data) && strlen($data["titelVeiling"]) > 0): ?>
                                    Titel (<?=strlen($data["titelVeiling"]) ?>) *
                                <?php else: ?>
                                    Titel (0) *
                                <?php endif; ?>
                            </label>
                            <div class="control">
                                <input onkeyup="update_textlen(this, 'Titel');" class="input is-primary" name="titelVeiling" value="<?php if (!empty($data)) {echo $data["titelVeiling"];}?>" type="text" placeholder="Naam van het product">
                            </div>
                        </div>
                        <p class="label is-small pl-2">Let op: Titel moet tussen de 3 en 18 tekens bevatten.</p>

                        <div class="field">
                            <label class="label" id="Beschrijving">
                                <?php if (!empty($data) && strlen($data["beschrijvingVeiling"]) > 0): ?>
                                    Beschrijving (<?=strlen($data["beschrijvingVeiling"]) ?>) *
                                <?php else: ?>
                                    Beschrijving (0) *
                                <?php endif; ?>
                                </label>
                            <div class="control">
                                <textarea onkeyup="update_textlen(this, 'Beschrijving');" class="textarea" id="beschrijvingVeiling" name="beschrijvingVeiling" placeholder="Voorwerp beschrijving"><?php if (!empty($data)) {echo $data["beschrijvingVeiling"];}?></textarea>
                            </div>
                            <p class="label is-small pl-2">Let op: Beschrijving moet tussen de 30 en 200 tekens bevatten.</p>
                        </div>

                        <div class="field">
                            <label class="label">Land</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-primary">
                                    <select name="landVeiling">
                                        <?php foreach ($countryOptions as $option): ?>
                                            <?php if($data["landVeiling"] == $option): ?>
                                                <option selected><?=$option?></option>
                                            <?php else: ?>
                                                <option><?=$option?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Postcode *</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="postcodeVeiling" value="<?php if (!empty($data)) {echo $data["postcodeVeiling"];}?>" type="text" placeholder="Plaatsnaam">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-street-view"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Plaatsnaam *</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="plaatsnaamVeiling" value="<?php if (!empty($data)) {echo $data["plaatsnaamVeiling"];}?>" type="text" placeholder="Plaatsnaam">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-street-view"></i>
                                </span>
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Startprijs *</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="startprijsVeiling" value="<?php if (!empty($data)) {echo $data["startprijsVeiling"];}?>" type="text" placeholder="Minimumprijs">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-money-bill-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Verkoopprijs *</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="Verkoopprijs" value="<?php if (!empty($data)) {echo $data["Verkoopprijs"];}?>" type="text" placeholder="Verkoopprijs">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-money-bill-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Betalingsinstructies</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="betalingInstructiesVeiling" value="<?php if (!empty($data)) {echo $data["betalingInstructiesVeiling"];}?>" type="text" placeholder="Betalingsinstructies">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Verzendkosten *</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="verzendkostenVeiling" value="<?php if (!empty($data)) {echo $data["verzendkostenVeiling"];}?>" type="text" placeholder="Verzendkosten">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-money-bill-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Verzendinstructies</label>
                            <div class="control has-icons-left">
                                <input class="input is-primary" name="verzendinstructiesVeiling" value="<?php if (!empty($data)) {echo $data["verzendinstructiesVeiling"];}?>" type="text" placeholder="Verzendinstructies">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-truck"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="box">
                        <div class="field">
                            <label class="label">Betalingswijze</label>
                            <div class="control">
                                <div class="select is-fullwidth is-primar">
                                    <select name="betalingswijzeVeiling">
                                        <?php foreach ($betalingsOptions as $option): ?>
                                            <?php if (!empty($args["post"])): ?>
                                                <?php if($data["betalingswijzeVeiling"] == $option): ?>
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
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Looptijd</label>
                            <div class="control">
                                <div class="select is-fullwidth is-primar">
                                    <select name="looptijdVeiling">
                                        <?php foreach ($dagenOptions as $option): ?>
                                        <?php if (!empty($args["post"])): ?>
                                                <?php if($data["looptijdVeiling"] == $option): ?>
                                                    <option selected><?=$option?></option>
                                                <?php else: ?>
                                                    <option><?=$option?></option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <option><?=$option?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-stopwatch"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Rubriek</label>
                            <div class="control">
                                <div class="select is-fullwidth is-primar">
                                    <select name="rubriekVeiling">
                                        <?php foreach ($rubrieken as $option): ?>
                                        <?php if (!empty($args["post"])): ?>
                                            <?php if($data["rubriekVeiling"] == $option["Rubrieknaam"]): ?>
                                                <option value="<?=$option["Rubrieknummer"]?>" selected><?=$option["Rubrieknaam"]?></option>
                                            <?php else: ?>
                                                <option value="<?=$option["Rubrieknummer"]?>"><?=$option["Rubrieknaam"]?></option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                                <option value="<?=$option["Rubrieknummer"]?>"><?=$option["Rubrieknaam"]?></option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                                <option value="<?=$option["Rubrieknummer"]?>"><?=$option["Rubrieknaam"]?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
