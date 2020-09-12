<?php $this->assign('title', __('Sign In')) ?>

<!-- Login -->
<section class="g-bg-gray-light-v5">
    <div class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-lg-5">
                <?= $this->element('outer_logo') ?>
                <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30">
                    <header class="text-center mb-4">
                        <h2 class="h3 g-color-gray-light-v2"><span class="h3 g-color-primary">Sign In</span></h2>
                        <?= $this->Flash->render() ?>
                    </header>

                    <!-- Form -->
                    <?= $this->Form->create(null,['class'=>'g-py-15']) ?>
                    <div class="mb-4">
                        <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email:</label>
                        <?= $this->Form->control('email', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Email', 'label' => false]) ?>
                    </div>

                    <div class="g-mb-5">
                        <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password:</label>
                        <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Password', 'label' => false]) ?>
                    </div>
                    <div class="row justify-content-between mt-1 mb-4">
                        <div class="col align-self-center">
                            <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-12 g-pl-25 mb-0">
                                <input type="checkbox" name="remember_me" value="1" class="js-select g-hidden-xs-up g-pos-abs g-top-0 g-left-0" id="remember-me">
                                <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                    <i class="fa" data-check-icon=""></i>
                                </div>
                                Stay signed in
                            </label>
                        </div>
                        <div class="col align-self-center text-right">
                            <a class="g-font-size-12" href="<?= SITE_URL; ?>forgot-password">Forgot password?</a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <?= $this->Form->button(__('Sign In'), ['class' => 'btn btn-md btn-block u-btn-primary rounded g-py-13']); ?>

                        <a href="<?= SITE_URL; ?>sign-up" style="width: 100%; text-align: center; float: left; margin-top: 8%;">Sign Up</a>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <div class="w-100 text-center my-4" style="border: 3px solid #333333"></div>
                <small class=" w-100 text-center d-block g-font-size-default g-mr-10 g-mb-10 g-mb-0--md"> Copyright &copy; <?= date('Y'); ?> <?= SITE_TITLE; ?>, All Rights Reserved.
                </small>

            </div>
        </div>
    </div>
</section>
