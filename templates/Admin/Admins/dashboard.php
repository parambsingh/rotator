<?php $this->assign('title', __('Dashboard')) ?>
<?= $this->Html->script([
    'vendor/chartist-js/chartist.min.js',
    'vendor/chartist-js-tooltip/chartist-plugin-tooltip.js',
    'components/hs.area-chart',
    'components/hs.donut-chart',
    'components/hs.bar-chart',
    'components/hs.pie-chart.js',
]) ?>

<div class="g-bg-lightblue-v10-opacity-0_5 g-pa-20">
    <div class="row">
        <div class="col-sm-6 col-lg-6 col-xl-4 g-mb-0">
            <!-- Panel -->
            <div class="card h-100 g-brd-gray-light-v7 u-card-v1 g-rounded-3">
                <div class="card-block g-font-weight-300 g-pa-20">
                    <div class="media">
                        <div class="d-flex g-mr-15">
                            <div
                                class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-lightblue-v4 g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                <i class="fa fa-user-o g-absolute-centered"></i>
                            </div>
                        </div>
                        
                        <div class="media-body align-self-center">
                            <div class="d-flex align-items-center g-mb-5">
                                <span class="g-font-size-24 g-line-height-1 g-color-black"><?= $totalUsers ?></span>
                            </div>
                            
                            <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Distributors</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel -->
        </div>
        
        <div class="col-sm-6 col-lg-6 col-xl-4 g-mb-0">
            <!-- Panel -->
            <div class="card h-100 g-brd-gray-light-v7 u-card-v1 g-rounded-3">
                <div class="card-block g-font-weight-300 g-pa-20">
                    <div class="media">
                        <div class="d-flex g-mr-15">
                            <div
                                class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-orange g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                <i class="fa fa-users g-absolute-centered"></i>
                            </div>
                        </div>
                        
                        <div class="media-body align-self-center">
                            <div class="d-flex align-items-center g-mb-5">
                                <span
                                    class="g-font-size-24 g-line-height-1 g-color-black"><?= $totalLeads ?></span>
                            </div>
                            
                            <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Leads</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel -->
        </div>
        
        <div class="col-sm-6 col-lg-6 col-xl-4 g-mb-0">
            <!-- Panel -->
            <div class="card h-100 g-brd-gray-light-v7 u-card-v1 g-rounded-3">
                <div class="card-block g-font-weight-300 g-pa-20">
                    <div class="media">
                        <div class="d-flex g-mr-15">
                            <div
                                class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-indigo  g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                <i class="fa fa-refresh g-absolute-centered"></i>
                            </div>
                        </div>
                        
                        <div class="media-body align-self-center">
                            <div class="d-flex align-items-center g-mb-5">
                                <span
                                    class="g-font-size-24 g-line-height-1 g-color-black"><?= $totalRotatorLoops ?></span>
                            </div>
                            
                            <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Rotator Loops</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel -->
        </div>

        <div class="col-md-6 mt-4">
            <!-- Panel -->
            <div class="card h-100 g-brd-gray-light-v7 rounded">
                <div class="card-block g-font-weight-300 g-pa-20" style="height:600px;" id="map">
                </div>
            </div>
        </div>
        <!-- End Statistic Card -->
    </div>
</div>

