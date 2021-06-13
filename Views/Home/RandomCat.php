    <div class="padding">
        <div class="columns">
            <?php foreach($args["productsByRandomRubrieks"] as $rubriekProduct):?>
            <div class="column">
                <a href="<?=ROOT?>Voorwerp/Pagina/<?=$rubriekProduct["product"]["Voorwerpnummer"]?>">
                <div class="box is-9by16 has-text-black">
                    <?php if (strlen($rubriekProduct["rubriekNaam"]) < 17): ?>
                        <h4 class="title"><?=$rubriekProduct["rubriekNaam"]?></h4>
                    <?php else: ?>
                        <h4 class="title"><?=substr($rubriekProduct["rubriekNaam"], 0, 17);?>..</h4>
                    <?php endif; ?>
                    <div class="card-image-cat">
                    <figure class="image is-1by1">
                        <?php if ($rubriekProduct["product"]["Filenaam"] == null): ?>
                            <img src="<?=ROOT?>/Data/img/placeholder-image.png" alt="<?=$rubriekProduct["product"]["Titel"]?>"/>
                        <?php else: ?>
                            <img src="<?=ROOT?>/uploads/<?=$rubriekProduct["product"]["Filenaam"]?>" alt="<?=$rubriekProduct["product"]["Titel"]?>"/>
                        <?php endif ?>
                    </figure>
                    </div>


                    <div class="box pb-0 has-text-black is-shadowless">
                        <div class="columns is-mobile subtitle-is-size-6-touch">
                            <span class="column">
                                  <?php if ($rubriekProduct["product"]["Bodbedrag"] == null): ?>
                                      <?= '€' . number_format($rubriekProduct["product"]["Verkoopprijs"], 2, ',', '');?>

                                  <?php else: ?>
                                      <?= '€' . number_format($rubriekProduct["product"]["Bodbedrag"], 2, ',', '');?>

                                 <?php endif ?>
                            </span>
                            <span class="column has-text-right"><?=$rubriekProduct["product"]["RemainingTime"]?></span>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
