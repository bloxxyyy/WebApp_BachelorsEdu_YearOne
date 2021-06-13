 <div class="column is-9">
     <?php if (isset($_GET['NewUser'])): ?>
         <div class="notification is-success">
             <button class="delete"></button>
             Gelukt! Je bent nu succesvol geregistreerd als verkoper.
         </div>
     <?php endif; ?>
    <section class="hero is-primary welcome is-small">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Hoi, <?php echo $_SESSION["Voornaam"]; ?>
                </h1>
                <h2 class="subtitle">
                    Welkom bij je EenmaalAndermaal instellingen scherm.
                </h2>
            </div>
        </div>
    </section>

    <div class="columns mt-2">
        <div class="column is-6">
            <div class="card events-card">
                <header class="card-header">
                    <p class="card-header-title">
                        Mijn veilingen
                    </p>
                </header>
                <div class="card-table">
                    <div class="content">
                        <table class="table is-fullwidth is-striped">
                            <tbody>
                            <?php foreach ($args['MySales'] as $sales): ?>
                                    <tr>
                                        <td width="5%"><i class="fas fa-gavel"></i></td>
                                        <td>
                                            <a href="Voorwerp/Pagina/<?=$sales['Voorwerpnummer']?>">
                                            <?= $sales["Titel"] ?>
                                        </td>
                                    </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="/Rubrieken" class="card-footer-item">Alle Veilingen</a>
                </footer>
            </div>
        </div>
        <div class="column is-6">
            <div class="card events-card">
                <header class="card-header">
                    <p class="card-header-title">
                        Mijn Biedingen
                    </p>
                </header>
                <div class="card-table">
                    <div class="content">
                        <table class="table is-fullwidth is-striped">
                            <tbody>
                            <?php foreach ($args['MyBids'] as $sales): ?>
                                <tr>
                                    <td width="5%"><i class="fas fa-gavel"></i></td>
                                    <td>
                                        <a href="Voorwerp/Pagina/<?=$sales['Voorwerpnummer']?>">
                                            <?= $sales["Titel"] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="/Rubrieken" class="card-footer-item">Alle Veilingen</a>
                </footer>
            </div>
        </div>
    </div>
</div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
