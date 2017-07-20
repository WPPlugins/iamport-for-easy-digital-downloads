<?php
abstract class EddIamportBase {

	abstract public function identify();
	abstract public function process_payment($purchase_data);
	abstract public function cc_form();

	public function settings($settings) {
		return $settings;
	}

	public function sections($sections) {
		return $sections;
	}

	public function process_refund( $payment_id ) {
		require_once(dirname(__DIR__).'/lib/iamport.php');

		$imp_uid = get_post_meta($payment_id, '_edd_imp_uid', true);
		
		$gateway_id = edd_get_payment_gateway( $payment_id );
		$imp_rest_key = edd_get_option( $gateway_id.'_rest_key' );
		$imp_rest_secret = edd_get_option( $gateway_id.'_rest_secret' );

		$iamport = new EddIamport($imp_rest_key, $imp_rest_secret);
		$result = $iamport->cancel(array(
			'imp_uid'=>$imp_uid,
			'reason'=>'EDD 관리자 결제취소'
		));

		if ( $result->success ) {
			$payment_data = $result->data;
			edd_insert_payment_note( $payment_id, number_format($payment_data->amount) . '원 환불완료' );
		} else {
			edd_insert_payment_note( $payment_id, $result->error['message'] );
		}
	}

	protected function generate_merchant_uid() {
		$micro_date = microtime();
		$date_array = explode(" ",$micro_date);

		return strtolower( md5( date( 'Y-m-d H:i:s' ) . $date_array[1] .  uniqid( 'iamport', true ) ) );
	}

	protected function _iamport_post_meta($payment_id, $meta_key, $meta_value) {
		if ( !add_post_meta($payment_id, $meta_key, $meta_value, true) ) {
			update_post_meta($payment_id, $meta_key, $meta_value);
		}
	}

}