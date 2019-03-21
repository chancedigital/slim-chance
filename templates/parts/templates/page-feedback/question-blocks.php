<?php
$questions = [
	[
		'id'   => 'order-experience',
		'text' => "Order & Restaurant Experience Feedback"
	],
	[
		'id'   => 'menu-information',
		'text' => "Menu Information"
	],
	[
		'id'   => 'press-marketing-inquiries',
		'text' => "Press & Marketing Inquiries"
	],
	[
		'id'   => 'tech-support',
		'text' => "Technical & Account Support"
	],
];
?>

<div class="question-blocks">
	<?php foreach ( $questions as $question ) : ?>
		<button id="feedback-button-<?php echo sanitize_title_with_dashes( esc_attr( $question['id'] ) ); ?>" class="question-blocks__block-wrapper">
			<span class="question-blocks__block-inner"><?php echo esc_html( $question['text'] ); ?></button>
		</button>
	<?php endforeach; ?>
</div>
