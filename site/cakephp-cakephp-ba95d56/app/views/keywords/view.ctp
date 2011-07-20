<div class="keywords view">
<h2><?php  __('Keyword');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $keyword['Keyword']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $keyword['Keyword']['name']; ?>
			&nbsp;
		</dd>
	</dl>
    <br />
    <div class="related">
        <h3><?php __('Related Ufiles');?></h3>
        <?php if (!empty($keyword['Ufile'])):?>
        <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php __('Id'); ?></th>
            <th><?php __('Submitter'); ?></th>
            <th><?php __('Name'); ?></th>
            <th><?php __('Created'); ?></th>
            <th><?php __('Description'); ?></th>
            <th class="actions"><?php __('Actions');?></th>
        </tr>
        <?php
            $i = 0;
            foreach ($keyword['Ufile'] as $ufile):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
            ?>
            <tr<?php echo $class;?>>
                <td><?php echo $ufile['id'];?></td>
                <td><?php echo $ufile['submitter'];?></td>
                <td><?php echo $ufile['name'];?></td>
                <td><?php echo $ufile['created'];?></td>
                <td><?php echo $ufile['description'];?></td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View', true), array('controller' => 'ufiles', 'action' => 'view', $ufile['id'])); ?>
                    <?php if ($this->Session->check('user')): ?>
                        <?php echo $this->Html->link(__('Edit', true), array('controller' => 'ufiles', 'action' => 'edit', $ufile['id'])); ?>
                        <?php echo $this->Html->link(__('Delete', true), array('controller' => 'ufiles', 'action' => 'delete', $ufile['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufile['id'])); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
