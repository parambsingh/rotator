<?php

namespace App\View\Helper;


use Cake\View\Helper;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

class AdminListingHelper extends Helper {

    public $controller;
    public $relatedModel;
    public $obj;
    public $object;
    public $objectFieldValue;
    public $fields;
    public $field;
    public $includeStatusScript = false;
    public $hasPagination = false;
    public $paging = false;
    public $bulk;
    public $search;
    public $request;
    public $view;
    public $srNo = false;
    public $heading = false;
    public $deleteMessage = "Are you sure you want delete this?";

    public function create($params = null, $actions = ['view', 'edit', 'delete']) {
        $this->srNo = isset($params['srNo']) ? $params['srNo'] : false;
        $inputClasses = "g-hidden-xs-up g-pos-abs g-top-0 g-left-0 not-ignore";
        $labelClasses = "u-check-icon-checkbox-v4 g-absolute-centered--y g-left-0";
        $this->view = $this->getView();
        $this->request = $this->view->getRequest();
        $this->controller = isset($params['controller']) ? $params['controller'] : $this->request->getParam('controller');
        $this->object = isset($params['object']) ? $params['object'] : $this->view->get($this->view->getVars()[0]);

        $this->fields = $params['fields'];
        $this->heading = empty($params['heading']) ? $this->controller : $params['heading'];


        if (!empty($this->getView()->getRequest()->getParam('paging'))) {

            $this->paging = array_values($this->getView()->getRequest()->getParam('paging'))[0];
            if ($this->paging['count'] > 0) {
                $this->hasPagination = true;

            }

            $this->setBulk($params);
        }

        $this->setSearch($params);

        if (!empty($this->fields)) {
            $this->createSearchAndBulkActions();
            ?>
            <style>
                .color-white a {
                    color: #ffffff !important;
                }

                .sortable a {
                    color: #ffffff !important;
                }
            </style>
            <div class="table-responsive g-mb-40">
                <table cellpadding="0" cellspacing="0"
                       class="table table-bordered table-hover u-table--v3 g-color-black table-striped">
                    <thead>
                    <tr class="" style="background-color: #e68c23 !important; color: #ffffff !important;">
                        <!-- th style="width: 6%;">Sr. No.</th -->
                        <?php foreach ($this->fields as $field) { ?>
                            <?php $field['type'] = empty($field['type']) ? 'text' : $field['type']; ?>
                            <?php if (isset($field['sortable']) && $field['sortable'] == false) { ?>
                                <th scope="col"
                                    class=" <?= in_array($field['type'], ["image",
                                                                          'video']) ? "text-center" : "" ?>"><?= __(empty($field['label']) ? $field['name'] : $field['label']) ?></th>
                            <?php } else { ?>
                                <th scope="col"
                                    class="sortable"><?= $this->view->Paginator->sort($field['name'], empty($field['label']) ? null : $field['label']) ?></th>
                            <?php } ?>
                        <?php } ?>
                        <?php if (!empty($actions)) { ?>
                            <th scope="col" class="actions" style="width: 20%;"><?= __('Actions') ?></th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($this->object) <= 0) { ?>
                        <tr>
                            <td colspan="<?= count($this->fields) + (!$this->hasPagination ? 2 : 2); ?>">
                                <h3>No Record found. </h3>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($this->object as $srNo => $obj): ?>
                            <?php $this->obj = $obj; ?>
                            <tr>
                                <!-- td><?= ($srNo + (($this->paging['page'] - 1) * $this->paging['perPage']) + 1); ?></td -->
                                <?php
                                foreach ($this->fields as $field) {
                                    $field['type'] = empty($field['type']) ? 'text' : $field['type'];
                                    $this->field = $field;
                                    $this->fieldValue();
                                    ?>
                                    <td class="<?= $field['type'] == "image" ? "text-center" : "" ?>">
                                        <?php
                                        switch ($field['type']) {
                                            case 'image':
                                                {
                                                    $this->createImage();
                                                    break;
                                                }
                                            case 'video':
                                                {
                                                    $this->createVideo();
                                                    break;
                                                }
                                            case 'link':
                                                {
                                                    $this->createLink();
                                                    break;
                                                }
                                            case 'status':
                                                {
                                                    $this->createStatus();
                                                    $this->includeStatusScript = true;
                                                    break;
                                                }
                                            case 'text':
                                                {
                                                    $this->createText();
                                                    break;
                                                }
                                            case 'datetime':
                                                {
                                                    $this->createDateTime();
                                                    break;
                                                }
                                            case 'date':
                                                {
                                                    $this->createDate();
                                                    break;
                                                }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($actions)) {
                                    $this->createActions($actions);
                                }
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    </tbody>
                </table>
                <?php $this->statusScript(); ?>
                <script>
                    $(document).ready(function () {
                        var deleteBtn = null;
                        $('#selectAll').click(function (e) {
                            $('.select-row').prop('checked', $(this).is(':checked'));
                        });

                        $('.select-row').click(function (e) {
                            var totalChecks = $('.select-row').length;
                            var checkedChecks = $('.select-row:checked').length;

                            $('#selectAll').prop('checked', ((totalChecks == checkedChecks) ? true : false));
                        });

                        $('.js-select').selectpicker();

                        $('.delete-btn').click(function (e) {
                            e.preventDefault();
                            deleteBtn = $(this).attr('id');
                        });

                        $('#deleteIt').click(function (e) {
                            e.preventDefault();
                            if (deleteBtn != null) {
                                $('#' + deleteBtn.replace("btn", 'form')).submit();
                            }
                        });
                        $.HSCore.components.HSModalWindow.init('[data-modal-target]');

                        $('#applyAction').click(function (e) {
                            e.preventDefault();
                            alert('This  feature is in progress..')
                        });
                    });
                </script>
                <div id="deleteConfirmModal"
                     class="text-left g-color-white g-bg-gray-dark-v1 g-overflow-y-auto  g-pa-20"
                     style="display: none; width: 600px; height: auto; padding: 10%;">
                    <button type="button" class="close" onclick="Custombox.modal.close();">
                        <i class="hs-icon hs-icon-close"></i>
                    </button>
                    <h4 class="h4 g-mb-20">
                        Delete</h4>
                    <div calss="modal-body" style="position: relative;">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="h5"><?= $this->deleteMessage; ?></h5>
                            </div>
                            <div class="col-md-7"></div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-danger pull-left" id="deleteIt">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                                &nbsp;
                                <button type="button" class="btn btn-primary pull-right"
                                        onclick="Custombox.modal.close();">
                                    <i class="fa fa-close"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                </div>
                <link href="https://vjs.zencdn.net/7.7.5/video-js.css" rel="stylesheet"/>
                <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
                <div id="videoPlayerListModal"
                     class="text-left g-color-white g-bg-black g-overflow-y-auto "
                     style="display: none; width: auto; min-width: 640px; height: auto; min-height: 480px; padding: 3%;">
                    <button type="button" class="close" onclick="Custombox.modal.close();"
                            style="margin: -50px -50px 0 0">
                        <i class="hs-icon hs-icon-close"></i>
                    </button>

                    <div calss="modal-body text-center" style="position: relative;">
                        <video
                                id="tourVideoListPlayerJS"
                                class="video-js"
                                controls
                                preload="auto"
                                width="640"
                                height="480"
                                data-setup="{}"
                        ></video>
                        <script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
                    </div>
                    <div class="clear-both"></div>
                </div>
                <div id="showImgModal"
                     class="text-left g-color-white g-bg-gray-dark-v2 g-overflow-y-auto "
                     style="display: none; width: auto; min-width: 200px; height: auto; min-height: 200px; padding: 1%;">
                    <button type="button" class="close" onclick="Custombox.modal.close();">
                        <i class="hs-icon hs-icon-close"></i>
                    </button>
                    <div calss="modal-body text-center" style="position: relative;">
                        <div style="text-align: center; margin-top: 8%">
                            <img id="fpImageToShow" src="<?= SITE_URL; ?>files/images/default.jpg"/>
                        </div>
                        <div class="clear-both"></div>
                    </div>
                </div>
                <script>
                    var vgsPlayer, poster, url;
                    $(function () {

                        $('.load-video-player-list').hide();

                        setTimeout(function () {

                            vgsPlayer = videojs('tourVideoListPlayerJS', {
                                techOrder: ["html5"],
                                autoplay: false,
                            });

                            vgsPlayer.poster("<?=  SITE_URL . 'files/images/default_video.png'; ?>");
                            $('.load-video-player-list').fadeIn();
                        }, 1500);
                        $('.load-video-player-list').click(function (e) {
                            e.preventDefault();

                            url = $(this).attr('data-url');
                            poster = $(this).attr('data-poster');


                            var newModal = new Custombox.modal({
                                content: {
                                    target: '#videoPlayerListModal',
                                    effect: 'slide',
                                    animateFrom: 'top',
                                    animateTo: 'bottom',
                                    positionX: 'center',
                                    positionY: 'center',
                                    speedIn: 300,
                                    speedOut: 300,
                                    fullscreen: false,
                                    onClose: function () {
                                        vgsPlayer.pause();
                                    },
                                    onOpen: function () {

                                        var v = "";
                                        if (url.includes('mp4')) {
                                            v = {
                                                type: "video/mp4",
                                                src: url
                                            };
                                        } else {
                                            v = {
                                                type: "video/webm",
                                                src: url
                                            }
                                        }

                                        vgsPlayer.src([v]);
                                        vgsPlayer.poster(poster);
                                        vgsPlayer.play();
                                    }
                                }
                            });
                            newModal.open();

                        });

                        $('.container-fluid').on('click', 'img.show-img-list', function (e) {
                            e.preventDefault();

                            if ($(this).attr('data-file-type') == "FILE") {
                                window.open($(this).attr('data-file'), '_blank');
                            } else {

                                var img = $(this).attr('src');

                                var newModal = new Custombox.modal({
                                    content: {
                                        target: '#showImgModal',
                                        positionX: 'center',
                                        positionY: 'center',
                                        speedIn: 300,
                                        speedOut: 300,
                                        fullscreen: false,
                                        onClose: function () {
                                            $('#fpImageToShow').attr('src', "<?= SITE_URL; ?>files/images/default.jpg");
                                        },
                                        onOpen: function () {
                                            $('#fpImageToShow').attr('src', img.replace('small', 'large'));
                                        }
                                    }
                                });
                                newModal.open();
                            }
                        });
                    });
                </script>
            </div>
            <?php
            $this->pagination();
        }
    }

