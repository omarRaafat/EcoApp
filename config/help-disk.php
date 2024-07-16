<?php
return [
    "env" => env("HELP_DISK_ENV", "old"),
    "api_url"  =>  env("HELP_DISK_API_URL"),
	"access_token"  =>  env("HELP_DISK_ACCESS_TOKEN"),
	"mailbox_id" => env("HELP_DISK_MAILBOX_ID"),
	"category_token"  => [
		"inquiries_token"  =>  env("HELP_DISK_INQUIRY_TOKEN"),
		"complaints_token"  =>  env("HELP_DISK_COMPLAINT_TOKEN")
	]
];
