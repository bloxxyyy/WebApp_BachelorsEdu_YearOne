
<div class="container is-fluid">
    <div class="padding">
        <h1 class="title has-text-centered"><i class="fas fa-user"></i> Speciaal voor jou</h1>


        <div class="columns is-fluid is-flex-wrap-wrap">
            <?php foreach($args["recentProducts"] as $recentProduct):?>
                <div class="column is-9by16">
                    <a href="<?=ROOT?>Voorwerp/Pagina/<?=$recentProduct["Voorwerpnummer"]?>">
                    <div class="column-image">
                        <?php if ($recentProduct["Filenaam"] == null): ?>
                            <img src="<?=ROOT?>/Data/img/placeholder-image.png"  alt="<?=$recentProduct["Titel"]?>"/>
                        <?php else: ?>
                            <img src="<?=ROOT?>/uploads/<?=$recentProduct["Filenaam"]?>"  alt="<?=$recentProduct["Titel"]?>"/>
                        <?php endif ?>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <?php if (strlen($recentProduct["Titel"]) < 20): ?>
                            <h6><?=$recentProduct["Titel"]?></h6>
                            <?php else: ?>
                                <h6><?=substr($recentProduct["Titel"], 0, 20);?>..</h6>
                            <?php endif; ?>

                            <?php if ($recentProduct["Bodbedrag"] == null): ?>
                                <?= '€' . number_format($recentProduct['Verkoopprijs'], 2, ',', '');?>
                            <?php else: ?>
                                <?= '€' . number_format($recentProduct['Bodbedrag'], 2, ',', '');?>
                            <?php endif ?>
                            <p><?=$recentProduct["RemainingTime"]?></p>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

