<div class="hero is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="steps">
                <div class="step-item is-active is-success">
                    <div class="step-marker">
                        1
                    </div>

                    <div class="step-details">
                        <p class="step-title">Stap 1</p>
                        <p>Email verifiëren</p>
                    </div>
                </div>
               <?php if($args["steps"] == 2 || $args["steps"] == 3) { ?> <div class="step-item is-active is-success">
                    <?php } else { ?>
                    <div class="step-item">
                        <?php } ?>
                    <div class="step-marker">2</div>
                    <div class="step-details">
                        <p class="step-title">Stap 2</p>
                        <p>Gegevens invoeren</p>
                    </div>
                </div>

                    <?php if($args["steps"] == 3) { ?> <div class="step-item is-active is-success">
                        <?php } else { ?>
                        <div class="step-item">
                            <?php } ?>
                    <div class="step-marker">
                    <span class="icon">
                            <i class="fa fa-flag"></i>
                        </span>
                    </div>
                    <div class="step-details">
                        <p class="step-title">Stap 3</p>
                        <p>Klaar</p>
                    </div>
                </div>

            </div>