    public function fieldValue() {
        if (isset($this->field['join'])) {
            foreach ($this->field['join'] as $name) {
                $values[] = $this->getValue($name);
            }
            $values = array_filter($values);
            $this->objectFieldValue = implode(empty($this->field['separator']) ? " " : $this->field['separator'], $values);
        } else {
            switch ($this->field['name']) {
                case "phone" :
                    {
                        $this->objectFieldValue = $this->phoneFormat($this->getValue($this->field['name']));
                        break;
                    }
                case "created" :
                case "modified" :
                    {
                        $this->objectFieldValue = date(SHORT_DATE, strtotime($this->phoneFormat($this->getValue($this->field['name']))));
                        break;
                    }
                default :
                    {
                        $this->objectFieldValue = $this->getValue($this->field['name']);
                        break;
                    }
            }

        }

        if (isset($this->field['short']) && !empty($this->objectFieldValue)) {
            if (strlen($this->objectFieldValue) > $this->field['short']) {
                $this->objectFieldValue = substr($this->objectFieldValue, 0, $this->field['short']) . "..";
            }
        }


    }

    public function getValue($name) {
        $objectFieldValue = "";
        if (strpos($name, '_id') !== false) {
            $relatedModel = str_replace('_id', '', $name);

            if ($this->obj->has($relatedModel)) {
                if (!empty($this->field['related_model_fields'])) {
                    $values = [];
                    foreach ($this->field['related_model_fields'] as $f) {
                        $values[] = $this->obj->{$relatedModel}->{$f};
                    }

                    $objectFieldValue = implode(empty($this->field['separator']) ? " " : $this->field['separator'], $values);

                } else {
                    $objectFieldValue = $this->obj->{$relatedModel}->name;
                }
            } else {
                if (isset($this->field['id']) && $this->field['id'] == "show") {
                    $objectFieldValue = $this->obj->{$name};
                }
            }
        } else {
            $objectFieldValue = $this->obj->{$name};
        }

        return $objectFieldValue;
    }

