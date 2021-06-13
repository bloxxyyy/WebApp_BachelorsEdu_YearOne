<?php
    $item = $args['Voorwerp'];
    $biedingen = $args['Bod'];
    $tijd = $args['Looptijd'];
    $veilingOpen = $args['VeilingOpen'];
    $loggedIn = $args['Loggedin'];

    $maand = date("m", strtotime($item['LooptijdeindeDag']));
    $dag = date("d", strtotime($item['LooptijdeindeDag']));
    $jaar = date("Y", strtotime($item['LooptijdeindeDag']));
    $eindeTijdstip = substr($item['LooptijdEindeTijdstip'], 0, 5);
?>

<div class="section">
    <div class="container pt-4">

        <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
            <ul>
                <?php $amount = count($args["breadcrum"]); ?>
                <li><a href="/Rubrieken/Pagina/1/" aria-current="page">Alle Veilingen</a></li>

                <?php
                $count = 0;
                foreach ($args["breadcrum"] as $breadcrumPart):
                    $count++;
                    if ($count < $amount): ?>
                        <li><a href="/Rubrieken/Pagina/1/<?=$breadcrumPart["Rubrieknummer"]?>"><?=$breadcrumPart['Rubrieknaam']?></a></li>
                    <?php else: ?>
                        <li class="is-active"><a href="/Rubrieken/Pagina/1/<?=$breadcrumPart["Rubrieknummer"]?>" aria-current="page"><?=$breadcrumPart['Rubrieknaam']?></a></li>
                    <?php endif;
                endforeach;
                ?>
            </ul>
        </nav>

        <?php if (isset($_GET['success']) == 'Success'): ?>
                <div class="notification is-success">
                    <button class="delete"></button>
                    Gelukt! Je bod is geplaatst!
                </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) == 'OngeldigBod'): ?>
            <div class="notification is-danger">
                <button class="delete"></button>
                Error! Je bod is te laag!
            </div>
        <?php endif; ?>

        <div class="columns">

            <div class="column">
                <div class="box">
                    <figure class="image is-1by1">
                        <?php if ($item["Filenaam"] == null): ?>
                            <img src="<?=ROOT?>/Data/img/placeholder-image.png"  alt="<?=$item["Titel"]?>"/>
                        <?php else: ?>
                            <img src="<?=ROOT?>uploads/<?=$item["Filenaam"]?>"  alt="<?=$item["Titel"]?>"/>
                        <?php endif ?>
                    </figure>
                </div>

                <div class="box">
                    <div class="columns">
                        <?php if (!empty($args['images'])):
                        foreach ($args['images'] as $image): ?>
                            <div class="column">
                                <figure class="image is-128x128">
                                    <?php if ($image["Filenaam"] == null): ?>
                                        <img style="height: 100%!important" class="is-128x128" src="<?=ROOT?>/Data/img/placeholder-image.png"  alt="Image"/>
                                    <?php else: ?>
                                        <img style="height: 100%!important" src="<?=ROOT?>uploads/<?=$image["Filenaam"]?>"  alt="Image"/>
                                    <?php endif ?>
                                </figure>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <div class="message is-primary">
                    <div class="message-header">
                        <p>Beschrijving</p>
                    </div>
                    <div class="message-body">
                        <p><?= $item['Beschrijving'];?></p>
                    </div>
                </div>
            </div>

            <div class="column is-5">
                <div class="box">
                    <h1 class="title"><?= $item['Titel'];?></h1>
                    <table class="table is-hoverable is-fullwidth">
                        <tbody>
                            <tr>
                                <td class="has-text-weight-bold">Verkoper:</td>
                                <td><?= ucfirst($item['Verkoper']);?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Startprijs:</td>
                                <td><?= '€' . number_format($item['Startprijs'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Verkoopprijs:</td>
                                <td><?= '€' . number_format($item['Verkoopprijs'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Verzendkosten:</td>
                                <td><?= '€' . number_format($item['Verzendkosten'], 2, ',', '');?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Betalingswijze:</td>
                                <td><?= ucfirst($item['Betalingswijze']);?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Locatie:</td>
                                <td><?= ucfirst($item['Plaatsnaam']);?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Looptijd:</td>
                                <td><?= $item['Looptijd'] . ' dagen';?></td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-bold">Artikelnummer:</td>
                                <td><?= $item['Voorwerpnummer'];?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box">
                    <p class="content is-medium has-text-black">Laatste biedingen</p>

                    <?php if (count($biedingen) > 0): ?>

                    <table class="table is-striped is-fullwidth">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Naam</th>
                                <th>Bod</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($biedingen as $bieding): ?>
                            <tr>
                                <td><?= $bieding['BodDag'];?></td>
                                <td><?= ucfirst($bieding['Gebruiker']);?></td>
                                <td><?= '€' . number_format($bieding['Bodbedrag'], 2, ',', '');?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="message-body">
                            <p>Er zijn nog geen biedingen geplaatst.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php  if ($veilingOpen && $loggedIn): ?>
                <div class="message is-warning">
                    <div class="message-header">
                        <p>Sluit vanaf <?=$dag . '-' . $maand . '-' . $jaar . ' ' . $eindeTijdstip?></p>
                    </div>
                    <div class="message-body">
                        <h1 class="subtitle">Breng een bod uit!</h1>
                        <div class="field has-addons">
                            <form class="bodform" method="POST" action="/Voorwerp/Pagina/<?= $item['Voorwerpnummer']?>">
                                <div class="control" style="display: flex">
                                    <div class="field">
                                        <input type="text" class="input button euroSign" value="€" disabled>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="inputBod" class="input" placeholder="Bedrag">
                                    </div>
                                    <div class="field">
                                        <input type="submit" name="btnSubmit" class="button is-success" value="Bieden">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <p class="content is-small pl-2">Let op: EenmaalAndermaal is niet de verkoper. Wij veilen en factureren als bemiddelaar in opdracht van een derde partij, de verkoper.</p>
                    </div>
                </div>
                <?php  elseif ($veilingOpen && !$loggedIn): ?>
                    <div class="message is-warning">
                        <div class="message-header">
                            <p>Sluit vanaf <?=$dag . '-' . $maand . '-' . $jaar . ' ' . $eindeTijdstip?></p>
                        </div>
                        <div class="message-body">
                            <p>Om te bieden moet je zijn ingelogd. <a href="/Login">Klik hier</a> om naar de inlog pagina te gaan.</p>
                        </div>
                    </div>
                <?php else: ?>
                <div class="message is-danger">
                    <div class="message-header">
                        <p>Veiling Gesloten!</p>
                    </div>
                    <div class="message-body">
                        <p>Deze veiling is helaas gesloten, bekijk het overige aanbod <a href="/Home">hier.</a></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
