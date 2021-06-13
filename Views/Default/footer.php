<div class="content-wrapper">

</div>
<footer class="footer is-primary">
        <div class="level">
            <div class="level-left">
                <div class="level-item">

                    <a class="title is-4" href="/Home">
                    <img src="https://iproject18.ip.aimsites.nl/Data/img/splash.png" alt="" width="20" height="20" />
                    </a>
                </div>
            </div>
            <div class="level-right">&copy; 2021 EenmaalAndermaal</div>
        </div>

</footer>

<script src="<?=ROOT?>Data/javascript/jquery-git.js"></script>
<script src="<?=ROOT?>Data/javascript/range.js"></script> <script src="<?=ROOT?>Data/javascript/jquery.countdown.js"></script>
<script>


    $(function(){
        $('.countdown').each(function(){
            $(this).countdown($(this).attr('value'), function(event) {
                $(this).text(
                    event.strftime('%Hu %Mm %Ss')
                );
            });
        });
    });

</script>

<!-- partial -->
<script src="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/js/bulma-carousel.min.js"></script>
<script  src="<?=ROOT?>Data/javascript/script.js"></script>
</body>
</html>