    public function createImage() {
        $rounded = isset($this->field['rounded']) ? $this->field['rounded'] : true;
        $square = isset($this->field['square']) ? $this->field['square'] : true;
        $relatedModel = str_replace('_id', '', $this->field['name']);
        $image = SITE_URL . (($this->obj->has($relatedModel)) ? $this->obj->{$relatedModel}->small_thumb : 'files/images/default.jpg');
        $fileType = (($this->obj->has($relatedModel)) ? $this->obj->{$relatedModel}->file_type : 'IMAGE');
        $file = SITE_URL . (($fileType == "FILE") ? $this->obj->{$relatedModel}->image : $image);
        ?>
        <img class="img-fluid detail-img-fluid show-img-list <?= $rounded ? "rounded-circle" : ""; ?> "
             data-file-type="<?= $fileType; ?>"
             data-file="<?= $file; ?>" src="<?= $image; ?>"
             style="<?php if ($square) { ?> width:60px; height: 60px; <?php } else { ?> width:80px; max-height: 80px; <?php } ?>"
             alt="Profile Image">
        <?php
    }

    public function createVideo() {
        $relatedModel = str_replace('_id', '', $this->field['name']);
        $file = false;
        $videoTitle = "Video Not Found";
        if ($this->obj->has($relatedModel)) {
            $image = SITE_URL . $this->obj->{$relatedModel}->small_thumb;
            if ($this->obj->{$relatedModel}->file_type == "VIDEO") {
                $file = SITE_URL . $this->obj->{$relatedModel}->image;
                $videoTitle = "Click to Video";
            }

        } else {
            $image = SITE_URL . 'files/images/default_video.png';
        }
        ?>
        <div class="d-inline-block g-pos-rel ">
            <?php if ($file) { ?>
                <a
                        href="javascript:void(0);"
                        class="u-badge-v4--lg g-width-100 g-height-100 load-video-player-list"
                        data-url="<?= $file; ?>"
                        data-poster="<?= $image; ?>"

                        style="top:50%; right: 50%;"

                >

                </a>

            <?php } ?>
            <img class="img-fluid detail-img-fluid rounded-circle " src="<?= $image; ?>"
                 style="width:100px; height: 100px;"
                 alt="Video Description" title="<?= $videoTitle; ?>">
        </div>
        <?php
    }

