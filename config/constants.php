<?php

return [
	
	'site_url' => 'filespace.io',
	'recapcha' => [
		'secret' => '6Ldi9fcSAAAAAB5qGOv1rTVjsq5p2NgB_-dJgCFU'
	],
	'users' => [
		'status' => [
			1 => 'Active', 
			2 => 'Banned', 
			3 => 'Pending'
		],
		'last_transaction_verified_status' => [
			'Yes',
			'No'
		]
	],
	'resellers' => [
		'status' => [
			'active',
			'disabled'
		],
		'funding_note' => [
			'Web Money',
			'Bank Wire'
		]
	],
	'fileserver' => [
		'status' => [
			'Disabled',
			'Active'
		]
	],
	'filenas' => [
		'type' => [
			'remote',
			'local',
			'ftp',
			'sftp',
			'direct'
		]
	]
];