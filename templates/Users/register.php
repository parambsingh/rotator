<?php $this->assign('title', __('Login')) ?>

<!-- Login -->
<section class="g-bg-gray-light-v5">
    <div class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12">
                <div class="w-100 text-center mb-4">
                    <img src="<?= SITE_URL; ?>img/logo.png" height="70px"/>
                </div>
                <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30">
                    <header class="text-center mb-4">
                        <h2 class="h3 g-color-gray-light-v2"><span class="h3 g-color-primary">Sign Up</h2>
                        <?= $this->Flash->render() ?>
                    </header>

                    <?= $this->Form->create(null, ['class' => 'g-py-15']) ?>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Name:</label>
                            <?= $this->Form->control('name', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Name', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email:</label>
                            <?= $this->Form->control('email', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Email', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6  mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password:</label>
                            <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Password', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6  mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Confirm Password:</label>
                            <?= $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Confirm Password', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Address:</label>
                            <?= $this->Form->control('address', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Address', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">City:</label>
                            <?= $this->Form->control('city', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'City', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6  g-mb-35">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">State:</label>
                            <?= $this->Form->control('state', [ 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'State', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6  g-mb-35">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Zip:</label>
                            <?= $this->Form->control('zip', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Zip', 'label' => false]) ?>
                        </div>

                        <div class="col-md-5 mb-4">&nbsp;</div>
                        <div class="col-md-2 mb-4">
                            <?= $this->Form->button(__('Sign Up'), ['class' => 'btn btn-md btn-block u-btn-primary rounded g-py-13']); ?>

                            <a href="<?= SITE_URL; ?>sign-in"
                               style="width: 100%; text-align: center; float: left; margin-top: 8%;">Sign In</a>
                        </div>
                        <div class="col-md-5 mb-4">&nbsp;</div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>

                <div class="w-100 text-center my-4" style="border: 3px solid #333333"></div>
                <small class=" w-100 text-center d-block g-font-size-default g-mr-10 g-mb-10 g-mb-0--md"> Copyright
                    &copy; <?= date('Y'); ?> <?= SITE_TITLE; ?>, All Rights Reserved.
                </small>

            </div>
        </div>
    </div>
</section>
<!-- End Login -->
