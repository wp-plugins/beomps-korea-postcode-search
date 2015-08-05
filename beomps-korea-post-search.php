<?php
	/*
	 * Plugin Name: Beomps Korea Postcode Search 
	 * Plugin URI: Http://beomps.com
	 * Description: 한국 우편 번호 검색을 위한 플러그인입니다. 우커머스의 billing/shipping 페이지에 호환되도록 작성하였습니다. Korea Postcode Search
	 * Author: park seong beom
	 * Author URI: Http://beomps.com
	 * Version:1.0 
	 */

	//woocommert checkout filed change
	add_filter( 'woocommerce_checkout_fields' , 'bkps_custom_override_checkout_fields' );
	
	// unset is disable comlume, label is above on input field
	function bkps_custom_override_checkout_fields( $fields ) {

		// 주석 처리된 unset 은 해당 필드를 사용하지 않을 때 사용합니다. 
	     //unset($fields['billing']['billing_email']);
	
	     // unset($fields['billing']['billing_last_name']);
	     // unset($fields['shipping']['shipping_last_name']);

	     // unset($fields['billing']['billing_company']);
	     // unset($fields['shipping']['shipping_company']);

	     // unset($fields['billing']['billing_city']);
	     // unset($fields['shipping']['shipping_city']);

		 $fields['billing']['billing_address_1']['label'] = '<input type="button" id="billing_postcode_search" value="우편번호 찾기" class="btn" onclick="openDaumPostcode();" style="height: 40px;">';

		 $fields['shipping']['shipping_address_1']['label'] = '<input type="button" id="shipping_postcode_search" value="우편번호 찾기" class="btn" onclick="openDaumPostcode2();" style="height: 40px;">';
		 

	     return $fields;
	}
	 
	 
	 // add Daum postcode search 
	 // action 을 워드프레스 로딩시 로딩 되도록 작성 되어있습니다.
	 add_action('init','bkps_address_start');
	 function bkps_address_start(){
			
	 	
		//Daum postcode search for HTTP
		//SSL을 사용하지 않는 다면 바로 아래 코드를 사용하세요.
		wp_enqueue_script( 'postcode', 'http://dmaps.daum.net/map_js_init/postcode.js', array(), null, true );
		
		//Daum postcode search for HTTPS
		//SSL을 사용하면 바로 아래 코드를 사용하세요.
		//wp_enqueue_script( 'postcode', 'https://spi.maps.daum.net/imap/map_js_init/postcode.js', array(), null, true );
		

		add_action('wp_enqueue_scripts', 'bkps_wp_enqueue_scripts');


		//add action for clicking button 
		function bkps_wp_enqueue_scripts() {
    	?>
		    <script type="text/javascript">
			    //for billing address
		        function openDaumPostcode() {

			        new daum.Postcode({
			            oncomplete: function(data) {
			                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			                document.getElementById('billing_postcode').value = data.postcode1+'-'+data.postcode2;
			                document.getElementById('billing_address_1').value = data.address;
			
			                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			                //var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			                //document.getElementById('addr').value = addr;
			
			                document.getElementById('billing_address_2').focus();
			            }
			        }).open();
			    }
			    //for shipping address
			    function openDaumPostcode2() {

			        new daum.Postcode({
			            oncomplete: function(data) {
			                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			                document.getElementById('shipping_postcode').value = data.postcode1+'-'+data.postcode2;
			                document.getElementById('shipping_address_1').value = data.address;
			
			                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			                //var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			                //document.getElementById('addr').value = addr;
			
			                document.getElementById('shipping_address_2').focus();
			            }
			        }).open();
			    }
		    </script>
   		 <?php
		}
	 }