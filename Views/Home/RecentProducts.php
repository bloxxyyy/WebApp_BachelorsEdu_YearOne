<section class="hero has-shadow is-primary">
    <div class="hero-body">
        <div class="container">

            <h2 class="title has-text-centered">
                <i class="fas fa-gavel"></i>
                Recente veilingen
            </h2>

            <div id="trend-slide" class="carousel">

                <?php foreach($args["recentProducts"] as $recentProduct):?>
                    <div class="item m-padding">
                        <a href="<?=ROOT?>Voorwerp/Pagina/<?=$recentProduct["Voorwerpnummer"]?>">
                            <div class="card is-shadowless is-slightly-rounded">
                                <div class="card-image">
                                    <figure class="image">
                                        <?php if ($recentProduct["Filenaam"] == null): ?>
                                            <img src="<?=ROOT?>/Data/img/placeholder-image.png" alt="<?=$recentProduct["Titel"]?>"/>
                                        <?php else: ?>
                                            <img src="<?=ROOT?>uploads/<?=$recentProduct["Filenaam"]?>" alt="<?=$recentProduct["Titel"]?>"/>
                                        <?php endif ?>
                                    </figure>
                                </div>

                                <div class="card-content">
                                    <div class="content">
                                        <p class="nowrap is-marginless">
                                            <?php if (strlen($recentProduct["Titel"]) < 20): ?>
                                                <span class="title is-6 is-capitalized"><?=$recentProduct["Titel"]?></span>
                                            <?php else: ?>
                                                <span class="title is-6 is-capitalized"><?=substr($recentProduct["Titel"], 0, 20);?>..</span>
                                            <?php endif; ?>
                                        </p>

                                        <div class="columns is-mobile">
                                            <div class="column">
                                                <?php if ($recentProduct["Bodbedrag"] == null): ?>
                                                    <?= '€' . number_format($recentProduct['Verkoopprijs'], 2, ',', '');?>
                                                <?php else: ?>
                                                    <?= '€' . number_format($recentProduct['Bodbedrag'], 2, ',', '');?>
                                                <?php endif ?>
                                                <p><?=$recentProduct["RemainingTime"]?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>
