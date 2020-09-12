<style>
    #sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .user-position:hover {
        background: #e68c23;
        color: #00305e !important;
    }
</style>
<?php echo $this->Html->script(['jquery-ui']); ?>
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
        <script>
    var currentPostion = 0;
    var newPostion = 0;
    $(function () {
        $("#sortable").sortable({
            start: function (e, ui) {
                currentPostion = ui.item.index();
            },
            stop: function (e, ui) {
                newPostion = ui.item.index();
                cl(newPostion);
                //setTimeout(function () {
                $('.user-position').each(function (ind) {
                    var ind = <?= ((empty($_REQUEST['page']) ? 1 : $_REQUEST['page']) - 1) * $limit; ?> +ind;
                    $(this).attr('data-position', ind + 1);
                    $(this).children('span.position-order').html(ind + 1)
                });
            }
        });
        $("#sortable").disableSelection();

        $('.position-order').blur(function () {

        });

        setTimeout(function () {
            $('#loaderBox').hide();
            $('#sortable').fadeIn();
        }, 500);
    });
</script>
<h3>Distributor Rotator Slots: </h3>
<hr/>
<div id="loaderBox">
    <h5 class="text-center my-5">Loading .. <i class="fa fa-asterisk fa-spin"></i></h5>
</div>
<div id="sortable" class="row" style="display: none">
    <?php foreach ($userPositions as $position) { ?>
        <?php
        $length = 20;
        $email = $position->user->email;
        $email = (strlen($email) > $length) ? substr($email, 0, $length) . ".." : $email;
        ?>
        <div class="ui-state-default col-md-2 box-shadow-light rounded p-3 m-2 user-position text-left"
             style="cursor: grab"
             data-id="<?= $position->id; ?>"
             data-position="<?= $position->position_order; ?>"
             title="<?= $position->user->email; ?>"

        >
            <i class="fa fa-user"></i> <?= $position->user->name; ?><br/>
            <i class="fa fa-envelope"></i> <?= $email; ?><br/>
            <i class="fa fa-stop"></i> Slot No.: <span class="position-order"><?= $position->position_order; ?></span>

        </div>
    <?php } ?>
</div>
<?= $this->element('Admin/pagination'); ?>