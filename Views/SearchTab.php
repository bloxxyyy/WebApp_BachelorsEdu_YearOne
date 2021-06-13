<section class="hero has-shadow is-primary" >

    <div class="hero-body">
        <div class="container">
        <h2 class="title has-text-centered pt-5"><i class="fas fa-gavel"></i> Alle veilingen</h2>
        <div class="field">
            <label for="search" class="label">Zoek</label>
            <div class="control">
                <input class="input" type="text" id="search" name="Search" placeholder="Zoek...">
            </div>
            <p class="help">Vul de gewenste zoektermen in</p>
        </div>

        <div class="is-flex is-justify-content-space-between">
            <div class="field">
                <label for="search" class="label">Afstand</label>
                <div class="control">
                    <div class="is-flex is-align-items-center">
                    <input class="input" type="text" id="afstand" name="Afstand" placeholder="15">
                        <p class="mx-3">km</p>
                    </div>
                </div>
                <p class="help">De afstand in km van jou naar het voorwerp toe</p>
            </div>

            <div class="field">
                <label for="range" class="label">Prijs</label>
                <div class="control">
                    <div class="is-flex is-align-items-center">
                        <input class="input" type="range" id="range" name="range" value="15" step="1" min="0" max="1000">
                        <p class="mx-3" id="rangeCount">€15</p>
                    </div>
                </div>
                <p class="help">Prijsbereik</p>
            </div>
        </div>
        </div>

</div>
</section>