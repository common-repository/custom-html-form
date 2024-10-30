<?php
/**
 * Template Name: Contact Form
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

// New form instance
$form = new Chf_Model_Form;

// Add elements to it
$form
	// By default all fields are required
	// When you're using validators the Zend Framework library is required
	// @see http://h6e.net/wordpress/plugins/zend-framework
	->addElement(new Chf_Model_Element('chf_gender', array(
		'validators'    => new Zend_Validate_InArray(array('male','female'))
	)))
	->addElement(new Chf_Model_Element('chf_full_name'))
	->addElement(new Chf_Model_Element('chf_email', array(
		'validators'    => new Zend_Validate_EmailAddress()
	)))
	->addElement(new Chf_Model_Element('chf_birthday', array(
		'validators'    => new Zend_Validate_Date('dd-MM-yyyy'),
		'required'      => false
	)))
	->addElement(new Chf_Model_Element('chf_message'))
;

// When form posted validate it
if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST' && !empty($_POST['submit_chf'])) {
	if ($form->validate(stripslashes_deep($_POST))){
		$emailTo    = 'office@ceramedia.net';
		$subject    = 'Contact message from ironhide.nl';
		$body       = "Gender: " .          $form->getElement('chf_gender')->getValue() .       "\n";
		$body      .= "Full name: " .       $form->getElement('chf_full_name')->getValue() .    "\n";
		$body      .= "E-mail address: " .  $form->getElement('chf_email')->getValue() .        "\n";
		$body      .= "Birthday: " .        $form->getElement('chf_birthday')->getValue() .     "\n";
		$body      .= "Message:\n" .        $form->getElement('chf_message')->getValue();

		wp_mail( $emailTo, $subject, $body );
	}
}

// Associative error array
$errors = $form->getErrors();

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<form class="form-horizontal" action="<?php the_permalink() ?>" method="post">

					<?php if (false===$form->getValid()):?>
					<div class="alert alert-error">
						<strong>Oops!</strong>, please make sure that all fields are (correctly) filled in.
					</div>
					<?php elseif (true===$form->getValid()):?>
					<div class="alert alert-success">
						<strong>Success!</strong>, message has been sent.
					</div>
					<?php endif;?>

					<fieldset>
						<legend>Contact example</legend>
						<div class="control-group<?php if (!empty($errors['chf_gender'])):?> error<?php endif;?>">
							<label class="control-label" for="chf_gender">Gender *</label>
							<div class="controls">
								<select name="chf_gender" id="chf_gender" class="input-xlarge">
									<option value="male"<?php if($form->getElement('chf_gender')->getValue()=='male'):?> selected="selected"<?php endif;?>>Male</option>
									<option value="female"<?php if($form->getElement('chf_gender')->getValue()=='female'):?> selected="selected"<?php endif;?>>Female</option>
								</select>
							</div>
						</div>
						<div class="control-group<?php if (!empty($errors['chf_full_name'])):?> error<?php endif;?>">
							<label class="control-label" for="chf_full_name">Full name *</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="chf_full_name" name="chf_full_name" value="<?php echo esc_attr($form->getElement('chf_full_name')->getValue())?>" />
								<?php if (!empty($errors['chf_full_name'])):?><p class="help-inline">Please fill in your full name.</p><?php endif;?>
							</div>
						</div>
						<div class="control-group<?php if (!empty($errors['chf_email'])):?> error<?php endif;?>">
							<label class="control-label" for="chf_email">E-mail address *</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="chf_email" name="chf_email" value="<?php echo esc_attr($form->getElement('chf_email')->getValue())?>" />
								<?php if (!empty($errors['chf_email'])):?><p class="help-inline">Please fill in your e-mail address.</p><?php endif;?>
							</div>
						</div>
						<div class="control-group<?php if (!empty($errors['chf_birthday'])):?> error<?php endif;?>">
							<label class="control-label" for="chf_birthday">Birthday</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="chf_birthday" name="chf_birthday" placeholder="dd-mm-yyyy" value="<?php echo esc_attr($form->getElement('chf_birthday')->getValue())?>" />
								<?php if (!empty($errors['chf_birthday'])):?><p class="help-inline">Format: dd-mm-yyyy.</p><?php endif;?>
							</div>
						</div>
						<div class="control-group<?php if (!empty($errors['chf_message'])):?> error<?php endif;?>">
							<label class="control-label" for="chf_message">Message *</label>
							<div class="controls">
								<textarea class="input-xlarge" id="chf_message" name="chf_message" rows="4"><?php echo esc_textarea($form->getElement('chf_message')->getValue())?></textarea>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary" name="submit_chf" value="true">Send message</button>
							<button type="reset" class="btn">Cancel</button>
						</div>
					</fieldset>
				</form>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>