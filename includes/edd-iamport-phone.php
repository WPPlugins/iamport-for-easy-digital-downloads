<?php
class EddIamportPhone extends EddIamportNormal {

	public function identify() {
		return array(
			'gateway_id' => 'iamport_phone',
			'admin_label' => '아임포트(휴대폰소액결제)',
			'checkout_label' => '휴대폰소액결제 결제'
		);
	}

	public function settings($settings) {
		$settings['iamport_phone'] = array(
			'iamport_phone_settings' => array(
				'id' => 'iamport_phone_settings',
				'name' => '아임포트(휴대폰소액결제)',
				'type' => 'header'
			),
			'iamport_phone_user_code' => array(
				'id' => 'iamport_phone_user_code',
				'name' => '아임포트 사용자 식별코드',
				'type' => 'text',
				'size' => 'regular'
			),
			'iamport_phone_rest_key' => array(
				'id' => 'iamport_phone_rest_key',
				'name' => '아임포트 REST API Key',
				'type' => 'text',
				'size' => 'regular'
			),
			'iamport_phone_rest_secret' => array(
				'id' => 'iamport_phone_rest_secret',
				'name' => '아임포트 REST API Secret',
				'type' => 'text',
				'size' => 'large'
			)
		);

		return $settings;
	}

	public function sections($sections) {
		$sections['iamport_phone'] = '아임포트(휴대폰소액결제)';
		return $sections;
	}

	public function cc_form() {
		$user_code = edd_get_option( 'iamport_phone_user_code' );
		$merchant_uid = $this->generate_merchant_uid();

		ob_start(); ?>
		<input type="hidden" name="iamport_user_code" value="<?=$user_code?>">
		<input type="hidden" name="iamport_pay_method" value="phone">
		<input type="hidden" name="iamport_merchant_uid" value="<?=$merchant_uid?>">
		<?php
		ob_end_flush();
	}

}