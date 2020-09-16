<?php
$type = empty($type) ? "Users" : $type;
$model = empty($model) ? "Users" : $model;
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 import-sec" id="mapFieldsBox">
        <h3 class="mt-2 mb-4 h3">Export Distributor CSV File, Choose fields</h3>
        <hr/>
        <!-- Tab panes -->
        <div class="row">
            <div class="col-md-12">

                <div class="col align-self-center">
                    <label class="form-check-inline u-check g-color-gray-dark g-font-size-12 g-pl-25 mb-0">
                        <input type="checkbox" name="fields[]" value="all"
                               class="select-all js-select g-hidden-xs-up g-pos-abs g-top-0 g-left-0">
                        <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                            <i class="fa" data-check-icon=""></i>
                        </div>
                        Select All
                    </label>
                </div>
                <hr/>
            </div>

            <?php foreach ($mappingFields as $field) { ?>

                <div class="col-md-6">

                    <div class="col align-self-center">
                        <label class="form-check-inline u-check g-color-gray-dark g-font-size-12 g-pl-25 mb-0">
                            <input type="checkbox" name="<?= $field['as'] ?>" value="<?= $field['name'] ?>"
                                   class="mapped-field   js-select g-hidden-xs-up g-pos-abs g-top-0 g-left-0 <?= (($field['required']) ? "required-field" : "select-item") ?>" <?= (($field['required']) ? "checked onclick='return false;'" : "") ?>>
                            <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                <i class="fa" data-check-icon=""></i>
                            </div>
                            <?= $field['label']; ?>
                        </label>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-10">
                <input type="hidden" id="exportInModel" name="model" value="<?= $model; ?>">
                <input type="hidden" id="exportRelatedModel" name="model" value="<?= implode(",", $relatedModels); ?>">

                <?php foreach($defaultValueFields as $field){ ?>
                    <input type="hidden" class="mapped-field-default" name="<?= $field['as'] ?>" value="<?= $field['name']; ?>">
                <?php } ?>

                <button class="btn btn-dark-blue pull-right" id="exportMappedFields"><i class="fa fa-download"></i>
                    Export
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
<script>
    $(function () {

        $('.select-all').click(function () {
            $('.select-item').prop("checked", $(this).prop("checked"));
        });

        $('.select-item').click(function () {
            $('.select-all').prop("checked", $('.select-item').length == $('.select-item:checked').length);
        });

        $('#exportMappedFields').click(function () {
            $('.map-error').hide();
            var error = false;
            var requiredFields = {};
            $('.map-required').each(function () {
                if ($(this).val().length <= 0) {
                    error = true;
                    $('#' + $(this).attr('id') + "_error").show();
                }

                requiredFields[$(this).attr('name')] = $(this).val();
            });



            if (!error) {

                var fieldMap = {};
                $('.mapped-field:checked').each(function () {

                    fieldMap[$(this).attr('name')] = $(this).val();
                });

                $('.mapped-field-default').each(function () {
                    fieldMap[$(this).attr('name')] = $(this).val();
                });


                var model = $('#exportInModel').val();
                var relatedModels = $('#exportRelatedModel').val();

                $.ajax({
                    url: SITE_URL + "admin/admins/export",
                    type: "POST",
                    data: {
                        field_map: fieldMap,
                        model: model,
                        related_model: relatedModels,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $('#exportMappedFields').html('Please Wait.. <i class="fa fa-asterisk fa-spin"></i>');
                        $('#exportMappedFields').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            window.open(response.data.url, '_blank');
                            window.location.reload();
                        }
                    }
                });
            }
        });

    });
</script>
