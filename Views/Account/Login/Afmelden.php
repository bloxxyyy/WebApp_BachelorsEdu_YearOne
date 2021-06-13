<div class="column is-9">

    <?php if ($args["fout"] != null): ?>
    <div class="notification is-danger">
        <button class="delete"></button>
        <?=$args["fout"]?>
    </div>
    <?php endif; ?>

    <section class="hero is-primary welcome is-small mb-5">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Verwijder je account</h1>
                <h2 class="subtitle">Verwijder al je account gegevens</h2>
            </div>
        </div>
    </section>

    <div class="columns is-centered">
        <div class="column is-12">
            <form action="Afmelden/VerwijderAccount" method="POST">
                <label for="Antwoord">Vraag: <?=$args['vraag']?></label>
                <input id="Antwoord" class="input" type="text" name="Antwoord" placeholder="Mijn antwoord..">

                <button type="submit" class="button is-danger mt-1">Verwijder mijn account</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>