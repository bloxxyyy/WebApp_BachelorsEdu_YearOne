<?php
$bankOptions = ["ING", "Rabobank", "Bunq", "ABN Amro", "Knab", "SNS", "Triodos", "ASN", "DBB"];
?>

            <div class="column is-9">
                <section class="hero is-primary welcome is-small mb-5">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Vul hieronder je gegevens in
                            </h1>
                            <h2 class="subtitle">
                                Begin met het verkopen van objecten
                            </h2>
                        </div>
                    </div>
                </section>



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
                    <div class="columns is-centered">
                    <div class="column is-12">
                        <form action="/VerkoperRegister/Pagina" method="POST" class="box">
                            <div class="field">
                                <label class="label">Bank</label>
                                <div class="control has-icons-left">
                                    <div class="select ">
                                        <label>
                                            <select name="Bank">
                                                <?php foreach ($bankOptions as $option): ?>
                                                    <?php if($args["post"]["Bank"] == $option): ?>
                                                        <option selected><?=$option?></option>
                                                    <?php else: ?>
                                                        <option><?=$option?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>

                                    <span class="icon is-small is-left">
                                    <i class="fas fa-credit-card"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Bankrekening</label>
                                <div class="control has-icons-left">
                                    <label>
                                        <input type="text" name="Bankrekening" value="<?php if (!empty($args["post"])) {echo $args["post"]["Bankrekening"];}?>" class="input" placeholder="Bankrekening">
                                    </label>
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-credit-card"></i>
                                    </span>
                                </div>
                                <p class="label is-small pl-2">Let op: Alleen IBAN nummers worden geaccepteerd.</p>
                            </div>
                            <div class="field">
                                <label class="label">Creditcard</label>
                                <div class="control has-icons-left">
                                    <label>
                                        <input type="text" name="Creditcard" value="<?php if (!empty($args["post"])) {echo $args["post"]["Creditcard"];}?>" class="input" placeholder="Creditcard">
                                    </label>
                                    <span class="icon is-small is-left">
                                    <i class="fas fa-credit-card"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Verificatiemethode</label>
                                <div class="control has-icons-left ">
                                    <div class="select ">
                                        <label>
                                            <select name="ControleOptie">
                                                <option>Post</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="icon is-small is-left">
                                        <i class="fas fa-check"></i>
                                    </div>
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
            </div>


