<?php
    $url = $args["urlArgs"]["helperUrl"];
    $amount = count($args["breadcrumList"]);
    $count = 0;
?>

<div class="section">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="/Rubrieken/Pagina" aria-current="page">Alle Veilingen</a></li>
            <?php foreach ($args["breadcrumList"] as $breadcrumPart):
                $count++;
                if ($count < $amount): ?>
                    <li><a href="<?=$breadcrumPart["Rubrieknummer"]?>"><?=$breadcrumPart['Rubrieknaam']?></a></li>
                <?php else: ?>
                    <li class="is-active"><a href="<?=$breadcrumPart["Rubrieknummer"]?>" aria-current="page"><?=$breadcrumPart['Rubrieknaam']?></a></li>
                <?php endif; endforeach; ?>
        </ul>
    </nav>

    <?php if (count($args["Rubrieken"]) > 0): ?>

    <div class="columns is-multiline">

    <?php foreach ($args["Rubrieken"] as $rubriek): ?>
        <div class="column is-2 is-flex">
            <a class="box" style="width: 100%" href="/Rubrieken/Pagina/1/<?=$rubriek["rubrieknummer"]?>">
                <p class="title is-7"><?=$rubriek["Rubrieknaam"]?></p>
            </a>
        </div>
    <?php endforeach; ?>

    </div>
<?php endif ?>
</div>
<div class="section">

    <?php
    $product = $args["urlArgs"]["productpage"];
    $rubriek = $args["urlArgs"]["currentRubriekId"];
    $pages = ceil($args["pageAmount"]);
    ?>

    <nav class="pagination pb-1" aria-label="pagination">
        <?php if ($product > 1): ?>
            <a href="/Rubrieken/Pagina/<?=$product - 1?>/<?=$rubriek?>" class="pagination-previous" title="Vorige">Vorige</a>
        <?php endif; ?>

        <?php if ($product < $pages): ?>
            <a href="/Rubrieken/Pagina/<?=$product + 1?>/<?=$rubriek?>" class="pagination-previous" title="Volgende">Volgende</a>
        <?php endif; ?>

        <?php if (count($args["Producten"]) > 0): ?>
            <ul class="pagination-list">

            <?php for ($i = 1; $i <= $pages; $i++):
                if ($i >= $product - 3 && $i <= $product + 3):
                    if ($i == $product): ?>
                        <li><a href="/Rubrieken/Pagina/<?=$rubriek?>" class="pagination-link is-current" aria-label="Page <?=$i?>" aria-current="page"><?=$i?></a></li>
                    <?php else: ?>
                        <li><a href="/Rubrieken/Pagina/<?=$i?>/<?=$rubriek?>" class="pagination-link" aria-label="Page <?=$i?>" aria-current="page"><?=$i?></a></li>
                    <?php endif;
                endif; endfor;?>
            </ul>
        <?php endif; ?>
    </nav>

    <?php if (count($args["Producten"]) > 0): ?>
    <div class="columns is-multiline">

        <?php foreach ($args["Producten"] as $producten): ?>

        <div class="column is-3">

            <div class="item m-padding">
                <a href="/Voorwerp/Pagina/<?=$producten["Voorwerpnummer"]?>">
                    <div class="card is-shadowless is-slightly-rounded">
                        <div class="card-image">
                            <figure class="image">
                                <?php if ($producten["Filenaam"] == null): ?>
                                    <img src="<?=ROOT?>/Data/img/placeholder-image.png"  alt="<?=$producten["Titel"]?>"/>
                                <?php else: ?>
                                    <img src="<?=ROOT?>/uploads/<?=$producten["Filenaam"]?>"  alt="<?=$producten["Titel"]?>"/>
                                <?php endif ?>
                            </figure>
                        </div>

                        <div class="card-content">
                            <div class="content">
                                <p class="nowrap is-marginless">
                                    <?php if (strlen($producten["Titel"]) < 30): ?>
                                    <span class="title is-6 is-capitalized"><?=$producten["Titel"]?></span>
                                <?php else: ?>
                                    <span class="title is-6 is-capitalized"><?=substr($producten["Titel"], 0, 30);?>..</span>
                                <?php endif; ?>
                                </p>

                                <div class="columns is-mobile">
                                    <div class="column">
                                        <?php if ($producten["bod"] == null): ?>
                                            <?= '€' . number_format($producten["Verkoopprijs"], 2, ',', '');?>
                                        <?php else: ?>
                                            <?= '€' . number_format($producten["bod"], 2, ',', '');?>
                                        <?php endif ?>
                                        <?php if ($producten["VeilingGesloten"] && $producten["VeilingStatus"] == 1): ?>
                                            <p>Gereserveerd!</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <?php endforeach; ?>
        </div>

        <nav class="pagination pb-5" aria-label="pagination">
            <?php if ($product > 1): ?>
                <a href="/Rubrieken/Pagina/<?=$product - 1?>/<?=$rubriek?>" class="pagination-previous" title="Vorige">Vorige</a>
            <?php endif; ?>

            <?php if ($product < $pages): ?>
                <a href="/Rubrieken/Pagina/<?=$product + 1?>/<?=$rubriek?>" class="pagination-previous" title="Volgende">Volgende</a>
            <?php endif; ?>

            <?php if (count($args["Producten"]) > 0): ?>
            <ul class="pagination-list">

                <?php for ($i = 1; $i <= $pages; $i++):
                    if ($i >= $product - 3 && $i <= $product + 3):
                    if ($i == $product): ?>
                        <li><a href="/Rubrieken/Pagina/<?=$rubriek?>" class="pagination-link is-current" aria-label="Pagina <?=$i?>" aria-current="page"><?=$i?></a></li>
                    <?php else: ?>
                        <li><a href="/Rubrieken/Pagina/<?=$i?>/<?=$rubriek?>" class="pagination-link" aria-label="Pagina <?=$i?>" aria-current="page"><?=$i?></a></li>
                    <?php endif;
                endif; endfor; ?>
            </ul>
            <?php endif; ?>
        </nav>
    <?php endif ?>
</div>
