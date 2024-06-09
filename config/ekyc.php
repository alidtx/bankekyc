<?php
return [
    'api_base_url' => env('API_BASE_URL', '127.0.0.1:8000/api/v1/'),
    'app_url' => env('APP_URL', '127.0.0.1:8000'),
    'api_gaze_url' => env('API_GAZE_URL', 'https://kyc.gazetech.ml/v1/'),
    'gaze_api_key' => env('GAZE_API_KEY', '0b249fd0-d799-4cc0-9abd-345569641e0c'),
    'api_docai_ocr_url' => env('API_DOCAI_OCR_URL', '127.0.0.1:8080/'),
    // 'api_image_compare_ocr_url' => env('API_IMAGE_COMPARE_OCR_URL', 'https://ekycnidverification.sslwireless.com/'),
    'api_image_compare_ocr_url' => env('API_IMAGE_COMPARE_OCR_URL', 'http://onlinemerchdocver.sslwireless.com/'),
    'api_porichoy_url' => env('API_PORICHOY_URL', 'https://api.porichoybd.com/api/kyc/'),
    'porichoy_api_token' => env('PORICHOY_API_TOKEN', '33d38ead-4962-42f6-ac64-486709ab092d'),
    'porichoy_api_production_token' => env('PORICHOY_API_PRODUCTION_TOKEN', '33d38ead-4962-42f6-ac64-486709ab092d'),

    'nid_verification' => [
        "nid_number" => "nid_number", //1
        "name" => 'full_name', //1
        // "nameEn" => "name_en",
        // "father" => "father_name", //1
        // "mother" => "mother_name",//1
        "dob" => 'date_of_birth', //1
        // "permanentAddressEn" => "permanent_address_en",
        // "photo" => 'nid_user_image', // derived attribute
        // "gender" => "gender",
        // "spouse" => "spouse_name",
        // "fatherEn" => "father_name_en",
        // "motherEn" => "mother_name_en",
        // "spouseEn" => "spouse_en",
        // "presentAddress" => "present_address",
        // "permanentAddress" => "permanent_address",
        // "presentAddressEn" => 'present_address_en',
        "nid_image" => "nid_image",
        "nid_image_back" => "nid_image_back",
        "user_photo" => "user_photo",
        "fingerprint" => "fingerprint",
    ],


    'nid_verification_upadated' => [
        "_id" => "nid_number", //1
        "name_en" => 'name_en', //1
        "name_bn" => "name_bn",
        "father_name" => "father_name", //1
        "father_name_en" => "father_name_en", //1
        "mother_name" => "mother_name",//1
        "mother_name_en" => "mother_name_en",//1
        "dob" => 'date_of_birth', //1
        // "permanentAddressEn" => "permanent_address_en",
        // "photo" => 'nid_user_image', // derived attribute
        // "gender" => "gender",
        // "spouse" => "spouse_name",
        // "fatherEn" => "father_name_en",
        // "motherEn" => "mother_name_en",
        // "spouseEn" => "spouse_en",
        // "presentAddress" => "present_address",
        // "permanentAddress" => "permanent_address",
        // "presentAddressEn" => 'present_address_en',
        "nid_image" => "nid_image",
        "nid_image_back" => "nid_image_back",
        "user_photo" => "user_photo",
        "fingerprint" => "fingerprint",
    ],

    'nominee_nid_verification' => [
        "nid_number" => "nominee_nid_number", //1
        "name" => 'nominee_full_name', //1
        // "nameEn" => "nominee_name_en",
        // "father" => "nominee_father_name", //1
        // "mother" => "nominee_mother_name",//1
        "dob" => 'nominee_date_of_birth', //1
        // "permanentAddressEn" => "nominee_permanent_address_en",
        // "photo" => 'nominee_nid_user_image', // derived attribute
        // "gender" => "nominee_gender",
        // "spouse" => "nominee_spouse_name",
        // "fatherEn" => "nominee_father_name_en",
        // "motherEn" => "nominee_mother_name_en",
        // "spouseEn" => "nominee_spouse_en",
        // "presentAddress" => "nominee_present_address",
        // "permanentAddress" => "nominee_permanent_address",
        // "presentAddressEn" => 'nominee_present_address_en',
        "nid_image" => "nominee_nid_front",
        "nid_image_back" => "nominee_nid_back",
        "user_photo" => "nominee_photo",
    ],

    'nominee2_nid_verification' => [
        "nid_number" => "nominee2_nid_number", //1
        "name" => 'nominee2_full_name', //1
        // "nameEn" => "nominee_name_en",
        // "father" => "nominee_father_name", //1
        // "mother" => "nominee_mother_name",//1
        "dob" => 'nominee2_date_of_birth', //1
        // "permanentAddressEn" => "nominee_permanent_address_en",
        // "photo" => 'nominee_nid_user_image', // derived attribute
        // "gender" => "nominee_gender",
        // "spouse" => "nominee_spouse_name",
        // "fatherEn" => "nominee_father_name_en",
        // "motherEn" => "nominee_mother_name_en",
        // "spouseEn" => "nominee_spouse_en",
        // "presentAddress" => "nominee_present_address",
        // "permanentAddress" => "nominee_permanent_address",
        // "presentAddressEn" => 'nominee_present_address_en',
        "nid_image" => "nominee2_nid_front",
        "nid_image_back" => "nominee2_nid_back",
        "user_photo" => "nominee2_photo",
    ],

    'otp_idle_time' => '50',
    'nid_api_key' => 'tnnP68rXayMZfkKbU6CjajPRi1HvNHg0aUKRtVLGQGyxwnq4lVRNTH5MtfY8QUsk'
];