    public function createLink() {
        $linkUrl = $this->field['url'];
        $linkUrl[] = empty($this->field['id_field']) ? $this->obj->id : $this->obj->{$this->field['id_field']};
        ?>
        <a
                href="<?= Router::url($linkUrl); ?>"
                class="<?= empty($this->field['class']) ? "" : $this->field['class']; ?>"
                data-id="<?= $this->obj->id; ?>">
            <?= empty($this->field['link_label']) ? $this->objectFieldValue : $this->field['link_label']; ?>
        </a>
        <?php
    }

    public function createStatus() {
        $anchorClasses = "btn-u btn-u-sm rounded-3x";
        $activeText = empty($this->field['active_text']) ? "Active" : $this->field['active_text'];
        $inactiveText = empty($this->field['inactive_text']) ? "Inactive" : $this->field['inactive_text'];

        $this->objectFieldValue = (int)$this->objectFieldValue;
        if ($this->objectFieldValue == -1) {
            $anchorClasses = $anchorClasses . " btn-u-orange ";
            $label = "New";
        } else {
            if ($this->objectFieldValue) {
                $label = $activeText;
            } else {
                $anchorClasses = $anchorClasses . " btn-u-orange ";
                $label = $inactiveText;

            }
        }
        $readOnly = '';
        if (isset($this->field['readonly'])) {
            $readOnly = 'disabled';
            $anchorClasses = $anchorClasses . " disabled  btn-u btn-u-default";
        } else {
            $anchorClasses = $anchorClasses . ' active-deactive';
        }
        ?>
        <button class="<?= $anchorClasses; ?> "
                id="<?= Inflector::camelize($this->field['name']); ?>_<?= $this->obj->id ?>"
                data-model="<?= $this->field['model']; ?>"
                data-field="<?= $this->field['name'] ?>"
                data-active-text="<?= $activeText ?>" data-inactive-text="<?= $inactiveText ?>" <?= $readOnly; ?>>
            <?= $label ?>
        </button>

    <?php }

