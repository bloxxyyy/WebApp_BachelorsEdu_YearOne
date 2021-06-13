<?php if (isset($_GET['Leeg'])): ?>
    <div class="notification is-danger">
        <button class="delete"></button>
        Error! Je hebt een of meerdere velden niet ingevuld.
    </div>
<?php endif; ?>

<?php if (isset($_GET['Fout'])): ?>
    <div class="notification is-danger">
        <button class="delete"></button>
        Error! Er ging iets niet goed, probeer het nog eens.
    </div>
<?php endif; ?>

<?php if (isset($_GET['Success'])): ?>
    <div class="notification is-success">
        <button class="delete"></button>
        Gelukt! Check je e-mail voor de verificatielink om je e-mail te verifiëren.
    </div>
<?php endif; ?>

<?php if (isset($_GET['bestaatAl'])): ?>
    <div class="notification is-danger">
        <button class="delete"></button>
        Error! E-mail is al in gebruik.
    </div>
<?php endif; ?>

<div class="columns is-centered">
    <div class="column is-12">

        <form action="/Register/DoRegister" method="POST" class="box">
            <div class="field">
                <div class="title">Maak gratis een account aan.</div>
                <div class="subtitle">
                    <span>Vul je e-mailadres in ter verificatie.</span>
                    <p>Je ontvangt een e-mail op het opgegeven a-mailadres om je te verifiëren.</p>
                </div>
                <label class="label">E-mail</label>
                <div class="control has-icons-left">
                    <label for="email"></label>
                    <input type="email" id="email" name="email" class="input" placeholder="E-mail">
                    <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                </div>
            </div>

            <div class="field">
                <input type="submit" value="Stuur e-mail" class="button is-success">
            </div>


        </form>
    </div>
    </div>
    </div>
    </div>
    </div>

