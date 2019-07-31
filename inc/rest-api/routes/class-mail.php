<?php
/**
 * Custom API route for sending mail.
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance\Rest_Api\Routes;

if ( ! defined( 'WPINC' ) ) {
	exit;
}

if ( class_exists( '\\WP_REST_Controller' ) ) {
	/**
	 * Mail API class.
	 */
	class Mail extends \WP_REST_Controller {
		/**
		 * API namespace.
		 *
		 * @var string
		 */
		protected const NAMESPACE = 'mail/v1';

		/**
		 * Register the routes for the objects of the controller.
		 */
		public function register_routes() {
			$blog_name = wp_strip_all_tags( trim( get_option( 'blogname' ) ) );
			register_rest_route(
				self::NAMESPACE, '/send', [
					'methods'  => \WP_REST_Server::CREATABLE,
					'callback' => [ $this, 'send_mail' ],
					'args'     => [
						'email_subject'      => [
							'default'           => "New message sent from the $blog_name website",
							'sanitize_callback' => 'sanitize_text_field',
						],
						'contact_from_name'  => [
							'sanitize_callback' => 'sanitize_text_field',
						],
						'contact_from_email' => [
							'required'          => true,
							'sanitize_callback' => 'sanitize_email',
							'validate_callback' => [ $this, 'validate_email' ],
						],
						'contact_to_email'   => [
							'required'          => true,
							'sanitize_callback' => 'sanitize_email',
							'validate_callback' => [ $this, 'validate_email' ],
						],
						'reply_to_name'      => [
							'sanitize_callback' => 'sanitize_text_field',
						],
						'reply_to_email'     => [
							'sanitize_callback' => 'sanitize_email',
							'validate_callback' => [ $this, 'validate_email' ],
						],
						'email_body'         => [
							'required'          => true,
							'sanitize_callback' => 'wp_kses_post',
						],
					],
				]
			);
		}

		/**
		 * Validation callback for email params.
		 *
		 * @param  string  $param Value passed as a request parameter.
		 * @return boolean        Whether or not the email is valid.
		 */
		public function validate_email( $param ) {
			return (bool) is_email( $param );
		}

		/**
		 * Mail handler callback for the route.
		 *
		 * @param  array $request  Request object
		 */
		public function send_mail( $request ) {
			$response   = [
				'status'  => 304,
				'message' => 'There was an error sending the form.',
			];
			$parameters = $request->get_params();

			$subject    = $parameters['email_subject'];
			$body       = urldecode( $parameters['email_body'] );
			$to         = $parameters['contact_to_email'];
			$from       = $parameters['contact_from_email'];
			$from_name  = $parameters['contact_from_name'];
			$reply      = $parameters['reply_to_email'];
			$reply_name = $parameters['reply_to_name'];
			$headers    = [];

			$headers[] = $from_name ? "From: $from_name <$from>" : "From: $from";
			if ( $reply ) {
				$headers[] = $reply_name ? "Reply-To: $reply_name <$reply>" : "Reply-To: $reply";
			}

			// phpcs:disable
			if ( wp_mail( $to, $subject, $body, $headers ) ) {
				$response['status']  = 200;
				$response['message'] = 'Form sent successfully.';
			} else {
				$error = serialize( json_encode( $request ) ) . "\n" . serialize( json_encode( $response ) );
				error_log( $error );
				// $is_dev      = getenv( 'NODE_ENV' ) === 'development';
				// $destination = get_option( 'customer_feedback' ) ?: get_option( 'admin_email' );
				// $headers     = $is_dev ? "Subject: S+H Error Log\nFrom: " . $destination . "\n" : null;
				// error_log( $error, $is_dev ? 1 : 0, $destination, $headers );
			}
			return json_encode( $response );
			// phpcs:enable
			exit();
		}
	}
}