    public function createDate() {
        echo empty($this->objectFieldValue) ? "NA" : date(DATE_PICKER, strtotime($this->objectFieldValue));
    }

    public function createDateTime() {
        echo empty($this->objectFieldValue) ? "NA" : date(SHORT_DATE, strtotime($this->objectFieldValue));
    }


    public function createText() {
        echo $this->objectFieldValue;
    }

    public function createActions($actions) {
        ?>
        <td class="actions">
            <?php
            foreach ($actions as $action => $actionParams) {

                if (in_array(strtolower($action), ['edit', 'view', 'delete'])) {
                    $this->{$action}($actionParams);
                } else {
                    if (is_array($actionParams)) {
                        $this->customAction($actionParams);
                    } else {
                        $this->{$actionParams}();
                    }
                }

            }
            ?>
        </td>
        <?php
    }

    public function customAction($action = []) {


        if (!empty($action['id'])) {
            $id = $action['id'] === true ? $this->obj->id : $this->obj->{$action['id']};
        } else {

            $id = $this->obj->id;
        }


        $action['url'][] = $id;
        $url = Router::url($action['url']);
        $classes = empty($action['class']) ? "btn-u btn-u-sea btn-u-sm rounded" : $action['class'];
        $target = empty($action['target']) ? "_self" : $action['target'];
        ?>
        <a href="<?= $url; ?>" class=" <?= $classes; ?>"
           style="float: left; margin-left: 10px;" target="<?= $target; ?>" data-id="<?= $id; ?>">
            <i class='<?= empty($action['icon']) ? "fa fa-circle-o" : $action['icon']; ?>'></i> <?= $action['label']; ?>
        </a>
        <?php
    }

    public function view() {
        $url = Router::url(['controller' => $this->controller, 'action' => 'view', $this->obj->id]);
        ?>
        <a href="<?= $url; ?>" class="btn-u btn-u-sea btn-u-sm rounded" style="float: left; margin-left: 10px;">
            <i class='hs-admin-eye'></i> Detail
        </a>
        <?php
    }

    public function edit() {
        $url = Router::url(['controller' => $this->controller, 'action' => 'edit', $this->obj->id]);
        ?>
        <a href="<?= $url; ?>" class="btn-u btn-u-blue btn-u-sm rounded" style="float: left; margin-left: 10px;">
            <i class='hs-admin-pencil'></i> Edit
        </a>
        <?php
    }

    public function delete($actionParams = null) {

        if (!empty($actionParams['id'])) {
            $id = $actionParams['id'] === true ? $this->obj->id : $this->obj->{$actionParams['id']};
        } else {
            $id = $this->obj->id;
        }

        if (empty($actionParams['url'])) {
            $url = ['controller' => $this->controller, 'action' => 'delete', $id];
        } else {
            $url = $actionParams['url'];
            $url[] = $id;
        }
        if (!empty($actionParams['deleteMessage'])) {
            $this->deleteMessage = $actionParams['deleteMessage'];
        }
        //$url = 'javascript:void(0);';
        ?>
        <?= $this->view->Form->create(null, ['url' => $url, 'id' => 'delete_' . $id . '_form']); ?>
        <button data-modal-target="#deleteConfirmModal"
                data-modal-effect="slide" class="btn-u btn-u-red btn-u-sm rounded delete-btn"
                style="float: left; margin-left: 10px;" id="delete_<?= $id; ?>_btn"><i
                    class="hs-admin-close"></i> Delete
        </button>
        <?= $this->view->Form->end(); ?>
        <?php
    }


    public function pagination() {
        if ($this->view->Paginator->hasPage()) {
            ?>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->view->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->view->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->view->Paginator->numbers() ?>
                    <?= $this->view->Paginator->next(__('next') . ' >') ?>
                    <?= $this->view->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->view->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
            <?php
        }
    }

