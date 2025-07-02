<?php

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off display errors for production
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/php-errors.log'); // Set error log file path to backend/php-errors.log

header('Content-Type: application/json');

// Allow requests from your frontend origin
// In a production environment, you should restrict this to your actual frontend domain
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// --- Constants from Project Brief ---
const REGION_MAX_FUEL = [
    'region1' => 1200, // tons
    'region2' => 800,  // tons
    'region3' => 500   // tons
];

const FUEL_PRICES = [
    'benzene' => 500.200, // r/ton
    'gas' => 200.100,     // r/ton
    'diesel' => 320.700   // r/ton
];

const FUEL_BRANDS = [
    'benzene' => ['Rosneft', 'Tatneft', 'Lukoil'],
    'gas' => ['Shell', 'Gazprom', 'Bashneft'],
    'diesel' => ['Tatneft', 'Lukoil']
];

const TARIFF_DISCOUNTS = [
    'economy' => 0.03, // 3%
    'favorite' => 0.05, // 5%
    'premium' => 0.07 // 7%
];

const PROMO_ACTIONS = [
    'economy' => [2, 5], // 2%, 5%
    'favorite' => [5, 20], // 5%, 20%
    'premium' => [20, 50] // 20%, 50%
];

// --- Validation Functions ---
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidInn($inn) {
    return preg_match('/^\d{12}$/', $inn); // Exactly 12 digits
}

function isValidPhone($phone) {
    return preg_match('/^\d{11}$/', $phone); // Exactly 11 digits
}

// --- Calculation Functions ---
function getTariff($fuelType, $amount) {
    switch ($fuelType) {
        case 'benzene':
            if ($amount < 100) return 'economy';
            if ($amount >= 100 && $amount <= 300) return 'favorite';
            if ($amount > 300) return 'premium';
            break;
        case 'gas':
            if ($amount < 200) return 'economy';
            if ($amount >= 200 && $amount <= 700) return 'favorite';
            if ($amount > 700) return 'premium';
            break;
        case 'diesel':
            if ($amount < 150) return 'economy';
            if ($amount >= 150 && $amount <= 350) return 'favorite';
            if ($amount > 350) return 'premium';
            break;
        default:
            return null;
    }
}

function calculateFuelCost($fuelType, $amount, $tariff, $promoDiscount) {
    $baseCost = FUEL_PRICES[$fuelType] * $amount;
    $tariffDiscountAmount = $baseCost * TARIFF_DISCOUNTS[$tariff];
    $promoDiscountAmount = $baseCost * $promoDiscount;
    return $baseCost - ($tariffDiscountAmount + $promoDiscountAmount);
}

function calculateSavings($fuelType, $amount, $tariff, $promoDiscount) {
    $baseCost = FUEL_PRICES[$fuelType] * $amount;
    $tariffDiscountAmount = $baseCost * TARIFF_DISCOUNTS[$tariff];
    $promoDiscountAmount = $baseCost * $promoDiscount;
    $monthlySavings = $tariffDiscountAmount + $promoDiscountAmount;
    return [
        'monthly' => $monthlySavings,
        'yearly' => $monthlySavings * 12
    ];
}

