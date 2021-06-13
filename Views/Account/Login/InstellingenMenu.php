<div class="section">
    <div class="container py-5">
        <div class="columns">
            <div class="column is-3 ">
                <aside class="menu">
                    <p class="menu-label">Status: <?php
                    if ($args["isVerkoper"]):
                        ?>
                        verkoper <?php else: ?>
                        geen verkoper <?php endif; ?></p>
                    <ul class="menu-list">
                        <li><a href="/Instellingen" <?php if(!empty($args["links"] == 0)): ?>class="is-active" <?php endif; ?>>Dashboard</a></li>
                        <?php
                        if (!$args["isVerkoper"]):
                        ?> <li><a href="/VerkoperRegister" <?php if(!empty($args["links"] == 1)): ?>class="is-active" <?php endif; ?>>Word verkoper</a></li> <?php endif; ?>
                        <li><a href="/Afmelden" <?php if(!empty($args["links"] == 2)): ?>class="is-active"<?php endif; ?>>Account Verwijderen</a></li>
                    </ul>
                </aside>
            </div>
