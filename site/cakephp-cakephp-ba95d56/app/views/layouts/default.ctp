<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('TROST'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
        echo $this->Javascript->link('jquery-1.5.1.min', true);

		echo $scripts_for_layout;

        $bo_started = $this->Session->read('BO.started') ? 1 : 0;
        echo $this->Javascript->codeBlock("
            $(document).ready(function() {
                if ($bo_started) {
                    $('#backoffice_menu').show();
                    $('#normal_menu').hide();
                    $('#backoffice_link').text('NormalMenu');
                }
                else {
                    $('#backoffice_menu').hide();
                    $('#normal_menu').show();
                }
                $('#backoffice_link').click(function() {
                    $('#backoffice_menu').slideToggle('fast');
                    $('#normal_menu').slideToggle('fast', function () {
                        if ($('#backoffice_menu').is(':visible')) {
                            $('#backoffice_link').text('NormalMenu');
                        }
                        else {
                            $('#backoffice_link').text('BackOffice');
                        }
                    });
                });
            });
            ");
	?>
</head>
<body>
	<div id="container">
		<div id="header">
        <?php echo $this->Html->link($this->Html->image('banner.jpg'), '/', array('escape' => false) ); ?>
            <span>
            <?php
            $person = $this->Session->read('Auth.Person');
            if ( ! empty($person)) {
                echo __('Welcome');
                echo '&nbsp;';
                echo $person['name'];
                echo '&nbsp;';
            }
            
            $default_url = $this->passedArgs;
            $de_url = $en_url = $default_url;
            $de_url['lang'] = 'de-de';
            $en_url['lang'] = 'en-us';
            echo $html->link('EN', $en_url);
            echo '|';
            echo $html->link('DE', $de_url);
            ?>
            <br />
            <?php if ( ! empty($person)): ?>
                <ul>
                <li><?php echo $this->Html->link(__('Change password', true), array('controller' => 'people', 'action' => 'edit', $person['id'])); ?></li>
                <li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'people', 'action' => 'logout')); ?></li>
                </ul>
            <?php else: ?>
                <?php echo $this->Html->link(__('Login', true), array('controller' => 'people', 'action' => 'login')); ?>
            <?php endif ?>
            </span>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('edit'); ?>

			<?php echo $content_for_layout; ?>
            <div class="actions">
                <h3><?php __('Menu'); ?></h3>
                <ul id="normal_menu">
                <li><?php echo $html->link(__('Home', true), '/'); ?></li>
                <li><?php echo $html->link(__('Upload scanner file', true), '/dis/abled'); ?></li>
                <li><?php echo $html->link(__('Upload file', true), '/ufiles/upload'); ?></li>
                <li><?php echo $html->link(__('Enter climate data', true), '/temps/erature'); ?></li>
                <li><hr style="margin: 20px;" /></li>
                <li><?php echo $html->link(__('List scanner files', true), '/raws/index'); ?></li>
                <li><?php echo $html->link(__('List files', true), '/ufiles/index'); ?></li>
                <li><?php echo $html->link(__('Search files', true), '/ufiles/search'); ?></li>
                <li><?php echo $html->link(__('List temperatures', true), '/temps/index'); ?></li>
                <?php if ($admin): ?>
                <li><hr style="margin: 20px;" /></li>
                </ul>
                <ul><li><?php echo $this->Ajax->link(__('BackOffice', true), '/bos/toggle', array('id' => 'backoffice_link')); ?></li></ul>
                <ul id="backoffice_menu"> 
                <li><?php echo $html->link(__('Home', true), '/'); ?></li>
                <li><?php echo $html->link(__('Upload entities file', true), '/entities/upload'); ?></li>
                <li><?php echo $html->link(__('Upload values file', true), '/values/upload'); ?></li>
                <li><?php echo $html->link(__('Upload BBCH file', true), '/bbches/upload'); ?></li>
                <li><?php echo $html->link(__('Add FAQ', true), '/faqs/add'); ?></li>
                <li><hr style="margin: 20px;" /></li>
                <li><?php echo $html->link(__('Download XML', true), '/phenotypes/download'); ?></li>
                <li><hr style="margin: 20px;" /></li>
                <li><?php echo $html->link(__('Duplicated temperatures', true), '/temps/duplicates'); ?></li>
                <li><hr style="margin: 20px;" /></li>
                <li><?php echo $html->link(__('Add user', true), '/people/add'); ?></li>
                <li><?php echo $html->link(__('List users', true), '/people/index'); ?></li>
                <?php endif; ?>
                </ul>
            </div>

		</div>
		<div id="footer">
            <?php
                $lang = Configure::read('Config.language');
            ?>
            <?php echo $html->link('imprint', 'http://mpimp.iwww.mpg.de/2278/impress'); ?>
            <?php 
            $url = 'http://www.mpg.de';
            if ($lang == 'en-us') {
                $url .= '/en';
            }
            echo $this->Html->link(
					$this->Html->image('minerva_logo.gif', array('alt'=> __('Max Planck Society', true), 'border' => '0')),
					$url,
					array('target' => '_blank', 'escape' => false)
				);
			?>
            <?php
            $url = 'http://www.mpimp-golm.mpg.de';
            if ($lang == 'en-us') {
                $url = 'http://www-en.mpimp-golm.mpg.de';
            }
            else {
                $url = 'http://www-de.mpimp-golm.mpg.de';
            }
            echo $this->Html->link(
					$this->Html->image('mpimp_logo_150x69.png', array('alt'=> __('Max Plank Institute for Molekular Plant Physiology', true), 'border' => '0')),
                    $url,
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