// --- Main Request Handler ---
$response = [
    'status' => 'error',
    'message' => 'Invalid Request',
    'data' => null
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log received data to console
    error_log('Received data: ' . print_r($data, true));

    if (json_last_error() === JSON_ERROR_NONE && isset($data['action'])) {
        switch ($data['action']) {
            case 'get_config':
                $response = [
                    'status' => 'success',
                    'message' => 'Configuration fetched successfully.',
                    'data' => [
                        'regionMaxFuel' => REGION_MAX_FUEL,
                        'fuelPrices' => FUEL_PRICES,
                        'fuelBrands' => FUEL_BRANDS,
                        'tariffDiscounts' => TARIFF_DISCOUNTS,
                        'promoActions' => PROMO_ACTIONS,
                        'allBrands' => [
                            ['label' => 'Shell', 'value' => 'shell'],
                            ['label' => 'Газпром', 'value' => 'gazprom'],
                            ['label' => 'Роснефть', 'value' => 'rosneft'],
                            ['label' => 'Татнефть', 'value' => 'tatneft'],
                            ['label' => 'Лукойл', 'value' => 'lukoil'],
                            ['label' => 'Башнефть', 'value' => 'bashneft'],
                        ],
                        'allPromos' => [
                            ['label' => '50%', 'value' => 50, 'desc' => 'Экономия на штрафах'],
                            ['label' => '20%', 'value' => 20, 'desc' => 'Возврат НДС'],
                            ['label' => '5%', 'value' => 5, 'desc' => 'Скидка на мойку'],
                            ['label' => '2%', 'value' => 2, 'desc' => 'Скидка на топливо'],
                        ],
                        'tariffs' => [
                            'benzene' => [['amount' => 100, 'name' => 'economy'], ['amount' => 300, 'name' => 'favorite'], ['amount' => 9999999, 'name' => 'premium']],
                            'gas' => [['amount' => 200, 'name' => 'economy'], ['amount' => 700, 'name' => 'favorite'], ['amount' => 9999999, 'name' => 'premium']],
                            'diesel' => [['amount' => 150, 'name' => 'economy'], ['amount' => 350, 'name' => 'favorite'], ['amount' => 9999999, 'name' => 'premium']],
                        ],
                    ]
                ];
                break;
            case 'calculate':
                // Expected data: region, amount, fuelType, promoAction (percentage)
                $region = $data['region'] ?? null;
                $amount = $data['amount'] ?? null;
                $fuelType = $data['fuelType'] ?? null;
                $promoAction = $data['promoAction'] ?? 0; // Expected to be an integer (e.g., 2, 5, 20, 50)

                if ($region && $amount !== null && $fuelType) {
                    if (!isset(REGION_MAX_FUEL[$region]) || $amount > REGION_MAX_FUEL[$region]) {
                        $response['message'] = 'Invalid amount for selected region.';
                        break;
                    }
                    if (!isset(FUEL_PRICES[$fuelType])) {
                        $response['message'] = 'Invalid fuel type.';
                        break;
                    }

                    $tariff = getTariff($fuelType, $amount);
                    if (!$tariff) {
                        $response['message'] = 'Could not determine tariff.';
                        break;
                    }

                    // Validate promoAction against available for the tariff
                    $validPromoActions = PROMO_ACTIONS[$tariff] ?? [];
                    // No rounding needed, promoAction is an integer for comparison
                    if (!in_array($promoAction, $validPromoActions) && $promoAction !== 0) {
                         $response['message'] = 'Invalid promo action for selected tariff.';
                         break;
                    }


                    $monthlyCost = calculateFuelCost($fuelType, $amount, $tariff, $promoAction / 100); // Divide by 100 for calculation
                    $savings = calculateSavings($fuelType, $amount, $tariff, $promoAction / 100); // Divide by 100 for calculation
                    $totalDiscountPercentage = (TARIFF_DISCOUNTS[$tariff] * 100) + $promoAction;

                    $response = [
                        'status' => 'success',
                        'message' => 'Calculation successful.',
                        'data' => [
                            'tariff' => $tariff,
                            'promoActionsAvailable' => PROMO_ACTIONS[$tariff],
                            'brandsAvailable' => FUEL_BRANDS[$fuelType],
                            'monthlyCost' => round($monthlyCost, 2),
                            'monthlySavings' => round($savings['monthly'], 2),
                            'yearlySavings' => round($savings['yearly'], 2),
                            'totalDiscountPercentage' => round($totalDiscountPercentage, 2)
                        ]
                    ];
                } else {
                    $response['message'] = 'Missing required calculation parameters.';
                }
                break;

            case 'submit_form':
                // Expected data: region, amount, fuelType, brand, additionalServices, tariff, promoAction,
                // monthlyCost, totalDiscountPercentage, monthlySavings, yearlySavings,
                // inn, phone, email, agreeToTerms
                $requiredFields = [
                    'region', 'amount', 'fuelType', 'brand', 'tariff', 'promoAction',
                    'monthlyCost', 'totalDiscountPercentage', 'monthlySavings', 'yearlySavings',
                    'inn', 'phone', 'email', 'agreeToTerms'
                ];

                foreach ($requiredFields as $field) {
                    if (!isset($data[$field])) {
                        $response['message'] = 'Missing required form field: ' . $field . '.';
                        echo json_encode($response);
                        exit();
                    }
                }

                $inn = $data['inn'];
                $phone = $data['phone'];
                $email = $data['email'];
                $agreeToTerms = $data['agreeToTerms'];
                $selectedServices = $data['services'] ?? [];

                if (!isValidInn($inn)) {
                    $response['message'] = 'Invalid INN format. Must be 12 digits.';
                } elseif (!isValidPhone($phone)) {
                    $response['message'] = 'Invalid Phone format. Must be 11 digits.';
                } elseif (!isValidEmail($email)) {
                    $response['message'] = 'Invalid email format.';
                } elseif (!$agreeToTerms) {
                    $response['message'] = 'You must agree to the terms.';
                } elseif (count($selectedServices) > 4) {
                    $response['message'] = 'You can select at most 4 additional services.';
                } else {
                    // All validations passed, proceed with email sending
                    $emailSent = sendCalculationEmail($data);
                    if ($emailSent) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Form submitted successfully.',
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Form submitted, but failed to send email. Check server logs for SSL certificate issues.',
                        ];
                    }
                }
                break;

            default:
                $response['message'] = 'Unknown action.';
                break;
        }
    } else {
        $response['message'] = 'Invalid JSON or missing action.';
    }
}

