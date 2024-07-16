<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4-P',
	'author'                => 'Saudi Dates',
	'subject'               => 'Saudi Dates Invocie',
	'keywords'              => 'Saudi-Dates-Invocie,Saudi-Dates,Invocie,invocie',
	'creator'               => 'Order Invoice',
	'display_mode'          => 'fullpage',
	'tempDir'               => public_path("/temp"),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/bukra'),
	'font_data' => [
		'bukrafont' => [
			'R'  => '29ltbukraregular.ttf',    // regular font
			'B'  => '29ltbukrabold.ttf',       // optional: bold font
			// 'I'  => '29ltbukralight.ttf',     // optional: italic font
			'BI' => '29ltbukrabolditalic.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
			'useKashida' => 75,
		]
	]
];