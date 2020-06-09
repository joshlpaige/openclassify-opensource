<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled Currencies
    |--------------------------------------------------------------------------
    |
    | Define an array of currencies enabled for translatable input.
    |
    */

    'enabled' => explode(',',
        env('ENABLED_CURRENCIES',
            'USD')),

    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | The default currency will be used if one can not
    | be determined automatically.
    |
    */

    'default' => env('DEFAULT_CURRENCY',
        'USD'),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | In order to enable a currency or use it at all
    | the ISO currency code MUST be in this array.
    |
    */

    'supported' => [
        'USD' => [
            'name' => 'US Dollar',
            'direction' => 'ltr',
            'symbol' => '',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
        ],
        'TRY' => [
            'name' => 'Türk Lirası',
            'direction' => 'rtl',
            'symbol' => ' TL',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
        ],
        'AED' => [
            'name' => 'UAE Dirham',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.إ',
        ],
        'AFN' => [
            'name' => 'Afghani',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Af',
        ],
        'ALL' => [
            'name' => 'Lek',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Leke',
        ],
        'AMD' => [
            'name' => 'Armenian Dram',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Դ',
        ],
        'AOA' => [
            'name' => 'Kwanza',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Kz',
        ],
        'ARS' => [
            'name' => 'Argentine Peso',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'AUD' => [
            'name' => 'Australian Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ARS',
        ],
        'AWG' => [
            'name' => 'Aruban Guilder/Florin',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ƒ',
        ],
        'AZN' => [
            'name' => 'Azerbaijanian Manat',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ман',
        ],
        'BAM' => [
            'name' => 'Konvertibilna Marka',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'КМ',
        ],
        'BBD' => [
            'name' => 'Barbados Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'BBD',
        ],
        'BDT' => [
            'name' => 'Taka',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '৳',
        ],
        'BGN' => [
            'name' => 'Bulgarian Lev',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'лв',
        ],
        'BHD' => [
            'name' => 'Bahraini Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ب.د',
        ],
        'BIF' => [
            'name' => 'Burundi Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'BMD' => [
            'name' => 'Bermudian Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'BMD',
        ],
        'BND' => [
            'name' => 'Brunei Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'BND',
        ],
        'BOB' => [
            'name' => 'Boliviano',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Bs.',
        ],
        'BRL' => [
            'name' => 'Brazilian Real',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'R$',
        ],
        'BSD' => [
            'name' => 'Bahamian Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'BSD',
        ],
        'BTN' => [
            'name' => 'Ngultrum',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '',
        ],
        'BWP' => [
            'name' => 'Pula',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'P',
        ],
        'BYN' => [
            'name' => 'Belarusian Ruble',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Br',
        ],
        'BZD' => [
            'name' => 'Belize Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'BZD',
        ],
        'CAD' => [
            'name' => 'Canadian Dollar',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'CAD',
        ],
        'CDF' => [
            'name' => 'Congolese Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'CHF' => [
            'name' => 'Swiss Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'CLP' => [
            'name' => 'Chilean Peso',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'CLP',
        ],
        'CNY' => [
            'name' => 'Yuan',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '¥',
        ],
        'COP' => [
            'name' => 'Colombian Peso',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'COP',
        ],
        'CRC' => [
            'name' => 'Costa Rican Colon',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₡',
        ],
        'CUP' => [
            'name' => 'Cuban Peso',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'CUP',
        ],
        'CVE' => [
            'name' => 'Cape Verde Escudo',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'CVE',
        ],
        'CZK' => [
            'name' => 'Czech Koruna',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Kč',
        ],
        'DJF' => [
            'name' => 'Djibouti Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'DKK' => [
            'name' => 'Danish Krone',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'kr',
        ],
        'DOP' => [
            'name' => 'Dominican Peso',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'DOP',
        ],
        'DZD' => [
            'name' => 'Algerian Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.ج',
        ],
        'EGP' => [
            'name' => 'Egyptian Pound',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'EGP',
        ],
        'ERN' => [
            'name' => 'Nakfa',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Nfk',
        ],
        'ETB' => [
            'name' => 'Ethiopian Birr',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '',
        ],
        'EUR' => [
            'name' => 'Euro',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '€',
        ],
        'FJD' => [
            'name' => 'Fiji Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'FKP' => [
            'name' => 'Falkland Islands Pound',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'FKP',
        ],
        'GBP' => [
            'name' => 'Pound Sterling',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '£',
        ],
        'GEL' => [
            'name' => 'Lari',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ლ',
        ],
        'GHS' => [
            'name' => 'Cedi',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₵',
        ],
        'GIP' => [
            'name' => 'Gibraltar Pound',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'GIP',
        ],
        'GMD' => [
            'name' => 'Dalasi',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'D',
        ],
        'GNF' => [
            'name' => 'Guinea Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'GTQ' => [
            'name' => 'Quetzal',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Q',
        ],
        'GYD' => [
            'name' => 'Guyana Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'HKD' => [
            'name' => 'Hong Kong Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'HNL' => [
            'name' => 'Lempira',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'L',
        ],
        'HRK' => [
            'name' => 'Croatian Kuna',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Kn',
        ],
        'HTG' => [
            'name' => 'Gourde',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'G',
        ],
        'HUF' => [
            'name' => 'Forint',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Ft',
        ],
        'IDR' => [
            'name' => 'Rupiah',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Rp',
        ],
        'ILS' => [
            'name' => 'New Israeli Shekel',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₪',
        ],
        'INR' => [
            'name' => 'Indian Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₹',
        ],
        'IQD' => [
            'name' => 'Iraqi Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ع.د',
        ],
        'IRR' => [
            'name' => 'Iranian Rial',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '﷼',
        ],
        'ISK' => [
            'name' => 'Iceland Krona',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Kr',
        ],
        'JMD' => [
            'name' => 'Jamaican Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'JOD' => [
            'name' => 'Jordanian Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.ا',
        ],
        'JPY' => [
            'name' => 'Yen',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '¥',
        ],
        'KES' => [
            'name' => 'Kenyan Shilling',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Sh',
        ],
        'KGS' => [
            'name' => 'Som',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '',
        ],
        'KHR' => [
            'name' => 'Riel',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '៛',
        ],
        'KPW' => [
            'name' => 'North Korean Won',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₩',
        ],
        'KRW' => [
            'name' => 'South Korean Won',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₩',
        ],
        'KWD' => [
            'name' => 'Kuwaiti Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.ك',
        ],
        'KYD' => [
            'name' => 'Cayman Islands Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'KZT' => [
            'name' => 'Tenge',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '〒',
        ],
        'LAK' => [
            'name' => 'Kip',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₭',
        ],
        'LBP' => [
            'name' => 'Lebanese Pound',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ل.ل',
        ],
        'LKR' => [
            'name' => 'Sri Lanka Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Rs',
        ],
        'LRD' => [
            'name' => 'Liberian Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'LSL' => [
            'name' => 'Loti',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'L',
        ],
        'LYD' => [
            'name' => 'Libyan Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ل.د',
        ],
        'MAD' => [
            'name' => 'Moroccan Dirham',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.م.',
        ],
        'MDL' => [
            'name' => 'Moldovan Leu',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'L',
        ],
        'MGA' => [
            'name' => 'Malagasy Ariary',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '',
        ],
        'MKD' => [
            'name' => 'Denar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ден',
        ],
        'MMK' => [
            'name' => 'Kyat',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'K',
        ],
        'MNT' => [
            'name' => 'Tugrik',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₮',
        ],
        'MOP' => [
            'name' => 'Pataca',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'P',
        ],
        'MRU' => [
            'name' => 'Ouguiya',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'UM',
        ],
        'MUR' => [
            'name' => 'Mauritius Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₨',
        ],
        'MVR' => [
            'name' => 'Rufiyaa',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ރ.',
        ],
        'MWK' => [
            'name' => 'Kwacha',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'MK',
        ],
        'MXN' => [
            'name' => 'Mexican Peso',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'MYR' => [
            'name' => 'Malaysian Ringgit',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'RM',
        ],
        'MZN' => [
            'name' => 'Metical',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'MTn',
        ],
        'NAD' => [
            'name' => 'Namibia Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'NGN' => [
            'name' => 'Naira',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₦',
        ],
        'NIO' => [
            'name' => 'Cordoba Oro',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'C$',
        ],
        'NOK' => [
            'name' => 'Norwegian Krone',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'kr',
        ],
        'NPR' => [
            'name' => 'Nepalese Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₨',
        ],
        'NZD' => [
            'name' => 'New Zealand Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'OMR' => [
            'name' => 'Rial Omani',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ر.ع.',
        ],
        'PAB' => [
            'name' => 'Balboa',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'B/.',
        ],
        'PEN' => [
            'name' => 'Nuevo Sol',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'S/.',
        ],
        'PGK' => [
            'name' => 'Kina',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'K',
        ],
        'PHP' => [
            'name' => 'Philippine Peso',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₱',
        ],
        'PKR' => [
            'name' => 'Pakistan Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₨',
        ],
        'PLN' => [
            'name' => 'PZloty',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'zł',
        ],
        'PYG' => [
            'name' => 'Guarani',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₲',
        ],
        'QAR' => [
            'name' => 'Qatari Rial',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ر.ق',
        ],
        'RON' => [
            'name' => 'Leu',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'L',
        ],
        'RSD' => [
            'name' => 'Serbian Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'din',
        ],
        'RUB' => [
            'name' => 'Russian Ruble',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'р. ',
        ],
        'RWF' => [
            'name' => 'Rwanda Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'SAR' => [
            'name' => 'Saudi Riyal',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ر.س',
        ],
        'SBD' => [
            'name' => 'Solomon Islands Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'SCR' => [
            'name' => 'Seychelles Rupee',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₨',
        ],
        'SDG' => [
            'name' => 'Sudanese Pound',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'SDG',
        ],
        'SEK' => [
            'name' => 'Swedish Krona',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'kr',
        ],
        'SGD' => [
            'name' => 'Singapore Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'SHP' => [
            'name' => 'Saint Helena Pound',
            'direction' => 'rtl',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'SHP',
        ],
        'SLL' => [
            'name' => 'Leone',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Le',
        ],
        'SOS' => [
            'name' => 'Somali Shilling',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Sh',
        ],
        'SRD' => [
            'name' => 'Suriname Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'STN' => [
            'name' => 'Dobra',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Db',
        ],
        'SYP' => [
            'name' => 'Syrian Pound',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ل.س',
        ],
        'SZL' => [
            'name' => 'Lilangeni',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'L',
        ],
        'THB' => [
            'name' => 'Baht',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '฿',
        ],
        'TJS' => [
            'name' => 'Somoni',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ЅМ',
        ],
        'TMT' => [
            'name' => 'Manat',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'm',
        ],
        'TND' => [
            'name' => 'Tunisian Dinar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'د.ت',
        ],
        'TOP' => [
            'name' => 'Pa’anga',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'T$',
        ],
        'TTD' => [
            'name' => 'Trinidad and Tobago Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'TWD' => [
            'name' => 'Taiwan Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'TZS' => [
            'name' => 'Tanzanian Shilling',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Sh',
        ],
        'UAH' => [
            'name' => 'Hryvnia',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₴',
        ],
        'UGX' => [
            'name' => 'Uganda Shilling',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Sh',
        ],
        'USD' => [
            'name' => 'US Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'UYU' => [
            'name' => 'Peso Uruguayo',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'UZS' => [
            'name' => 'Uzbekistan Sum',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '',
        ],
        'VEF' => [
            'name' => 'Bolivar Fuerte',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Bs F',
        ],
        'VND' => [
            'name' => 'Dong',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₫',
        ],
        'VUV' => [
            'name' => 'Vatu',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'Vt',
        ],
        'WST' => [
            'name' => 'Tala',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'T',
        ],
        'XAF' => [
            'name' => 'CFA Franc BCEAO',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'XCD' => [
            'name' => 'East Caribbean Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',
        ],
        'XPF' => [
            'name' => 'CFP Franc',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '₣',
        ],
        'YER' => [
            'name' => 'Yemeni Rial',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '﷼',
        ],
        'ZAR' => [
            'name' => 'Rand',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'R',
        ],
        'ZMW' => [
            'name' => 'Zambian Kwacha',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => 'ZK',
        ],
        'ZWL' => [
            'name' => 'Zimbabwe Dollar',
            'direction' => 'ltr',
            'separator' => ',',
            'point' => '.',
            'decimals' => 2,
            'symbol' => '$',]


    ]
];