echo json_encode($response);


/**
 * Sends a calculation summary email to the user and admin.
 * @param array $formData The data submitted from the form.
 * @return bool True if email sent successfully, false otherwise.
 */
function sendCalculationEmail($formData) {
    // Admin Email - Consider making this configurable via environment variable if needed
    $adminEmail = 'your-admin-email@example.com'; // Replace with your actual admin email
    $adminName = 'Admin';
    $subjectAdmin = 'Новая заявка с калькулятора топливо';

    // User Email
    $userEmail = $formData['email'];
    $userName = $formData['name'] ?? 'Пользователь'; // Assuming 'name' field exists or use a default

    $subjectUser = 'Ваш расчет топливного калькулятора';

    // Common data for email content
    $emailData = [
        'Region' => ucfirst($formData['region']),
        'Прокачка' => $formData['amount'] . ' тонн',
        'Тип топлива' => ucfirst($formData['fuelType']),
        'Бренд' => $formData['brand'],
        'Дополнительные услуги' => !empty($formData['additionalServices']) ? implode(', ', $formData['additionalServices']) : 'Не выбрано',
        'Тариф' => ucfirst($formData['tariff']),
        'Промо-акция' => $formData['promoAction'] . '%',
        'Стоимость топлива в месяц' => round($formData['monthlyCost'], 2) . ' р.',
        'Суммарная скидка %' => round($formData['totalDiscountPercentage'], 2) . '%',
        'Экономия в месяц' => round($formData['monthlySavings'], 2) . ' р.',
        'Экономия в год' => round($formData['yearlySavings'], 2) . ' р.',
        'Имя' => $formData['name'] ?? 'Не указано',
        'ИНН' => $formData['inn'],
        'Телефон' => $formData['phone'],
        'Email' => $formData['email']
    ];

    $htmlContent = '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
    foreach ($emailData as $key => $value) {
        $htmlContent .= '<tr><td style="font-weight: bold;">' . htmlspecialchars($key) . ':</td><td>' . htmlspecialchars($value) . '</td></tr>';
    }
    $htmlContent .= '</table>';

    // Send to Admin
    $adminEmailSent = sendBrevoApiMail($adminEmail, $adminName, $subjectAdmin, $htmlContent, 'your-sender-email@example.com', 'Fuel Calculator');

    // Send to User
    $userEmailSent = true; // Assume success for user email if admin email is sent, or implement specific user email sending logic
    if ($userEmail && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
         $userEmailSent = sendBrevoApiMail($userEmail, $userName, $subjectUser, $htmlContent, 'your-sender-email@example.com', 'Fuel Calculator');
    }

    // Return true if both emails were attempted and at least admin email was sent successfully
    return $adminEmailSent; // You might want to adjust this logic based on your exact requirements
}

/**
 * Sends an email using the Brevo API.
 * @param string $toEmail Recipient's email address.
 * @param string $toName Recipient's name.
 * @param string $subject Email subject.
 * @param string $htmlContent HTML content of the email.
 * @param string $fromEmail Sender's email address.
 * @param string $fromName Sender's name.
 * @return bool True if email sent successfully, false otherwise.
 */
function sendBrevoApiMail($toEmail, $toName, $subject, $htmlContent, $fromEmail, $fromName) {
    $apiKey = 'YOUR_BREVO_API_KEY_HERE'; // Replace with your actual Brevo API key

    error_log("Attempting to send email to: $toEmail with subject: $subject");
    error_log("From: $fromEmail ($fromName) To: $toEmail ($toName)");

    if (!$apiKey || $apiKey === 'YOUR_BREVO_API_KEY_HERE') {
        error_log('Brevo API key is not configured. Please set your API key in backend/api.php');
        return false;
    }

    try {
        $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(), $config);

        $sendSmtpEmail = new Brevo\Client\Model\SendSmtpEmail([
            'sender' => ['email' => $fromEmail, 'name' => $fromName],
            'to' => [['email' => $toEmail, 'name' => $toName]],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
            'textContent' => strip_tags($htmlContent) // Fallback for plain text clients
        ]);

        error_log('Brevo API call starting...');
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        error_log('Brevo API call completed successfully. Result: ' . json_encode($result));
        error_log('Email should have been sent to: ' . $toEmail);
        return true;
    } catch (Exception $e) {
        error_log('Brevo API Error: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . $e->getFile());
        error_log('Error Code: ' . $e->getCode());
        if (method_exists($e, 'getResponseBody')) {
            error_log('Response Body: ' . $e->getResponseBody());
        }
        return false;
    }
}