    public function statusScript() {

        if ($this->includeStatusScript) {
            ?>
            <script>
                $(document).ready(function () {

                    $('.active-deactive').click(function () {
                        var _this = $(this);
                        var model = _this.attr('data-model');
                        var field = _this.attr('data-field');
                        var id = _this.attr('id').split('_')[1];

                        $.ajax({
                            url: SITE_URL + "admin/admins/changeStatus/",
                            type: "POST",
                            data: {model: model, field: field, id: id},
                            dataType: "json",
                            beforeSend: function () {
                                _this.html(_this.html() + ' <i class="fa fa-spinner fa-spin"></i>');
                            },
                            success: function (response) {
                                if (response.code == 200) {
                                    _this.removeClass('btn-u-orange');

                                    if (response.data.new_status) {
                                        _this.html(_this.attr('data-active-text'));
                                    } else {
                                        _this.addClass('btn-u-orange');
                                        _this.html(_this.attr('data-inactive-text'));
                                    }

                                    if (typeof statusCallback != "undefined") {
                                        statusCallback();
                                    }
                                } else {
                                    $().showFlashMessage("error", response.message);
                                }
                            }
                        });
                    });
                });
            </script>
            <?php
        }
    }

    public function setBulk($params) {
        $bulk = empty($params['bulk']) ? [] : $params['bulk'];
        $defaultBulk = [
            'actions' => [
                'active'   => 'Active',
                'inactive' => 'Inactive',
                'delete'   => 'Delete',
            ],
        ];

        $bulk += $defaultBulk;

        $this->bulk = $bulk;

    }

    public function setSearch($params) {


        $search = empty($params['search']) ? [] : $params['search'];
        $model = empty($search['model']) ? $this->controller : $search['model'];

        $match = [];
        if (empty($search['match'])) {
            $match = [$model . '.name'];
        } else {
            foreach ($search['match'] as $relatedModel => $m) {
                if (is_array($m)) {
                    foreach ($m as $f) {
                        $match[] = $relatedModel . '.' . $f;
                    }
                } else {
                    $match[] = $model . '.' . $m;
                }

            }
        }


        $finalSearch = [
            'controller'  => empty($search['controller']) ? $this->request->getParam('controller') : $search['controller'],
            'action'      => empty($search['action']) ? $this->request->getParam('action') : $search['action'],
            'model'       => $model,
            'match'       => $match,
            'placeholder' => empty($search['placeholder']) ? 'Search...' : $search['placeholder'],
            'url'         => empty($search['url']) ? [] : $search['url'],
        ];

        $this->search = $finalSearch;
    }


    public function createSearchAndBulkActions() {
        if ($this->hasPagination || true) {

            if (empty($this->search['url'])) {
                $url = Router::url(['controller' => empty($this->search['controller']) ? $this->controller : $this->search['controller'],
                                    'action'     => empty($this->search['action']) ? 'index' : $this->search['action']]);
            } else {
                $url = Router::url($this->search['url']);
            }

            ?>
            <div class="row g-mt-10">
                <div class="col-md-6">
                    <h3 class="h3 g-color-primary"><?= $this->heading; ?></h3>
                </div>
                <div class="col-md-6">
                    <?= $this->view->Form->create(null, ['id' => 'searchFrom', 'url' => $url]) ?>

                    <div class="row">
                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-8 text-right pr-0">
                            <div class="form-group">
                                <div class="g-pos-rel">
                      <span class="g-pos-abs g-top-0 g-right-0 d-block g-width-50 h-100">
	                    <i class="hs-admin-search g-absolute-centered g-font-size-16 g-color-gray-light-v6"></i>
	                  </span>
                                    <input id="listingSearchKey"
                                           name="key"
                                           class="form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus g-rounded-4 g-px-14 g-py-10"
                                           type="text" placeholder="<?= $this->search['placeholder']; ?>"
                                           value="<?= $this->view->get('search_key'); ?>"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 text-right pl-0">
                            <button type="submit" class="btn btn-primary btn-lg" id="searchInListing">Search</button>
                        </div>
                    </div>
                    <?= $this->view->Form->end(); ?>
                </div>
                <script>
                    $(function () {
                        $('#searchFrom').submit(function (e) {
                            e.preventDefault();
                            window.location.href = "<?= $url; ?>/?keyword=" + $('#listingSearchKey').val() + "&match=<?= implode(',', $this->search['match']); ?>";

                        });
                    });
                </script>
            </div>
            <?php
        }
    }

    public function phoneFormat($phone) {
        if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
            return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        }
        return $phone;
    }
}
