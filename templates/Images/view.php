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
            <?= $this->Html->link(__('Edit Image'), ['action' => 'edit', $image->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Image'), ['action' => 'delete', $image->id], ['confirm' => __('Are you sure you want to delete # {0}?', $image->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Image'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="images view content">
            <h3><?= h($image->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($image->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($image->image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Small Thumb') ?></th>
                    <td><?= h($image->small_thumb) ?></td>
                </tr>
                <tr>
                    <th><?= __('Medium Thumb') ?></th>
                    <td><?= h($image->medium_thumb) ?></td>
                </tr>
                <tr>
                    <th><?= __('Large Thumb') ?></th>
                    <td><?= h($image->large_thumb) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($image->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($image->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($image->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Admins') ?></h4>
                <?php if (!empty($image->admins)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Forgot Password Token') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($image->admins as $admins) : ?>
                        <tr>
                            <td><?= h($admins->id) ?></td>
                            <td><?= h($admins->name) ?></td>
                            <td><?= h($admins->email) ?></td>
                            <td><?= h($admins->password) ?></td>
                            <td><?= h($admins->forgot_password_token) ?></td>
                            <td><?= h($admins->image_id) ?></td>
                            <td><?= h($admins->created) ?></td>
                            <td><?= h($admins->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Admins', 'action' => 'view', $admins->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Admins', 'action' => 'edit', $admins->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Admins', 'action' => 'delete', $admins->id], ['confirm' => __('Are you sure you want to delete # {0}?', $admins->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Article Images') ?></h4>
                <?php if (!empty($image->article_images)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Article Id') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($image->article_images as $articleImages) : ?>
                        <tr>
                            <td><?= h($articleImages->id) ?></td>
                            <td><?= h($articleImages->article_id) ?></td>
                            <td><?= h($articleImages->image_id) ?></td>
                            <td><?= h($articleImages->created) ?></td>
                            <td><?= h($articleImages->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ArticleImages', 'action' => 'view', $articleImages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ArticleImages', 'action' => 'edit', $articleImages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ArticleImages', 'action' => 'delete', $articleImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleImages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Articles') ?></h4>
                <?php if (!empty($image->articles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Video Id') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Short Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($image->articles as $articles) : ?>
                        <tr>
                            <td><?= h($articles->id) ?></td>
                            <td><?= h($articles->title) ?></td>
                            <td><?= h($articles->slug) ?></td>
                            <td><?= h($articles->image_id) ?></td>
                            <td><?= h($articles->video_id) ?></td>
                            <td><?= h($articles->content) ?></td>
                            <td><?= h($articles->short_description) ?></td>
                            <td><?= h($articles->status) ?></td>
                            <td><?= h($articles->created) ?></td>
                            <td><?= h($articles->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Articles', 'action' => 'view', $articles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Articles', 'action' => 'edit', $articles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Pages') ?></h4>
                <?php if (!empty($image->pages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Video Id') ?></th>
                            <th><?= __('First Heading') ?></th>
                            <th><?= __('Second Heading') ?></th>
                            <th><?= __('Third Heading') ?></th>
                            <th><?= __('Forth Heading') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($image->pages as $pages) : ?>
                        <tr>
                            <td><?= h($pages->id) ?></td>
                            <td><?= h($pages->title) ?></td>
                            <td><?= h($pages->slug) ?></td>
                            <td><?= h($pages->image_id) ?></td>
                            <td><?= h($pages->video_id) ?></td>
                            <td><?= h($pages->first_heading) ?></td>
                            <td><?= h($pages->second_heading) ?></td>
                            <td><?= h($pages->third_heading) ?></td>
                            <td><?= h($pages->forth_heading) ?></td>
                            <td><?= h($pages->content) ?></td>
                            <td><?= h($pages->created) ?></td>
                            <td><?= h($pages->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Pages', 'action' => 'view', $pages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Pages', 'action' => 'edit', $pages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pages', 'action' => 'delete', $pages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($image->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Forgot Password Token') ?></th>
                            <th><?= __('Image Id') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Registration Steps Done') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($image->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->first_name) ?></td>
                            <td><?= h($users->last_name) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->forgot_password_token) ?></td>
                            <td><?= h($users->image_id) ?></td>
                            <td><?= h($users->phone) ?></td>
                            <td><?= h($users->address) ?></td>
                            <td><?= h($users->city) ?></td>
                            <td><?= h($users->state) ?></td>
                            <td><?= h($users->zip) ?></td>
                            <td><?= h($users->role) ?></td>
                            <td><?= h($users->registration_steps_done) ?></td>
                            <td><?= h($users->active) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
