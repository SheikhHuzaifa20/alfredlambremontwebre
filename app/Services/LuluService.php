<?php

namespace App\Services;

use App\Models\Orders;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LuluService
{
    protected string $clientKey;
    protected string $clientSecret;
    protected string $environment;
    protected string $authUrl;
    protected string $apiBaseUrl;
    protected string $defaultShippingLevel;
    protected string $defaultCountryCode;

    public function __construct()
    {
        $this->clientKey = (string) config('lulu.client_key', env('LULU_CLIENT_KEY', ''));
        $this->clientSecret = (string) config('lulu.client_secret', env('LULU_CLIENT_SECRET', ''));
        $this->environment = (string) config('lulu.environment', env('LULU_ENV', 'production'));

        $endpoints = config('lulu.endpoints.' . $this->environment);
        if (!$endpoints) {
            $endpoints = config('lulu.endpoints.production');
        }

        $this->authUrl = $endpoints['auth'] ?? 'https://api.lulu.com/auth/realms/glasstree/protocol/openid-connect/token';
        $this->apiBaseUrl = rtrim($endpoints['api'] ?? 'https://api.lulu.com', '/');
        $this->defaultShippingLevel = (string) config('lulu.default_shipping_level', 'MAIL');
        $this->defaultCountryCode = (string) config('lulu.default_country_code', 'US');
    }

    /**
     * Check if Lulu credentials are configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->clientKey) && !empty($this->clientSecret);
    }

    /**
     * Obtain OAuth 2.0 Access Token with caching.
     */
    public function getAccessToken(): ?string
    {
        if (!$this->isConfigured()) {
            Log::warning('LuluService: Client key or client secret not configured.');
            return null;
        }

        $cacheKey = 'lulu_oauth_token_' . md5($this->clientKey . '_' . $this->environment);

        return Cache::remember($cacheKey, 3300, function () {
            try {
                $response = Http::asForm()
                    ->withBasicAuth($this->clientKey, $this->clientSecret)
                    ->post($this->authUrl, [
                        'grant_type' => 'client_credentials',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['access_token'] ?? null;
                }

                // Fallback attempt: some environments accept credentials in POST body
                $bodyResponse = Http::asForm()
                    ->post($this->authUrl, [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->clientKey,
                        'client_secret' => $this->clientSecret,
                    ]);

                if ($bodyResponse->successful()) {
                    $data = $bodyResponse->json();
                    return $data['access_token'] ?? null;
                }

                Log::error('LuluService: Authentication failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            } catch (\Throwable $e) {
                Log::error('LuluService: Authentication exception: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Normalize country to 2-letter ISO 3166-1 alpha-2 code.
     */
    public function normalizeCountryCode(?string $country): string
    {
        if (empty($country)) {
            return $this->defaultCountryCode;
        }

        $country = trim($country);

        // If already 2 letters
        if (strlen($country) === 2) {
            return strtoupper($country);
        }

        $map = [
            'united states' => 'US', 'united states of america' => 'US', 'usa' => 'US',
            'afghanistan' => 'AF', 'albania' => 'AL', 'algeria' => 'DZ', 'andorra' => 'AD', 'angola' => 'AO', 'antigua and barbuda' => 'AG', 'argentina' => 'AR', 'armenia' => 'AM',
            'australia' => 'AU', 'austria' => 'AT', 'azerbaijan' => 'AZ', 'bahamas' => 'BS', 'bahrain' => 'BH', 'bangladesh' => 'BD', 'barbados' => 'BB', 'belarus' => 'BY',
            'belgium' => 'BE', 'belize' => 'BZ', 'benin' => 'BJ', 'bhutan' => 'BT', 'bolivia' => 'BO', 'bosnia and herzegovina' => 'BA', 'botswana' => 'BW', 'brazil' => 'BR',
            'brunei' => 'BN', 'bulgaria' => 'BG', 'burkina faso' => 'BF', 'burundi' => 'BI', 'cabo verde' => 'CV', 'cambodia' => 'KH', 'cameroon' => 'CM', 'canada' => 'CA',
            'central african republic' => 'CF', 'chad' => 'TD', 'chile' => 'CL', 'china' => 'CN', 'colombia' => 'CO', 'comoros' => 'KM', 'congo' => 'CG', 'costa rica' => 'CR',
            'croatia' => 'HR', 'cuba' => 'CU', 'cyprus' => 'CY', 'czech republic' => 'CZ', 'denmark' => 'DK', 'djibouti' => 'DJ', 'dominica' => 'DM', 'dominican republic' => 'DO',
            'ecuador' => 'EC', 'egypt' => 'EG', 'el salvador' => 'SV', 'equatorial guinea' => 'GQ', 'eritrea' => 'ER', 'estonia' => 'EE', 'eswatini' => 'SZ', 'ethiopia' => 'ET',
            'fiji' => 'FJ', 'finland' => 'FI', 'france' => 'FR', 'gabon' => 'GA', 'gambia' => 'GM', 'georgia' => 'GE', 'germany' => 'DE', 'ghana' => 'GH', 'greece' => 'GR',
            'grenada' => 'GD', 'guatemala' => 'GT', 'guinea' => 'GN', 'guinea-bissau' => 'GW', 'guyana' => 'GY', 'haiti' => 'HT', 'honduras' => 'HN', 'hong kong' => 'HK',
            'hungary' => 'HU', 'iceland' => 'IS', 'india' => 'IN', 'indonesia' => 'ID', 'iran' => 'IR', 'iraq' => 'IQ', 'ireland' => 'IE', 'israel' => 'IL', 'italy' => 'IT',
            'ivory coast' => 'CI', 'jamaica' => 'JM', 'japan' => 'JP', 'jordan' => 'JO', 'kazakhstan' => 'KZ', 'kenya' => 'KE', 'kiribati' => 'KI', 'kosovo' => 'XK',
            'kuwait' => 'KW', 'kyrgyzstan' => 'KG', 'laos' => 'LA', 'latvia' => 'LV', 'lebanon' => 'LB', 'lesotho' => 'LS', 'liberia' => 'LR', 'libya' => 'LY',
            'liechtenstein' => 'LI', 'lithuania' => 'LT', 'luxembourg' => 'LU', 'madagascar' => 'MG', 'malawi' => 'MW', 'malaysia' => 'MY', 'maldives' => 'MV', 'mali' => 'ML',
            'malta' => 'MT', 'marshall islands' => 'MH', 'mauritania' => 'MR', 'mauritius' => 'MU', 'mexico' => 'MX', 'micronesia' => 'FM', 'moldova' => 'MD', 'monaco' => 'MC',
            'mongolia' => 'MN', 'montenegro' => 'ME', 'morocco' => 'MA', 'mozambique' => 'MZ', 'myanmar' => 'MM', 'namibia' => 'NA', 'nauru' => 'NR', 'nepal' => 'NP',
            'netherlands' => 'NL', 'new zealand' => 'NZ', 'nicaragua' => 'NI', 'niger' => 'NE', 'nigeria' => 'NG', 'north korea' => 'KP', 'north macedonia' => 'MK', 'norway' => 'NO',
            'oman' => 'OM', 'pakistan' => 'PK', 'palau' => 'PW', 'palestine' => 'PS', 'panama' => 'PA', 'papua new guinea' => 'PG', 'paraguay' => 'PY', 'peru' => 'PE',
            'philippines' => 'PH', 'poland' => 'PL', 'portugal' => 'PT', 'qatar' => 'QA', 'romania' => 'RO', 'russia' => 'RU', 'rwanda' => 'RW',
            'saint kitts and nevis' => 'KN', 'saint lucia' => 'LC', 'saint vincent and the grenadines' => 'VC', 'samoa' => 'WS', 'san marino' => 'SM',
            'sao tome and principe' => 'ST', 'saudi arabia' => 'SA', 'senegal' => 'SN', 'serbia' => 'RS', 'seychelles' => 'SC', 'sierra leone' => 'SL', 'singapore' => 'SG',
            'slovakia' => 'SK', 'slovenia' => 'SI', 'solomon islands' => 'SB', 'somalia' => 'SO', 'south africa' => 'ZA', 'south korea' => 'KR', 'south sudan' => 'SS',
            'spain' => 'ES', 'sri lanka' => 'LK', 'sudan' => 'SD', 'suriname' => 'SR', 'sweden' => 'SE', 'switzerland' => 'CH', 'syria' => 'SY', 'taiwan' => 'TW',
            'tajikistan' => 'TJ', 'tanzania' => 'TZ', 'thailand' => 'TH', 'timor-leste' => 'TL', 'togo' => 'TG', 'tonga' => 'TO', 'trinidad and tobago' => 'TT',
            'tunisia' => 'TN', 'turkey' => 'TR', 'turkmenistan' => 'TM', 'tuvalu' => 'TV', 'uganda' => 'UG', 'ukraine' => 'UA', 'united arab emirates' => 'AE', 'uae' => 'AE',
            'united kingdom' => 'GB', 'uk' => 'GB', 'great britain' => 'GB', 'uruguay' => 'UY', 'uzbekistan' => 'UZ', 'vanuatu' => 'VU', 'vatican city' => 'VA',
            'venezuela' => 'VE', 'vietnam' => 'VN', 'yemen' => 'YE', 'zambia' => 'ZM', 'zimbabwe' => 'ZW'
        ];

        $lower = strtolower($country);
        return $map[$lower] ?? $this->defaultCountryCode;
    }

    /**
     * Normalize state/province code, especially for US addresses where Lulu strictly requires valid 2-letter codes.
     */
    public function normalizeStateCode(?string $state, string $countryCode = 'US'): string
    {
        if (strtoupper($countryCode) !== 'US') {
            return (string) $state;
        }

        if (empty($state)) {
            return 'NY';
        }

        $trimmed = trim($state);
        $upper = strtoupper($trimmed);

        $validUsStates = [
            'AL', 'AK', 'AS', 'AZ', 'AR', 'AA', 'AE', 'AP', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA',
            'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'FM',
            'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK',
            'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV',
            'WI', 'WY'
        ];

        if (in_array($upper, $validUsStates, true)) {
            return $upper;
        }

        $nameMap = [
            'alabama' => 'AL', 'alaska' => 'AK', 'arizona' => 'AZ', 'arkansas' => 'AR',
            'california' => 'CA', 'colorado' => 'CO', 'connecticut' => 'CT', 'delaware' => 'DE',
            'district of columbia' => 'DC', 'florida' => 'FL', 'georgia' => 'GA', 'hawaii' => 'HI',
            'idaho' => 'ID', 'illinois' => 'IL', 'indiana' => 'IN', 'iowa' => 'IA',
            'kansas' => 'KS', 'kentucky' => 'KY', 'louisiana' => 'LA', 'maine' => 'ME',
            'maryland' => 'MD', 'massachusetts' => 'MA', 'michigan' => 'MI', 'minnesota' => 'MN',
            'mississippi' => 'MS', 'missouri' => 'MO', 'montana' => 'MT', 'nebraska' => 'NE',
            'nevada' => 'NV', 'new hampshire' => 'NH', 'new jersey' => 'NJ', 'new mexico' => 'NM',
            'new york' => 'NY', 'north carolina' => 'NC', 'north dakota' => 'ND', 'ohio' => 'OH',
            'oklahoma' => 'OK', 'oregon' => 'OR', 'pennsylvania' => 'PA', 'rhode island' => 'RI',
            'south carolina' => 'SC', 'south dakota' => 'SD', 'tennessee' => 'TN', 'texas' => 'TX',
            'utah' => 'UT', 'vermont' => 'VT', 'virginia' => 'VA', 'washington' => 'WA',
            'west virginia' => 'WV', 'wisconsin' => 'WI', 'wyoming' => 'WY',
        ];

        $lower = strtolower($trimmed);
        return $nameMap[$lower] ?? 'NY';
    }

    /**
     * Create a Print Job on Lulu for the given Order.
     */
    public function createPrintJob(Orders $order): array
    {
        $order->loadMissing('order_products.product');

        // 1. Filter items that are Lulu fulfillable
        $lineItems = [];
        $missingSpecs = [];

        foreach ($order->order_products as $item) {
            $product = $item->product;

            // Only fulfill products that have Lulu fulfillment enabled
            if ($product && !empty($product->is_lulu_fulfillable)) {
                $podPackageId = trim((string) $product->lulu_pod_package_id);
                $coverUrl = trim((string) $product->lulu_cover_url);
                $interiorUrl = trim((string) $product->lulu_interior_url);

                if (empty($podPackageId) || empty($interiorUrl) || empty($coverUrl)) {
                    $missingSpecs[] = $product->name . " (Missing POD ID or Interior/Cover URL)";
                    continue;
                }

                $lineItems[] = [
                    'title' => (string) ($item->order_products_name ?? $product->name),
                    'external_id' => 'ITEM-' . $item->id,
                    'printable_normalization' => [
                        'cover' => [
                            'source_url' => $coverUrl,
                        ],
                        'interior' => [
                            'source_url' => $interiorUrl,
                        ],
                        'pod_package_id' => $podPackageId,
                    ],
                    'pod_package_id' => $podPackageId,
                    'quantity' => max(1, (int) ($item->order_products_qty ?? 1)),
                ];
            }
        }

        if (empty($lineItems)) {
            $reason = !empty($missingSpecs)
                ? 'Lulu fulfillment skipped: Some books had missing configuration: ' . implode(', ', $missingSpecs)
                : 'No Lulu fulfillable books found in this order.';

            $order->lulu_error_message = $reason;
            $order->save();

            return [
                'success' => false,
                'message' => $reason,
            ];
        }

        // 2. Obtain Token
        $token = $this->getAccessToken();
        if (!$token) {
            $error = 'Failed to authenticate with Lulu API. Please check client key and secret.';
            $order->lulu_error_message = $error;
            $order->save();

            return [
                'success' => false,
                'message' => $error,
            ];
        }

        // 3. Prepare Customer Shipping Address
        $customerName = trim(($order->delivery_first_name ?? '') . ' ' . ($order->delivery_last_name ?? ''));
        if (empty($customerName)) {
            $customerName = 'Valued Customer';
        }

        $countryCode = $this->normalizeCountryCode($order->delivery_country);
        $stateCode = $this->normalizeStateCode($order->delivery_state, $countryCode);
        $postcode = (string) ($order->delivery_zip_code ?: '10001');
        if ($countryCode === 'US' && !preg_match('/^\d{5}(-\d{4})?$/', $postcode)) {
            $postcode = '10001';
        }

        $shippingAddress = [
            'name' => $customerName,
            'street1' => (string) ($order->delivery_address_1 ?: 'Street Address'),
            'street2' => (string) ($order->delivery_address_2 ?? ''),
            'city' => (string) ($order->delivery_city ?: 'City'),
            'state_code' => $stateCode,
            'country_code' => $countryCode,
            'postcode' => $postcode,
            'phone_number' => (string) ($order->delivery_phone_no ?: '0000000000'),
        ];

        // 4. Construct Payload
        $payload = [
            'contact_email' => (string) ($order->order_email ?: config('mail.from.address', 'info@example.com')),
            'external_reference' => 'ORD-' . $order->id,
            'line_items' => $lineItems,
            'shipping_address' => $shippingAddress,
            'shipping_level' => $this->defaultShippingLevel,
        ];

        try {
            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->apiBaseUrl . '/print-jobs/', $payload);

            $statusCode = $response->status();
            $data = $response->json();

            if ($response->successful() && !empty($data['id'])) {
                $jobId = (string) $data['id'];
                $statusName = $data['status']['name'] ?? 'CREATED';
                $cost = isset($data['costs']['total_cost_excl_tax'])
                    ? (float) $data['costs']['total_cost_excl_tax']
                    : null;

                $order->lulu_job_id = $jobId;
                $order->lulu_status = $statusName;
                $order->lulu_cost = $cost;
                $order->lulu_error_message = null;
                $order->save();

                Log::info("LuluService: Print job #{$jobId} created for order #{$order->id}");

                return [
                    'success' => true,
                    'job_id' => $jobId,
                    'status' => $statusName,
                    'data' => $data,
                ];
            }

            // Error response from Lulu
            $errorMsg = 'Lulu Error (' . $statusCode . '): ';
            if (!empty($data['errors'])) {
                $errorMsg .= json_encode($data['errors']);
            } elseif (!empty($data['detail'])) {
                $errorMsg .= $data['detail'];
            } elseif (!empty($data['message'])) {
                $errorMsg .= $data['message'];
            } else {
                $errorMsg .= $response->body();
            }

            $order->lulu_error_message = substr($errorMsg, 0, 1000);
            $order->save();

            Log::error("LuluService: Print job creation failed for order #{$order->id}: " . $errorMsg);

            return [
                'success' => false,
                'message' => $errorMsg,
                'status_code' => $statusCode,
            ];
        } catch (\Throwable $e) {
            $errorMsg = 'Exception while connecting to Lulu: ' . $e->getMessage();
            $order->lulu_error_message = substr($errorMsg, 0, 1000);
            $order->save();

            Log::error($errorMsg);

            return [
                'success' => false,
                'message' => $errorMsg,
            ];
        }
    }

    /**
     * Retrieve Print Job Status from Lulu API.
     */
    public function getPrintJobStatus(string $jobId): ?array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withToken($token)->get($this->apiBaseUrl . '/print-jobs/' . $jobId . '/');

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("LuluService: Failed to fetch status for job #{$jobId}", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error("LuluService: Status fetch error for job #{$jobId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Sync and update order with latest Lulu status and tracking information.
     */
    public function syncOrderStatus(Orders $order): array
    {
        if (empty($order->lulu_job_id)) {
            return [
                'success' => false,
                'message' => 'No Lulu Job ID associated with this order.',
            ];
        }

        $data = $this->getPrintJobStatus($order->lulu_job_id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Could not retrieve print job status from Lulu.',
            ];
        }

        $statusName = $data['status']['name'] ?? $order->lulu_status;
        $order->lulu_status = $statusName;

        // Check for shipments and tracking info
        $trackingNumber = null;
        $trackingUrl = null;

        if (!empty($data['shipments']) && is_array($data['shipments'])) {
            foreach ($data['shipments'] as $shipment) {
                if (!empty($shipment['tracking_urls']) && is_array($shipment['tracking_urls'])) {
                    $trackingUrl = $shipment['tracking_urls'][0] ?? null;
                }
                if (!empty($shipment['tracking_number'])) {
                    $trackingNumber = $shipment['tracking_number'];
                }
            }
        }

        if ($trackingNumber) {
            $order->lulu_tracking_number = $trackingNumber;
        }
        if ($trackingUrl) {
            $order->lulu_tracking_url = $trackingUrl;
        }

        // If rejected, extract line item rejection messages
        if (strtoupper((string) $statusName) === 'REJECTED') {
            $reasons = [];
            if (!empty($data['line_items']) && is_array($data['line_items'])) {
                foreach ($data['line_items'] as $item) {
                    $itemMessages = $item['status']['messages'] ?? [];
                    if (!empty($itemMessages['printable_normalization']) && is_array($itemMessages['printable_normalization'])) {
                        foreach ($itemMessages['printable_normalization'] as $component => $msgs) {
                            if (is_array($msgs)) {
                                foreach ($msgs as $msg) {
                                    $reasons[] = ucfirst((string)$component) . ': ' . $msg;
                                }
                            } elseif (is_string($msgs)) {
                                $reasons[] = ucfirst((string)$component) . ': ' . $msgs;
                            }
                        }
                    }
                }
            }

            if (!empty($reasons)) {
                $order->lulu_error_message = implode(' | ', $reasons);
            }
        }

        // If status indicates shipped, update order status
        if (in_array(strtoupper((string) $statusName), ['SHIPPED', 'DELIVERED'])) {
            $order->order_status = 'shipped';
        }

        $order->save();

        return [
            'success' => true,
            'status' => $statusName,
            'tracking_number' => $trackingNumber,
            'tracking_url' => $trackingUrl,
            'data' => $data,
        ];
    }
}

