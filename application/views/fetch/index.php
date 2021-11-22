<div class="container mt-5">

    <?php if(isset($error)): ?>

        <div class="alert alert-danger">
            <?=$error ?>
        </div>
        <?php else: ?>

            <div class="alert alert-success">
                <?=count($tickets) ?> Ticket(s) have been newly uploaded.
            </div>

        <?php endif ?>

    </div>