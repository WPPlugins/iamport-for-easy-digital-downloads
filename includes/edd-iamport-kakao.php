<?php
class EddIamportKakao extends EddIamportNormal {

	public function identify() {
		return array(
			'gateway_id' => 'iamport_kakao',
			'admin_label' => '아임포트(카카오페이)',
			'checkout_label' => '카카오페이 결제'
		);
	}

	public function settings($settings) {
		$settings['iamport_kakao'] = array(
			'iamport_kakao_settings' => array(
				'id' => 'iamport_kakao_settings',
				'name' => '아임포트(카카오페이)',
				'type' => 'header'
			),
			'iamport_kakao_user_code' => array(
				'id' => 'iamport_kakao_user_code',
				'name' => '아임포트 사용자 식별코드',
				'type' => 'text',
				'size' => 'regular'
			),
			'iamport_kakao_rest_key' => array(
				'id' => 'iamport_kakao_rest_key',
				'name' => '아임포트 REST API Key',
				'type' => 'text',
				'size' => 'regular'
			),
			'iamport_kakao_rest_secret' => array(
				'id' => 'iamport_kakao_rest_secret',
				'name' => '아임포트 REST API Secret',
				'type' => 'text',
				'size' => 'large'
			)
		);

		return $settings;
	}

	public function sections($sections) {
		$sections['iamport_kakao'] = '아임포트(카카오페이)';
		return $sections;
	}

	public function cc_form() {
		$user_code = edd_get_option( 'iamport_kakao_user_code' );
		$merchant_uid = $this->generate_merchant_uid();

		ob_start(); ?>
		<input type="hidden" name="iamport_user_code" value="<?=$user_code?>">
		<input type="hidden" name="iamport_pay_method" value="kakao">
		<input type="hidden" name="iamport_merchant_uid" value="<?=$merchant_uid?>">
		<?php
		ob_end_flush();
	}

}