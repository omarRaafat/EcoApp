<?php
namespace App\Enums;

enum CustomHeaders {
    const COUNTRY_CODE = "X-country-code";

    const LANG = "lang";
    const GUEST_TOKEN = "X-Guest-Token";
    const GENERATE_MODE = "X-GENERATE-MODE";
    const SPL_API_TOKEN = "x-api-key";
    const ARAMEX_API_TOKEN = "x-api-key";
}
