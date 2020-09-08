<?php
echo $this->Html->css(['uploadfile']);
echo $this->Html->script(['jquery-ui', 'jquery.uploadfile', 'jquery.imgareaselect.min']);
$type = empty($type) ? "Users" : $type;
$model = empty($model) ? "Users" : $model;
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 import-sec" id="chooseCsvBox">
        <h3 class="mt-2 mb-4">Choose CSV File</h3>
        <!-- Tab panes -->
        <div id="nav-2-1-accordion-default-ver-big-icons " class="tab-content">
            <div class="tab-pane fade show active" id="nav-2-1-accordion-default-ver-big-icons--1 ml-3" role="tabpanel">
                <div id="multipleFileUploader" style="display: none"></div>
                <input type="hidden" name="type" id="fileType" value="CSV"/>
                <input type="hidden" name="category" id="fileCategory" value="CSV"/>
                <div class="file-upload-btn rounded-2x" id="fileUploadBtn">
                    <div
                            class="g-parent g-pos-rel g-height-230 g-bg-gray-light-v8--hover g-brd-around g-brd-style-dashed g-brd-gray-light-v7 g-brd-lightblue-v3--hover g-rounded-4 g-transition-0_2 g-transition--ease-in g-pa-15 g-pa-30--md g-mb-60">
                        <div class="d-md-flex align-items-center g-absolute-centered--md w-100 g-width-auto--md">
                            <div>
                                <div
                                        class="g-pos-rel g-width-80 g-width-100--lg g-height-80 g-height-100--lg g-bg-gray-light-v8 g-bg-white--parent-hover rounded-circle g-mb-20 g-mb-0--md g-transition-0_2 g-transition--ease-in mx-auto mx-0--md">
                                    <i class="fa fa-upload g-absolute-centered g-font-size-30 g-font-size-36--lg g-color-lightblue-v3"></i>
                                </div>
                            </div>
                            <div class="text-center text-md-left g-ml-20--md"><h3
                                        class="g-font-weight-400 g-font-size-16 g-color-black g-mb-10">
                                    Import <?= $type; ?></h3>
                                <p class="g-font-weight-300 g-color-gray-dark-v6 mb-0">Only CSV are supported.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ajax-file-upload-container" id="ajaxContainer"></div>
            </div>

            <div class="tab-pane fade" id="nav-2-1-accordion-default-ver-big-icons--2" role="tabpanel">
                <div class="row" id="galleryImages"></div>
            </div>
            <div class="tab-pane fade" id="nav-2-1-accordion-default-ver-big-icons--3" role="tabpanel">
                <div class="row" id="userImages"></div>
            </div>
            <button class="btn btn-primary" id="chooseSelectedImage" style="display: none;">Choose</button>

        </div>
    </div>
    <div class="col-md-10 import-sec" id="mapFieldsBox" style="display: none">
        <h3 class="mt-2 mb-4 h3">Map Fields</h3>
        <hr />
        <!-- Tab panes -->
        <div class="row">

            <?php foreach ($mappingFields as $field) { ?>
                <?php
                $title = "Map " . ucwords($field['label']);
                $attributes = [
                    'class'         => "mapped-field form-control u-select--v3-select u-sibling w-100 u-select--v3 g-pos-rel g-brd-gray-light-v7 " . (($field['required']) ? "map-required" : ""),
                    'id'            => "field_" . $field['name'],
                    'style'         => "height:42px !important; margin-top:-10px;",
                    'title'         => $title,
                    'empty'         => $title,
                    'options'       => [],
                    'label'         => false,
                    'data-required' => $field['required']
                ];
                ?>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"><b><?= $field['label']; ?><?php if ($field['required']) { ?><sup><i
                                            class="fa fa-asterisk g-font-size-8 g-color-red"></i></sup><?php } ?></b>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control($field['name'], $attributes); ?>
                            <label for="field_<?= $field['name']; ?>" id="field_<?= $field['name']; ?>_error"
                                   class="error map-error hide-me">Please select mapping field.</label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-12">
                <?php foreach ($defaultValueFields as $field) { ?>
                    <input type="hidden" class="default-value-field" name="<?= $field['name']; ?>"
                           value="<?= $field['value']; ?>">
                <?php } ?>
                <input type="hidden" id="filePath" name="file_path" value="">
                <input type="hidden" id="importInModel" name="model" value="<?= $model; ?>">
                <button class="btn btn-dark-blue pull-right" id="importMappedFields"><i class="fa fa-upload"></i> Import
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-10 import-sec" id="importLogBox" style="display: none">
        <h3 class="mt-2 mb-4 h3">Import Log</h3>
        <div class="row mb-4">
            <div class="col-md-4">
                <i class="fa fa-users"></i> Total Records Found: <span id="totalToImport"></span>
            </div>
            <div class="col-md-4">
                <i class="fa fa-check"></i> Successfully Imported: <span id="successfullyImported"></span>
            </div>
            <div class="col-md-4">
                <i class="fa fa-times"></i> Could not Imported: <span id="notImported"></span>
            </div>
        </div>
        <ul id="importLog"></ul>
    </div>
    <div class="col-md-1"></div>
