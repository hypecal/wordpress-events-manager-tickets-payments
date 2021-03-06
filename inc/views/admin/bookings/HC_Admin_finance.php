<?php if ( !EM_ROBBY_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Admin_finance extends HC_Admin
{
	public static function section()
	{
		?><section class="em-menu-finance em-menu-group" style="display:none;">

			<div id="poststuff">
				<div id="main_finance_tabs">

					<!-- Billing Address -->
					<div class="postbox" id="em-ess-finance-billing-address">
						<h3><?php _e( 'Billing Address', 'em-robby' ); ?></h3>
						<div class="inside">
							<?php HC_Elements::get_explain_block(
								"This section defines the ticket seller billing address. ".
								"<br />".
								"This addess will appears on your invoices."
							);?>
							<?php self::get_billing_address_form( self::$billing ); ?>
						</div>
					</div>

					<!-- Bank Account -->
					<div class="postbox" id="em-ess-finance-bank-account">
						<h3><?php _e( 'Bank Account', 'em-robby' ); ?></h3>
						<div class="inside">

							<?php HC_Elements::get_explain_block(
								"Please enter your bank account information to receive the payouts for your sales.".
								"<br />".
								"Payout details must be specified before ROBBY can deliver your funds to you."
							);?>
							<?php self::get_bank_account_form( self::$bank ); ?>
						</div>
					</div>

					<!-- Taxpayer Information -->
					<div class="postbox" id="em-ess-finance-taxpayer">
						<h3><?php _e( 'Taxpayer Information', 'em-robby' ); ?></h3>
						<div class="inside" id="tabs-taxpayer">
							<?php HC_Elements::get_explain_block(
								"If you process over 200 orders and have not provided us with your taxpayer information, ROBBY is required to withhold on your payout until we receive this information.".
								"<br/>".
								"More info about taxpayer <a target='_blank' href='http://www.irs.gov/pub/irs-pdf/iw9.pdf'>here</a>.".
								"<br/>".
								"To avoid service interruptions, please fill out your taxpayer information now. "
							);?>
							<?php self::get_taxpayer_form( self::$taxpayer ); ?>
						</div>
					</div>

					<!-- Payouts -->
					<div class="postbox" id="em-ess-finance-payouts">
						<h3><?php _e( 'Payouts', 'em-robby' ); ?></h3>
						<div class="inside">
							<?php HC_Elements::get_explain_block(
								"Payouts are initiated 7 days after your event's end. It can take a few days to reach you.".
								"<br />" .
								"More information about the <a class='info_popup' data-popup='payouts'>Payouts FAQ</a>"
							 );?>
							<?php self::get_payouts_list();?>
						</div>
					</div>

					<!-- Invoices -->
					<div class="postbox" id="em-ess-finance-invoices">
						<h3><?php _e( 'Invoices', 'em-robby' ); ?></h3>
						<div class="inside">
							<?php HC_Elements::get_explain_block(
								"Invoices are created for each ticket sold; The payouts are sent 7 business days after your event's end and combine all your sales in one bank transfer.".
								"<br />" .
								"More information about the <a class='info_popup' data-popup='tickets_invoices'>Tickets Fee FAQ</a>"
							 );?>
							<?php self::get_invoices_list();?>
						</div>
					</div>

				</div>
			</div>

		</section><?php
	}

	private static function get_W9( $taxpayer = NULL )
	{
		$FORM = HC_Constants::TYPE_ENTITY_FORM_W9;
		$TAXPAYER_ = (isset($_REQUEST[ "taxpayer" ][ $FORM ])? $_REQUEST[ "taxpayer" ][ $FORM ] : array());

		?><fieldset class="line">
			<label class="fieldn">
				<b style="font-size:23px;"><?php _e( 'Form W-9', 'em-robby' );?></b>
				<img src="<?php echo EM_ROBBY_DIR_URI . "assets/img/info_icon_30x30.png";?>" width="14" height="14" class="info_popup tooltip" data-popup="w9" title="<?php _e( "Click to read the W-9 FAQ", 'em-robby' );?>"/>
			</label>
		</fieldset>
		<h2><?php _e( 'Identification of Beneficial Owner', 'em-robby' );?></h2>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn">
					<?php _e( 'Full Name', 'em-robby' )?><br/>
					<span class="fieldn xp"><br/><?php _e( 'As shown on your income tax return', 'em-robby' );?></span>
				</label>
				<input id="id_full_name" maxlength="128" name="taxpayer[<?php echo $FORM;?>][full_name]" type="text" placeholder="<?php _e( 'Full name', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->full_name : '') ) > 0 )? (isset($taxpayer)? $taxpayer->full_name : '') : $TAXPAYER_['full_name' ] ); ?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer full name is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn ">
					<?php _e( 'Business ', 'em-robby' );?><br/>
					<span class="xp"><?php _e( 'If different from above', 'em-robby' );?></span>
				</label>
				<input id="id_business_name" maxlength="128" name="taxpayer[<?php echo $FORM;?>][business_name]" type="text" placeholder="<?php _e( 'Business name', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->business_name : '') ) > 0 )? (isset($taxpayer)? $taxpayer->business_name : '') : $TAXPAYER_[ 'business_name' ] );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn"><?php _e( 'Country', 'em-robby' )?></label>
				<select name="taxpayer[<?php echo $FORM; ?>][country_code]" style="width:406px;">
					<option value="0" <?php echo ( (isset($taxpayer)? $taxpayer->country_code : '') == '' ) ? 'selected="selected"':''; ?>><?php _e('none selected','em-robby'); ?></option>
					<?php foreach( em_get_countries() as $country_key => $country_name): ?>
					<option value="<?php echo $country_key; ?>" <?php echo ( ( strtoupper( (isset($taxpayer)? $taxpayer->country_code : '') ) == strtoupper( $country_key ) )? 'selected="selected"' : '' ); ?>><?php echo $country_name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn"><?php _e( 'Address', 'em-robby' );?></label>
				<input id="id_address_street" maxlength="255" name="taxpayer[<?php echo $FORM;?>][address]" type="text" placeholder="<?php _e( 'Address', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->address : '') ) > 0 )? (isset($taxpayer)? $taxpayer->address : '') : $TAXPAYER_['address']);?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer address is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn"><?php _e( 'City', 'em-robby' );?></label>
				<input id="id_address_city" maxlength="128" name="taxpayer[<?php echo $FORM;?>][city]" type="text" placeholder="<?php _e( 'City', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->city : '') ) > 0 )? (isset($taxpayer)? $taxpayer->city : '') : @$TAXPAYER_['city']);?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer city is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn"><?php _e( 'State', 'em-robby' );?></label>
				<div class="field_c">
					<?php HC_Menus::get_states_us('', "taxpayer[".$FORM."][state]", ( ( strlen( (isset($taxpayer)? @$taxpayer->state : '') ) > 0 )? (isset($taxpayer)? @$taxpayer->state : '') : (isset($TAXPAYER_[ 'state' ])? $TAXPAYER_[ 'state' ] : '') ), "width:406px;" ); ?>

				</div>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn"><?php _e( 'ZIP', 'em-robby' )?></label>
				<input id="id_address_postal_code" maxlength="10" name="taxpayer[<?php echo $FORM;?>][zip]" type="text" placeholder="<?php _e( 'ZIP', 'em-robby' )?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->zip : '') ) > 0 )? (isset($taxpayer)? $taxpayer->zip : '') : @$TAXPAYER_['zip' ] ); ?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer ZIP code or post code is required', 'em-robby' )?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn"><?php _e( 'Federal Tax Identity Type', 'em-robby' );?></label>
				<div class="field_c">
					<?php HC_Menus::get_tax_entities( '', "taxpayer[".$FORM."][entity_type]", $FORM, ( ( strlen( (isset($taxpayer)? $taxpayer->entity_type : '') ) > 0 )? (isset($taxpayer)? $taxpayer->entity_type : '') : @$TAXPAYER_['entity_type']) ); ?>
				</div>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn">
					<?php _e( 'TIN', 'em-robby' );?> <br/>
					<span class="fieldn xp"><?php _e( 'Taxpayer Identification Number', 'em-robby' );?></span>
				</label>
				<div class="field_c">
					<?php HC_Menus::get_taxid_type( '', "taxpayer[".$FORM."][taxid_type]", ( ( strlen( @$taxpayer->taxid_type ) > 0 )? $taxpayer->taxid_type : @$TAXPAYER_['taxid_type']), "taxid-type" );?>

				</div>
				<div class="ein_ssn_input">
					<input type="text" class="taxid" name="taxpayer[<?php echo $FORM;?>][taxid]" autocomplete="off" placeholder="XX-XXXXXXX" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->taxid : '') ) > 0 )? (isset($taxpayer)? $taxpayer->taxid : '') : @$TAXPAYER_['taxid'] ); ?>"/>
				</div>
				<div class="extra_label">
					<?php _e( 'Enter your TIN in the appropriate box.', 'em-robby' );?><br/>
					<?php _e( 'The TIN provided must match the name given in the previous section. For individuals, this is your social security number (SSN).', 'em-robby' );?><br/>
					<?php _e( 'For other entities, it is your employer identification number (EIN).', 'em-robby' );?>
				</div>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper" style="width:100%;">
				<label class="fieldn">
					<?php _e( 'Your signature', 'em-robby' );?><br/>
					<span class="xp"><?php _e( 'Typing your name acts as your signature', 'em-robby' );?></span>
				</label>
				<div class="field_c required">
					<input name="taxpayer[<?php echo $FORM;?>][signature]" maxlength="128" name="signature" type="text" placeholder="<?php _e( 'Signature', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->signature : '') ) > 0 )? (isset($taxpayer)? $taxpayer->signature : '') : @$TAXPAYER_[ 'signature' ] ); ?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer signature is required', 'em-robby' )?>"/>
				</div>
				<div class="extra_label">
					<?php _e( 'By clicking "Save", I certify under penalties of perjury that the number shown on this form is the correct taxpayer identification number.', 'em-robby' );?>
					<br/>
					<b><?php _e( 'Note', 'em-robby' )?></b>: <?php _e( 'The date, time of submission and your computer’s IP address ('. @$_SERVER['REMOTE_ADDR'].') will be recorded upon submission.', 'em-robby' );?>
				</div>
			</div>
		</div><?php
	}

	private static function get_W8BEN( $taxpayer = NULL )
	{
		$FORM = HC_Constants::TYPE_ENTITY_FORM_W8BEN;
		$TAXPAYER_ = (isset($_REQUEST[ "taxpayer" ][ $FORM ])? $_REQUEST[ "taxpayer" ][ $FORM ] : array());
		//d( $TAXPAYER_ );

		?><fieldset class="line">
			<label class="fieldn">
				<b style="font-size:23px;"><?php _e( 'Form W8-BEN', 'em-robby' );?></b>
				<img src="<?php echo EM_ROBBY_DIR_URI . "assets/img/info_icon_30x30.png";?>" width="14" height="14" class="info_popup tooltip" data-popup="w8ben" title="<?php _e( "Click to read the W8-BEN FAQ", 'em-robby' );?>"/>
			</label>
		</fieldset>
		<h2><?php _e( 'Identification of Beneficial Owner', 'em-robby' );?></h2>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn">
					<?php _e( 'Individual/Organization Name', 'em-robby' );?><br/>
					<span class="fieldn xp"><?php _e( 'Name that is the beneficial owner', 'em-robby' );?></span>
				</label>
				<input maxlength="128" name="taxpayer[<?php echo $FORM;?>][full_name]" type="text" placeholder="<?php _e( 'Full name', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->full_name : '') ) > 0 )? (isset($taxpayer)? $taxpayer->full_name : '') : @$TAXPAYER_['full_name']);?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer name or organization name is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn">
					<?php _e( 'Country of Incorporation', 'em-robby' );?><br/>
					<span class="fieldn xp"><?php _e( 'Or residence if individual', 'em-robby' );?></span>
				</label>
				<select name="taxpayer[<?php echo $FORM;?>][country_code]" style="width:406px;">
					<option value="0" <?php echo ( (isset($taxpayer)? $taxpayer->country_code : '') == '' ) ? 'selected="selected"':''; ?>><?php _e('none selected','em-robby'); ?></option>
					<?php foreach( em_get_countries() as $country_key => $country_name): ?>
					<option value="<?php echo $country_key; ?>" <?php echo ( ( strtoupper( (isset($taxpayer)? $taxpayer->country_code : '') ) == strtoupper( $country_key ) )? 'selected="selected"' : '' ); ?>><?php echo $country_name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn"><?php _e( 'Type of Entity', 'em-robby' );?></label>
				<?php HC_Menus::get_tax_entities( '', "taxpayer[".$FORM."][entity_type]", $FORM, ( ( strlen( (isset($taxpayer)? $taxpayer->entity_type : '') ) > 0 )? (isset($taxpayer)? $taxpayer->entity_type : '') : @$TAXPAYER_[ 'entity_type' ] ) ); ?>
			</div>
		</div>
		<h2><?php _e( 'Permanent Residence Address', 'em-robby' );?></h2>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn">
					<?php _e( 'Address', 'em-robby' );?><br/>
					<span class="fieldn xp"><?php _e( 'Do not use a P.O. box or in-care-of address', 'em-robby' );?></span>
				</label>
				<input id="id_address_street" maxlength="255" name="taxpayer[<?php echo $FORM;?>][address]" type="text" placeholder="<?php _e( 'Address', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->address : '') ) > 0 )? (isset($taxpayer)? $taxpayer->address : '') : @$TAXPAYER_['address']);?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer address is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper required">
				<label class="fieldn"><?php _e( 'City', 'em-robby' );?></label>
				<input id="id_address_city" maxlength="128" name="taxpayer[<?php echo $FORM;?>][city]" type="text" placeholder="<?php _e( 'City', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->city : '') ) > 0 )? (isset($taxpayer)? $taxpayer->city : '') : @$TAXPAYER_[ 'city' ] ); ?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer city is required', 'em-robby' );?>"/>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn">
					<?php _e( 'Postal Code', 'em-robby' );?><br/>
					<span class="fieldn xp"><?php _e( 'Where appropriate', 'em-robby' );?></span>
				</label>
				<input maxlength="10" name="taxpayer[<?php echo $FORM;?>][zip]" type="text" placeholder="<?php _e( 'ZIP', 'em-robby' )?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->zip : '') ) > 0 )? (isset($taxpayer)? $taxpayer->zip : '') : @$TAXPAYER_[ 'zip' ] ); ?>"/>
			</div>
		</div>
		<h2><?php _e( 'Taxpayer Identification Number', 'em-robby' );?></h2>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn">
					<?php _e( 'TIN', 'em-robby' )?><br/>
					<span class="fieldn xp"><?php _e( 'Taxpayer Identification Number', 'em-robby' );?></span>
				</label>
				<div class="field_c">
					<?php HC_Menus::get_taxid_type( '', "taxpayer[".$FORM."][taxid_type]", ( ( strlen( (isset($taxpayer)? $taxpayer->taxid_type : '') ) > 0 )? (isset($taxpayer)? $taxpayer->taxid_type : '') : @$TAXPAYER_[ 'taxid_type' ] ), "taxid-type" );?>

				</div>
				<div class="ein_ssn_input">
					<input type="text" class="taxid" name="taxpayer[<?php echo $FORM;?>][taxid]" autocomplete="off" placeholder="XXXXXXX" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->taxid : '') ) > 0 )? (isset($taxpayer)? $taxpayer->taxid : '') : @$TAXPAYER_[ 'taxid' ] ); ?>"/>
				</div>
				<div class="extra_label">
					<?php _e( 'Enter your TIN in the appropriate box.', 'em-robby' );?><br/>
					<?php _e( 'The TIN provided must match the name given in the previous section.', 'em-robby' );?><br/>
					<?php _e( 'For individuals, this is your social security number (SSN).', 'em-robby' );?><br/>
					<?php _e( 'For other entities, it is your employer identification number (EIN).', 'em-robby' );?>
				</div>
			</div>
		</div>

		<h2><?php _e( 'Certification', 'em-robby' );?></h2>

		<div class="xp">
			<?php _e( 'Under penalties of perjury, I declare that the payee providing this certification is not a United States person
			(i.e., a citizen or resident of the United States as determined for U.S.
			federal tax purposes, a corporation or partnership created or organized in the United States or under the law of
			the United States or of any State, any estate that would be subject to U.S.
			federal income tax on income from sources without the United States which is not effectively connected with the conduct
			of a trade or business within the United States, or any trust if a court within the United States is able to exercise
			primary supervision over the administration of the trust and one or more United States persons have the authority to
			control all substantial decisions of the trust), that the income to which this certification relates is not effectively
			connected with the conduct of a trade or business in the United States, and that the undersigned has examined the information
			on this form and to the best of my knowledge and belief it is true, correct, and complete. Furthermore,
			I authorize this form to be provided to any person that has control, receipt, or custody of the payment to which
			I am entitled or any person that can disburse or make the payments to which I am entitled.', 'em-robby' ); ?>
		</div>
		<div class="line">
			<div class="field-wrapper" style="width:100%;">
				<label class="fieldn">
					<?php _e( 'Signature of beneficial owner', 'em-robby' );?><br/>
					<span class="fieldn xp"><?php _e( 'Or authorized to sign for beneficial owner', 'em-robby' );?></span>
				</label>
				<div class="field_c required">
					<input maxlength="128" name="taxpayer[<?php echo $FORM;?>][signature]" type="text" placeholder="<?php _e( 'Signature', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->signature : '') ) > 0 )? (isset($taxpayer)? $taxpayer->signature : '') : @$TAXPAYER_['signature']);?>" data-validation-optional="true" data-validation="required" data-validation-error-msg="<?php _e( 'The taxpayer signature is required', 'em-robby' );?>"/>
				</div>
			</div>
		</div>
		<div class="line">
			<div class="field-wrapper">
				<label class="fieldn"><?php _e( 'Capacity in which acting', 'em-robby' );?></label>
				<input maxlength="128" name="taxpayer[<?php echo $FORM;?>][signature_capacity]" type="text" placeholder="<?php _e( 'Title', 'em-robby' );?>" value="<?php echo ( ( strlen( (isset($taxpayer)? $taxpayer->signature_capacity : '') ) > 0 )? (isset($taxpayer)? $taxpayer->signature_capacity : '') : (isset($TAXPAYER_['signature_capacity'])? $TAXPAYER_['signature_capacity'] : '') );?>"/>
				<div class="extra_label">
					<b><?php _e( 'Note', 'em-robby' )?></b>: <?php _e( 'The date, time of submission and your computer’s IP address ('. @$_SERVER['REMOTE_ADDR'] .') will be recorded upon submission.', 'em-robby' )?>
				</div>
			</div>
		</div><?php
	}

	private static function get_billing_address_form( $billing = NULL )
	{
		?><form method="post" enctype='multipart/form-data' class="form" target="_self">
			<table class="form-table">
				<tbody>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required" style="width:210px;"><strong><?php _e ( 'First Name / Last Name:', 'em-robby' );?></strong></td>
						<td>
							<div class="field_c">
								<input placeholder="<?php _e( 'First Name', 'em-robby' );?>" type="text" name="billing_account[first_name]" value="<?php echo (isset($billing)? $billing->first_name : ''); ?>" style="width:200px;" data-validation="required" data-validation-error-msg="<?php _e( 'The first name is required', 'em-robby' );?>"/>
							</div>
							<div class="field_c">
								<input placeholder="<?php _e( 'Last Name', 'em-robby' );?>" type="text" name="billing_account[last_name]" value="<?php echo (isset($billing)? $billing->last_name : ''); ?>" style="width:200px;" data-validation="required" data-validation-error-msg="<?php _e( 'The last name is required', 'em-robby' );?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td><strong><?php _e( 'Company / Organisation', 'em-robby'); ?></strong></td>
						<td>
							<div class="field_c">
								<input type="text" name="billing_account[company]" value="<?php echo (isset($billing)? $billing->company : ''); ?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e( 'Address', 'em-robby'); ?></strong></td>
						<td>
							<div class="field_c">
								<input type="text" name="billing_account[address]" value="<?php echo (isset($billing)? $billing->address : ''); ?>" data-validation="required" data-validation-error-msg="<?php _e( 'The address is required', 'em-robby' );?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e ( 'City / State / Postcode:', 'em-robby' );?></strong></td>
						<td>
							<div class="field_c">
								<input placeholder="<?php _e( 'City', 'em-robby' );?>" type="text" name="billing_account[city]" value="<?php echo (isset($billing)? $billing->city : ''); ?>" style="width:150px;" data-validation="required" data-validation-error-msg="<?php _e( 'The city is required', 'em-robby' );?>"/>
							</div>
							<input placeholder="<?php _e( 'State', 'em-robby' );?>" type="text" name="billing_account[state]" value="<?php echo (isset($billing)? $billing->state : ''); ?>" style="width:43%;max-width:150px;"/>
							<input placeholder="<?php _e( 'ZIP', 'em-robby' );?>" type="text" name="billing_account[zip]" value="<?php echo (isset($billing)? $billing->zip : ''); ?>" style="width:11%;max-width:95px;"/>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e ( 'Country:', 'em-robby' )?></strong></td>
						<td>
							<div class="field_c">
								<select name="billing_account[country_code]" style="width:406px;">
									<option value="0" <?php echo ( @$billing->country_code == '' ) ? 'selected="selected"':''; ?>><?php _e('none selected','em-robby'); ?></option>
									<?php foreach( em_get_countries() as $country_key => $country_name): ?>
									<option value="<?php echo $country_key; ?>" <?php echo ( ( strtoupper( (isset($billing)? $billing->country_code : '') ) == strtoupper( $country_key ) ) ) ? 'selected="selected"':''; ?>><?php echo $country_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td><strong><?php _e( 'Phone', 'em-robby'); ?></strong></td>
						<td>
							<input type="text" placeholder="<?php _e( '+001','em-robby');?>" name="billing_account[phone]" value="<?php echo (isset($billing)? $billing->phone : ''); ?>"/>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" name="save_finance[billing_account]" value="<?php _e( 'Save Changes', 'em-robby' );?>" />
			</p>

		</form><?php
	}

	private static function get_bank_account_form( $bank = NULL )
	{
		?><form method="post" class="form" enctype='multipart/form-data' target="_self">

			<table class="form-table">
				<tbody>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required" style="width:240px;">
							<strong><?php _e( 'Do you agree with the', 'em-robby' ); ?></strong>
							<br/>
							<a href="#" class="info_popup" data-popup="seller_agreement"><?php _e('seller aggreement', 'em-robby'); ?></a>
						</td>
						<td>
							<?php HC_Elements::button_checkbox( array( 'id' => 'bank_aggreement', 'name' => 'bank_account[aggreement]', 'checked' => ( (isset($bank)? $bank->aggreement : '') == HC_Constants::AGGREEMENT_YES )? TRUE : FALSE, 'on'=>'YES', 'off'=>'NO' ) );?>
							<em><?php _e( 'Relation between the ticket seller and ROBBY.', 'em-robby'); ?></em>
						</td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e( 'Country / Currency', 'em-robby' ); ?></strong></td>
						<td>
							<div class="field_c">
								<select name="bank_account[country_code]" style="width:183px;">
									<option value="0" <?php echo ( (isset($bank)? $bank->country_code : '') == '' ) ? 'selected="selected"':''; ?>><?php _e('none selected','em-robby'); ?></option>
									<?php foreach( em_get_countries() as $country_key => $country_name): ?>
									<option value="<?php echo $country_key; ?>" <?php echo ( ( (isset($bank)? $bank->country_code : '') == $country_key) ) ? 'selected="selected"':''; ?>><?php echo $country_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="field_c">
								<?php HC_Menus::get_currencies_actives( "bank-currency", "bank_account[currency]", ( ( strlen( (isset($bank)? $bank->currency : '') ) == 3 )? (isset($bank)? $bank->currency : '') : HC_Constants::DEFAULT_CURRENCY ) );?>

							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td><em style="line-height:22px;"><?php _e('Residency of your bank. The deposit will be made with this currency', 'em-robby'); ?></em></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required">
							<strong><?php _e( 'Bank account owner', 'em-robby' ); ?></strong>
							<?php HC_Elements::get_info( "If you do not enter your full legal name as it appears on the bank statement, your payment might be delayed.<br/>In order to make sure we are sending money to the right person, we take appropriate measures to validate you are the rightful owner of the account" );?>
						</td>
						<td>
							<div class="field_c">
								<input maxlength="64" type="text" name="bank_account[owner_name]" value="<?php echo ( ( strlen( (isset($bank)? $bank->owner_name : '') ) > 0 )? (isset($bank)? $bank->owner_name : '') : '' ); ?>" placeholder="<?php _e( 'Owner name', 'em-robby' ); ?>" data-validation="required" data-validation-error-msg="<?php _e( 'The bank account owner name is required', 'em-robby' ); ?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td><em style="line-height:22px;"><?php _e( 'The complete name of the account owner', 'em-robby' ); ?></em></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e( 'Bank name', 'em-robby' ); ?></strong></td>
						<td>
							<div class="field_c">
								<input maxlength="64" type="text" name="bank_account[bank_name]" value="<?php echo ( ( strlen( (isset($bank)? $bank->bank_name : '') ) > 0 )? (isset($bank)? $bank->bank_name : '') : '' );?>" placeholder="<?php _e( 'City Bank, HSBC..', 'em-robby' ); ?>" data-validation="required" data-validation-error-msg="<?php _e( 'The bank name is required', 'em-robby' ); ?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td><em style="line-height:22px;"><?php _e( 'The commercial name of you bank', 'em-robby' ); ?></em></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e( 'Bank account type and number', 'em-robby' ); ?></strong></td>
						<td>
							<div class="field_c">
								<?php HC_Menus::get_bank_accounts_types( 'bank-type', "bank_account[type]", ( ( strlen( (isset($bank)? @$bank->bank_type : '') ) > 0 )? (isset($bank)? @$bank->bank_type : 0 ) : 0 ) ); ?>

							</div>
							<div class="field_c">
								<input maxlength="64" style="width:302px;" type="text" name="bank_account[iban]" value="<?php echo ( ( strlen( (isset($bank)? $bank->iban : '') ) > 0 )? (isset($bank)? $bank->iban : '') : '' );?>" placeholder="xxxx-xx-xxxx-xxxxxxxxxxxx" data-validation="required" data-validation-error-msg="<?php _e( 'The bank account number is required', 'em-robby' ); ?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td><em style="line-height:22px;"><?php _e( 'Number to deposit the money into (IBAN)', 'em-robby' ); ?></em></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td class="required"><strong><?php _e( 'Bank routing number', 'em-robby' ); ?></strong></td>
						<td>
							<div class="field_c">
								<input maxlength="64" type="text" name="bank_account[swift]" value="<?php echo ( ( strlen( (isset($bank)? $bank->swift : '') ) > 0 )? (isset($bank)? $bank->swift : '') : '' ); ?>" placeholder="xxxxxxxx" data-validation="required" data-validation-error-msg="<?php _e( 'The bank account BIC or SWIFT number is required', 'em-robby' ); ?>"/>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td><em style="line-height:22px;"><?php _e( 'Routing number of your bank (SWIFT/BIC)', 'em-robby' ); ?></em></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td><strong>&nbsp;</strong></td>
						<td>
							<img src="<?php echo EM_ROBBY_DIR_URI; ?>assets/img/ach_chk.png"/>
						</td>
					</tr>

				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" name="save_finance[bank_account]" value="<?php _e( 'Save Changes', 'em-robby' );?>" />
			</p>

		</form><?php
	}

	private static function get_taxpayer_form( $taxpayer )
	{
		//d( $taxpayer );

		?><form method="post" class="form" enctype='multipart/form-data' target="_self">
			<input type="hidden" name="taxpayer[id]" value="<?php echo (isset($taxpayer)? $taxpayer->id : ''); ?>"/>
			<table class="form-table" colspan="0" cellspan="0">
				<tbody>
					<tr>
						<td width="20">&nbsp;</td>
						<td style="width:195px;">
							<strong><?php _e( 'Taxes Applicable?', 'em-robby' ); ?></strong>
							<?php HC_Elements::get_info( "Some events organizer need to charge on tax their tickets, please check with your accountant about your own situation." );?>
						</td>
						<td>
							<?php HC_Elements::button_checkbox( array( 'id' => 'taxpayer_applicable', 'name' => 'taxpayer[applicable]', 'checked' => ( (isset($taxpayer)? $taxpayer->applicable : '') == 'y' )? TRUE : FALSE, 'on'=>'YES', 'off'=>'NO' ) );?>
							<em><?php _e( 'Do you have to pay taxes for tickets sold.', 'em-robby' ); ?></em>
						</td>
					</tr>
				</tbody>
			</table>

			<div id="taxpayer_main_block" <?php echo ( ( (isset($taxpayer)? $taxpayer->applicable : '') == 'n' || strlen( (isset($taxpayer)? $taxpayer->applicable : '') ) <= 0 )? 'style="display:none;"' : '' ); ?>>
				<table class="form-table" colspan="0" cellspan="0">
					<tbody>
						<tr>
							<td><strong><?php _e( 'Type of Taxpayer', 'em-robby' ); ?></strong></td>
							<td>
								<?php HC_Elements::button_checkbox( array( 'id' => 'taxpayer_taxpayer_type', 'name' => 'taxpayer[taxpayer_type]', 'checked' => ( (isset($taxpayer)? $taxpayer->taxpayer_type : '') == HC_Constants::TYPE_TAXPAYER_BUSINESS )? TRUE : FALSE, 'on'=>'BIZ', 'off'=>'IND' ) );?>
								<em><?php _e( '"Business" or "Individual".', 'em-robby' ); ?></em>
							</td>
						</tr>
						<tr>
							<td class="required" style="width:200px;"><strong><?php _e('Currency', 'em-robby'); ?></strong></td>
							<td>
								<div class="field_c">
									<?php HC_Menus::get_currencies_actives( "", "taxpayer[currency]", ( ( strlen( (isset($taxpayer)? $taxpayer->currency : '') ) == 3 )? (isset($taxpayer)? $taxpayer->currency : '') : HC_Constants::DEFAULT_CURRENCY ) );?>

								</div>
								<br/>
								<em><?php _e('Used by your bank account.', 'em-robby'); ?></em>
							</td>
						</tr>
						<tr>
							<td class="required"><strong><?php _e('Tax Rate %', 'em-robby'); ?></strong></td>
							<td>
								<input maxlength="5" style="width:60px;min-width:60px;" type="text" id="taxpayer-tax-rate" name="taxpayer[rate]" class="number_only" value="<?php echo ( ( floatval( (isset($taxpayer)? $taxpayer->rate : '') ) > 0 )? (isset($taxpayer)? $taxpayer->rate : '') : '' ); ?>" placeholder="0.00"/>
								<span style="text-align:left;min-width:10px;"> %</span>
								<br/>
								<em style="line-height:20px;">
									<?php _e('The entire amount of your sales will be transfered to your bank 7 days after the end of your events.', 'em-robby'); ?>
									<br/>
									<?php _e('The Tax Rate will be displayed on each tickets and invoices for legals purpose.', 'em-robby'); ?>
								</em>
							</td>
						</tr>
						<tr>
							<td><strong><?php _e( 'Are you a U.S. Citizen?', 'em-robby' ); ?></strong></td>
							<td>
								<?php HC_Elements::button_checkbox( array( 'id' => 'taxpayer_entity_form', 'name' => 'taxpayer[entity_form]', 'checked' => ( (isset($taxpayer)? $taxpayer->entity_form : '') == HC_Constants::TYPE_ENTITY_FORM_W9 )? TRUE : FALSE, 'on'=>'YES', 'off'=>'NO' ) );?>
								<em><?php _e( 'For tax purposes. IRS Form W9 or W8-BEN.', 'em-robby' ); ?></em>
							</td>
						</tr>
					</tbody>
				</table>
				<br/><br/>
				<fieldset id="W9-form-block" class="fieldset_form" <?php echo ( 	( (isset($taxpayer)? $taxpayer->entity_form : '') == HC_Constants::TYPE_ENTITY_FORM_W9 											                       )? '' : "style='display:none;'" );?>><?php self::get_W9(    $taxpayer ); ?></fieldset>
				<fieldset id="W8BEN-form-block" class="fieldset_form" <?php echo ( 	( (isset($taxpayer)? $taxpayer->entity_form : '') == HC_Constants::TYPE_ENTITY_FORM_W8BEN || isNull( (isset($taxpayer)? $taxpayer->entity_form : '') ) )? '' : "style='display:none;'" );?>><?php self::get_W8BEN( $taxpayer ); ?></fieldset>
			</div>
			<p class="submit">
				<input type="submit" class="button-primary" name="save_finance[taxpayer]" value="<?php _e( 'Save Changes', 'em-robby' );?>" />
			</p>
		</form><?php
	}

	private static function get_payouts_list()
	{
		?><form method="post" enctype='multipart/form-data' target="_self" onsubmit="hc.loader(true);">
			<section class="nav_btns" style="display:none;">
				<span class='bt_tableTools'></span>
			</section>
			<table id="payouts_grid" class="display widefat" cellpadding="0" cellspacing="0" width="100%" style="display:none;"></table>
		</form><?php
	}

	private static function get_invoices_list()
	{
		?><form method="post" enctype='multipart/form-data' target="_self" onsubmit="hc.loader(true);">
			<section class="nav_btns" style="display:none;">
				<span class='bt_tableTools'></span>
			</section>
			<table id="invoices_grid" class="display widefat" cellpadding="0" cellspacing="0" width="100%" style="display:none;"></table>
		</form><?php
	}
}