<?php
use App\Models\Countries;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Countries::truncate();

        DB::statement("INSERT INTO `chs_countries` (`id`, `code`, `full_name`, `is_banned`, `datetime_banned`) VALUES
			(1, 'AG', 'ANTIGUA AND BARBUDA', 0, NULL),
			(2, 'BA', 'BOSNIA AND HERZEGOVINA', 0, NULL),
			(3, 'CC', 'COCOS (KEELING) ISLANDS', 0, NULL),
			(4, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 0, NULL),
			(5, 'CI', 'COTE D''IVOIRE', 0, NULL),
			(6, 'FJ', 'FIJI', 0, NULL),
			(7, 'TF', 'FRENCH SOUTHERN TERRITORIES', 0, NULL),
			(8, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 0, NULL),
			(9, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 0, NULL),
			(10, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 0, NULL),
			(11, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 0, NULL),
			(12, 'KR', 'KOREA, REPUBLIC OF', 0, NULL),
			(13, 'BY', 'BELARUS', 0, NULL),
			(14, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 0, NULL),
			(15, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 0, NULL),
			(16, 'US', 'UNITED STATES', 0, NULL),
			(17, 'FM', 'MICRONESIA, FEDERATED STATES OF', 0, NULL),
			(18, 'MD', 'MOLDOVA, REPUBLIC OF', 0, NULL),
			(19, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 0, NULL),
			(20, 'PN', 'PITCAIRN', 0, NULL),
			(21, 'RE', 'REUNION', 0, NULL),
			(22, 'SH', 'SAINT HELENA', 0, NULL),
			(23, 'KN', 'SAINT KITTS AND NEVIS', 0, NULL),
			(24, 'PM', 'SAINT PIERRE AND MIQUELON', 0, NULL),
			(25, 'ST', 'SAO TOME AND PRINCIPE', 0, NULL),
			(26, 'CS', 'SERBIA AND MONTENEGRO', 0, NULL),
			(27, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 0, NULL),
			(28, 'SJ', 'SVALBARD AND JAN MAYEN', 0, NULL),
			(29, 'SY', 'SYRIAN ARAB REPUBLIC', 0, NULL),
			(30, 'TW', 'TAIWAN, PROVINCE OF CHINA', 0, NULL),
			(31, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 0, NULL),
			(32, 'TL', 'TIMOR-LESTE', 0, NULL),
			(33, 'TT', 'TRINIDAD AND TOBAGO', 0, NULL),
			(34, 'MX', 'MEXICO', 0, NULL),
			(35, 'MM', 'MYANMAR', 0, NULL),
			(36, 'VG', 'VIRGIN ISLANDS, BRITISH', 0, NULL),
			(37, 'VI', 'VIRGIN ISLANDS, U.S.', 0, NULL),
			(38, 'WF', 'WALLIS AND FUTUNA', 0, NULL),
			(39, 'AL', 'ALBANIA', 0, NULL),
			(40, 'DZ', 'ALGERIA', 1, '2017-04-06 17:45:20'),
			(41, 'AS', 'AMERICAN SAMOA', 0, NULL),
			(42, 'VU', 'VANUATU', 0, NULL),
			(43, 'YE', 'YEMEN', 0, NULL),
			(44, 'AD', 'ANDORRA', 0, NULL),
			(45, 'AO', 'ANGOLA', 0, NULL),
			(46, 'AI', 'ANGUILLA', 0, NULL),
			(47, 'AR', 'ARGENTINA', 0, NULL),
			(48, 'AM', 'ARMENIA', 0, NULL),
			(49, 'AW', 'ARUBA', 0, NULL),
			(50, 'AU', 'AUSTRALIA', 0, NULL),
			(51, 'AT', 'AUSTRIA', 0, NULL),
			(52, 'AZ', 'AZERBAIJAN', 0, NULL),
			(53, 'BS', 'BAHAMAS', 0, NULL),
			(54, 'BH', 'BAHRAIN', 0, NULL),
			(55, 'BD', 'BANGLADESH', 0, NULL),
			(56, 'BB', 'BARBADOS', 0, NULL),
			(57, 'BE', 'BELGIUM', 0, NULL),
			(58, 'BJ', 'BENIN', 0, NULL),
			(59, 'BM', 'BERMUDA', 0, NULL),
			(60, 'BT', 'BHUTAN', 0, NULL),
			(61, 'BO', 'BOLIVIA', 0, NULL),
			(62, 'BW', 'BOTSWANA', 0, NULL),
			(63, 'BV', 'BOUVET ISLAND', 0, NULL),
			(64, 'BR', 'BRAZIL', 0, NULL),
			(65, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 0, NULL),
			(66, 'BN', 'BRUNEI DARUSSALAM', 0, NULL),
			(67, 'BG', 'BULGARIA', 0, NULL),
			(68, 'BF', 'BURKINA FASO', 0, NULL),
			(69, 'BI', 'BURUNDI', 0, NULL),
			(70, 'KH', 'CAMBODIA', 0, NULL),
			(71, 'CM', 'CAMEROON', 0, NULL),
			(72, 'CA', 'CANADA', 0, NULL),
			(73, 'CV', 'CAPE VERDE', 0, NULL),
			(74, 'MT', 'MALTA', 0, NULL),
			(75, 'KY', 'CAYMAN ISLANDS', 0, NULL),
			(76, 'TD', 'CHAD', 0, NULL),
			(77, 'CL', 'CHILE', 0, NULL),
			(78, 'CN', 'CHINA', 0, NULL),
			(79, 'CX', 'CHRISTMAS ISLAND', 0, NULL),
			(80, 'CO', 'COLOMBIA', 0, NULL),
			(81, 'KM', 'COMOROS', 0, NULL),
			(82, 'CK', 'COOK ISLANDS', 0, NULL),
			(83, 'CR', 'COSTA RICA', 0, NULL),
			(84, 'HR', 'CROATIA', 0, NULL),
			(85, 'CU', 'CUBA', 0, NULL),
			(86, 'CY', 'CYPRUS', 0, NULL),
			(87, 'CZ', 'CZECH REPUBLIC', 0, NULL),
			(88, 'DK', 'DENMARK', 0, NULL),
			(89, 'DJ', 'DJIBOUTI', 0, NULL),
			(90, 'DM', 'DOMINICA', 0, NULL),
			(91, 'DO', 'DOMINICAN REPUBLIC', 0, NULL),
			(92, 'EC', 'ECUADOR', 0, NULL),
			(93, 'EG', 'EGYPT', 0, NULL),
			(94, 'GQ', 'EQUATORIAL GUINEA', 0, NULL),
			(95, 'ER', 'ERITREA', 0, NULL),
			(96, 'EE', 'ESTONIA', 0, NULL),
			(97, 'ET', 'ETHIOPIA', 0, NULL),
			(98, 'FO', 'FAROE ISLANDS', 0, NULL),
			(99, 'FI', 'FINLAND', 0, NULL),
			(100, 'FR', 'FRANCE', 0, NULL),
			(101, 'GF', 'FRENCH GUIANA', 0, NULL),
			(102, 'PF', 'FRENCH POLYNESIA', 0, NULL),
			(103, 'GA', 'GABON', 0, NULL),
			(104, 'GM', 'GAMBIA', 0, NULL),
			(105, 'GE', 'GEORGIA', 0, NULL),
			(106, 'DE', 'GERMANY', 0, NULL),
			(107, 'GH', 'GHANA', 0, NULL),
			(108, 'GI', 'GIBRALTAR', 0, NULL),
			(109, 'GR', 'GREECE', 0, NULL),
			(110, 'GL', 'GREENLAND', 0, NULL),
			(111, 'GD', 'GRENADA', 0, NULL),
			(112, 'GP', 'GUADELOUPE', 0, NULL),
			(113, 'GU', 'GUAM', 0, NULL),
			(114, 'GT', 'GUATEMALA', 0, NULL),
			(115, 'GN', 'GUINEA', 0, NULL),
			(116, 'GW', 'GUINEA-BISSAU', 0, NULL),
			(117, 'GY', 'GUYANA', 0, NULL),
			(118, 'HT', 'HAITI', 0, NULL),
			(119, 'HN', 'HONDURAS', 0, NULL),
			(120, 'HK', 'HONG KONG', 0, NULL),
			(121, 'HU', 'HUNGARY', 0, NULL),
			(122, 'IS', 'ICELAND', 0, NULL),
			(123, 'IN', 'INDIA', 0, NULL),
			(124, 'ID', 'INDONESIA', 0, NULL),
			(125, 'IQ', 'IRAQ', 0, NULL),
			(126, 'IL', 'ISRAEL', 0, NULL),
			(127, 'IT', 'ITALY', 0, NULL),
			(128, 'JM', 'JAMAICA', 0, NULL),
			(129, 'JP', 'JAPAN', 0, NULL),
			(130, 'JO', 'JORDAN', 0, NULL),
			(131, 'KZ', 'KAZAKHSTAN', 0, NULL),
			(132, 'KE', 'KENYA', 0, NULL),
			(133, 'KI', 'KIRIBATI', 0, NULL),
			(134, 'KW', 'KUWAIT', 0, NULL),
			(135, 'KG', 'KYRGYZSTAN', 0, NULL),
			(136, 'LV', 'LATVIA', 0, NULL),
			(137, 'LS', 'LESOTHO', 0, NULL),
			(138, 'LR', 'LIBERIA', 0, NULL),
			(139, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 0, NULL),
			(140, 'LT', 'LITHUANIA', 0, NULL),
			(141, 'LU', 'LUXEMBOURG', 0, NULL),
			(142, 'MO', 'MACAO', 0, NULL),
			(143, 'MG', 'MADAGASCAR', 0, NULL),
			(144, 'MW', 'MALAWI', 0, NULL),
			(145, 'MY', 'MALAYSIA', 0, NULL),
			(146, 'MV', 'MALDIVES', 0, NULL),
			(147, 'ML', 'MALI', 0, NULL),
			(148, 'MH', 'MARSHALL ISLANDS', 0, NULL),
			(149, 'MQ', 'MARTINIQUE', 0, NULL),
			(150, 'MU', 'MAURITIUS', 0, NULL),
			(151, 'YT', 'MAYOTTE', 0, NULL),
			(152, 'MC', 'MONACO', 0, NULL),
			(153, 'MN', 'MONGOLIA', 0, NULL),
			(154, 'MS', 'MONTSERRAT', 0, NULL),
			(155, 'MA', 'MOROCCO', 0, NULL),
			(156, 'MZ', 'MOZAMBIQUE', 0, NULL),
			(157, 'NA', 'NAMIBIA', 0, NULL),
			(158, 'NR', 'NAURU', 0, NULL),
			(159, 'NP', 'NEPAL', 0, NULL),
			(160, 'NL', 'NETHERLANDS', 0, NULL),
			(161, 'NC', 'NEW CALEDONIA', 0, NULL),
			(162, 'NZ', 'NEW ZEALAND', 0, NULL),
			(163, 'NI', 'NICARAGUA', 0, NULL),
			(164, 'NE', 'NIGER', 0, NULL),
			(165, 'NG', 'NIGERIA', 0, NULL),
			(166, 'NU', 'NIUE', 0, NULL),
			(167, 'NF', 'NORFOLK ISLAND', 0, NULL),
			(168, 'MP', 'NORTHERN MARIANA ISLANDS', 0, NULL),
			(169, 'NO', 'NORWAY', 0, NULL),
			(170, 'OM', 'OMAN', 0, NULL),
			(171, 'PK', 'PAKISTAN', 0, NULL),
			(172, 'PW', 'PALAU', 0, NULL),
			(173, 'PA', 'PANAMA', 0, NULL),
			(174, 'PY', 'PARAGUAY', 0, NULL),
			(175, 'PE', 'PERU', 0, NULL),
			(176, 'PH', 'PHILIPPINES', 0, NULL),
			(177, 'PL', 'POLAND', 0, NULL),
			(178, 'PT', 'PORTUGAL', 0, NULL),
			(179, 'PR', 'PUERTO RICO', 0, NULL),
			(180, 'QA', 'QATAR', 0, NULL),
			(181, 'RO', 'ROMANIA', 0, NULL),
			(182, 'RU', 'RUSSIAN FEDERATION', 0, NULL),
			(183, 'RW', 'RWANDA', 0, NULL),
			(184, 'LC', 'SAINT LUCIA', 0, NULL),
			(185, 'VC', 'SAINT VINCENT AND THE GRENADINES', 0, NULL),
			(186, 'WS', 'SAMOA', 0, NULL),
			(187, 'SM', 'SAN MARINO', 0, NULL),
			(188, 'SN', 'SENEGAL', 0, NULL),
			(189, 'SC', 'SEYCHELLES', 0, NULL),
			(190, 'SL', 'SIERRA LEONE', 0, NULL),
			(191, 'SG', 'SINGAPORE', 0, NULL),
			(192, 'SK', 'SLOVAKIA', 0, NULL),
			(193, 'SI', 'SLOVENIA', 0, NULL),
			(194, 'SB', 'SOLOMON ISLANDS', 0, NULL),
			(195, 'SO', 'SOMALIA', 0, NULL),
			(196, 'ZA', 'SOUTH AFRICA', 0, NULL),
			(197, 'ES', 'SPAIN', 0, NULL),
			(198, 'LK', 'SRI LANKA', 0, NULL),
			(199, 'SD', 'SUDAN', 0, NULL),
			(200, 'SR', 'SURINAME', 0, NULL),
			(201, 'SZ', 'SWAZILAND', 0, NULL),
			(202, 'SE', 'SWEDEN', 0, NULL),
			(203, 'CH', 'SWITZERLAND', 0, NULL),
			(204, 'TH', 'THAILAND', 0, NULL),
			(205, 'TG', 'TOGO', 0, NULL),
			(206, 'TK', 'TOKELAU', 0, NULL),
			(207, 'TO', 'TONGA', 0, NULL),
			(208, 'TN', 'TUNISIA', 0, NULL),
			(209, 'TR', 'TURKEY', 0, NULL),
			(210, 'TM', 'TURKMENISTAN', 0, NULL),
			(211, 'TC', 'TURKS AND CAICOS ISLANDS', 0, NULL),
			(212, 'TV', 'TUVALU', 0, NULL),
			(213, 'UG', 'UGANDA', 0, NULL),
			(214, 'UA', 'UKRAINE', 0, NULL),
			(215, 'GB', 'UNITED KINGDOM', 0, NULL),
			(216, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 0, NULL),
			(217, 'UY', 'URUGUAY', 0, NULL),
			(218, 'UZ', 'UZBEKISTAN', 0, NULL),
			(219, 'VE', 'VENEZUELA', 0, NULL),
			(220, 'VN', 'VIET NAM', 0, NULL),
			(221, 'EH', 'WESTERN SAHARA', 0, NULL),
			(222, 'ZM', 'ZAMBIA', 0, NULL),
			(223, 'ZW', 'ZIMBABWE', 1, '2017-04-12 00:00:00'),
			(224, 'AQ', 'ANTARCTICA', 0, NULL),
			(225, 'BZ', 'BELIZE', 0, NULL),
			(226, 'CF', 'CENTRAL AFRICAN REPUBLIC', 0, NULL),
			(227, 'SV', 'EL SALVADOR', 0, NULL),
			(228, 'IE', 'IRELAND', 0, NULL),
			(229, 'LB', 'LEBANON', 0, NULL),
			(230, 'LI', 'LIECHTENSTEIN', 0, NULL),
			(231, 'MR', 'MAURITANIA', 0, NULL),
			(232, 'AF', 'AFGHANISTAN', 0, NULL),
			(233, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 0, NULL),
			(234, 'AN', 'NETHERLANDS ANTILLES', 0, NULL),
			(235, 'CG', 'CONGO', 0, NULL),
			(236, 'PG', 'PAPUA NEW GUINEA', 0, NULL),
			(237, 'SA', 'SAUDI ARABIA', 0, NULL),
			(238, 'TJ', 'TAJIKISTAN', 0, NULL),
			(239, 'AE', 'UNITED ARAB EMIRATES', 0, NULL);");
    }
}