</div>
<script>
    $(function () {


        $('#fileUploadBtn').on('click', function () {
            $('#ajax-upload-id').click();
        });

        var settings = {
            url: SITE_URL + "admin/admins/uploadImportCsv",
            method: "POST",
            allowedTypes: "csv",
            fileName: "file",
            multiple: false,
            showQueueDiv: 'ajaxContainer',
            showError: true,
            dragdropWidth: '100%',
            statusBarWidth: '100%',
            showFileCounter: false,
            maxFileCount: 10,
            onSuccess: function (files, data, xhr, pd) {
                var d = JSON.parse(data);
                if (d.code == 400) {
                    pd.progressbar.removeClass('ajax-file-upload-bar').addClass('ajax-file-upload-red').html("Failed");
                } else {
                    $('#filePath').val(d.data.path);
                    $('.import-sec').hide();
                    $('#mapFieldsBox').fadeIn();

                    var options = [];
                    $.each(d.data.fields, function (ind, field) {
                        options.push('<option value="' + ind + '">' + field + '</option>');
                    });
                    $('.mapped-field').append(options.join(""));
                }
            },
            onSelect: function (files) {
            },
            onError: function (files, status, errMsg) {
                $("#finalStatus").html("<span class='g-color-red'>Upload is Failed</span>");
            }
        }

        $("#multipleFileUploader").uploadFile(settings);

        $('#importMappedFields').click(function () {
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

                var defaultValueFields = {};

                $('.default-value-field').each(function () {
                    defaultValueFields[$(this).attr('name')] = $(this).val();
                });

                var fieldMap = {};
                $('.mapped-field').each(function () {
                    fieldMap[$(this).attr('name')] = $(this).val();
                });

                var model = $('#importInModel').val();

                $.ajax({
                    url: SITE_URL + "admin/admins/import",
                    type: "POST",
                    data: {
                        file_path: $('#filePath').val(),
                        default_value: defaultValueFields,
                        field_map: fieldMap,
                        model: model,
                        required_fields: requiredFields,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $('#importMappedFields').html('Please Wait.. <i class="fa fa-asterisk fa-spin"></i>');
                        $('#importMappedFields').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.code == 200) {

                            $('.import-sec').hide();
                            $('#importLogBox').fadeIn();

                            $('#totalToImport').html(response.data.totalToImport);
                            $('#successfullyImported').html(response.data.successfullyImported);
                            $('#notImported').html(response.data.notImported);

                            var logs = [];
                            $.each(response.data.logs, function (ind, log) {
                                logs.push('<li>' + log + '</li>');
                            });

                            $('#importLog').html(logs.join(""));
                        }
                    }
                });
            }
        });

    });
</script>
