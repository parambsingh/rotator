<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Image $image
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="images form content">
            <?= $this->Form->create($image) ?>
            <fieldset>
                <legend><?= __('Add Image') ?></legend>
                <?php
                    echo $this->Form->control('category');
                    echo $this->Form->control('image');
                    echo $this->Form->control('small_thumb');
                    echo $this->Form->control('medium_thumb');
                    echo $this->Form->control('large_thumb');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
