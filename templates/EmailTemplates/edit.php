<?= $this->Html->script('ckeditor/ckeditor'); ?>
<?php
$params = [
    'form'   => [
        'options' => [
            'type'       => 'post',
            'novalidate' => true,
            'id'         => 'EmailTemplateForm'
        ],
        'heading' => 'Edit Email Template'
    ],
    'fields' => [
        [
            'name'    => 'id',
            'value' => $emailTemplate->id,
            'type' => 'hidden',
        ],
        [
            'name'    => 'label',
            'columns' => 12
        ],
        ['name' => 'empty'],
        [
            'name'    => 'subject',
            'columns' => 12
        ],
        ['name' => 'empty'],
        [
            'name'    => 'preview_line',
            'columns' => 12
        ],
        ['name' => 'empty'],
        [
            'name'    => 'template',
            'type'    => 'textarea',
            'class'   => 'ckeditor',
            'columns' => 12
        ],
        ['name' => 'empty'],
    ]
];
?>
<?php
if ($emailTemplate->category == "Client List Default") {
    $params['fields'][] = [
        'name'    => 'go_to',
        'type' => 'hidden',
        'value' => 'realtorTemplates',
    ];
}
?>
    <style>
        [aria-labelledby] {
            opacity: 1 !important;
        }

        #topBreadcrumb {
            display: none;
        }
    </style>
    <div class="row mt-4">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-10"> <?php $this->AdminForm->create($params); ?> </div>
        <div class="col-md-1">&nbsp;</div>
    </div>


    <script>
        $(function () {
            // for (var i in CKEDITOR.instances) {
            //     CKEDITOR.instances[i].on('blur', function (e) {
            //         $('#' + this.name + "Preview").html(this.getData());
            //     });
            // }

            $('#topBreadcrumb').hide();

            CKEDITOR.config.placeholder_select = {
                placeholders: <?= json_encode(["REFERRAL_URL"]) ?>,
                format: '[%placeholder%]'
            };


            setInterval(function () {

                for (var i in CKEDITOR.instances) {
                    $('#Template').val(CKEDITOR.instances[i].getData());
                }

                $.ajax({
                    type:"POST",
                    url:SITE_URL+'emailTemplates/save',
                    data:$('#EmailTemplateForm').serialize(),
                    dataType:"json",
                    success:function (resp) {
                        $('#Id').val(resp.id);
                        //Do something -here
                    }
                });

            }, 10000);
        });
    </script>
<?= $this->element('image_media') ?>