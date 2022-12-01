<?php

namespace App\Collections;

use App\Types\Model;
use App\Types\Collection;

class LanguageCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => 1,   'code' => 'OM', 'flag' => '🇺🇳', 'name' => 'Afan'],
            (object) ['id' => 2,   'code' => 'AB', 'flag' => '🇺🇳', 'name' => 'Abkhazian'],
            (object) ['id' => 3,   'code' => 'AA', 'flag' => '🇩🇯', 'name' => 'Afar'],
            (object) ['id' => 4,   'code' => 'AF', 'flag' => '🇿🇦', 'name' => 'Afrikaans'],
            (object) ['id' => 5,   'code' => 'SQ', 'flag' => '🇦🇱', 'name' => 'Albanian'],
            (object) ['id' => 6,   'code' => 'AM', 'flag' => '🇪🇹', 'name' => 'Amharic'],
            (object) ['id' => 7,   'code' => 'AR', 'flag' => '🇺🇳', 'name' => 'Arabic'],
            (object) ['id' => 8,   'code' => 'HY', 'flag' => '🇦🇲', 'name' => 'Armenian'],
            (object) ['id' => 9,   'code' => 'AS', 'flag' => '🇺🇳', 'name' => 'Assamese'],
            (object) ['id' => 10,  'code' => 'AY', 'flag' => '🇺🇳', 'name' => 'Aymara'],
            (object) ['id' => 11,  'code' => 'AZ', 'flag' => '🇦🇿', 'name' => 'Azerbaijani'],
            (object) ['id' => 12,  'code' => 'BA', 'flag' => '🇺🇳', 'name' => 'Bashkir'],
            (object) ['id' => 13,  'code' => 'EU', 'flag' => '🇪🇸', 'name' => 'Basque'],
            (object) ['id' => 14,  'code' => 'BE', 'flag' => '🇧🇾', 'name' => 'Belarusian'],
            (object) ['id' => 15,  'code' => 'BN', 'flag' => '🇧🇩', 'name' => 'Bengali / Bangla'],
            (object) ['id' => 16,  'code' => 'DZ', 'flag' => '🇧🇹', 'name' => 'Bhutani'],
            (object) ['id' => 17,  'code' => 'BH', 'flag' => '🇺🇳', 'name' => 'Bihari'],
            (object) ['id' => 18,  'code' => 'BI', 'flag' => '🇻🇺', 'name' => 'Bislama'],
            (object) ['id' => 19,  'code' => 'BR', 'flag' => '🇺🇳', 'name' => 'Breton'],
            (object) ['id' => 20,  'code' => 'BG', 'flag' => '🇧🇬', 'name' => 'Bulgarian'],
            (object) ['id' => 21,  'code' => 'MY', 'flag' => '🇲🇲', 'name' => 'Burmese'],
            (object) ['id' => 22,  'code' => 'KM', 'flag' => '🇰🇭', 'name' => 'Cambodian'],
            (object) ['id' => 23,  'code' => 'CA', 'flag' => '🇦🇩', 'name' => 'Catalan'],
            (object) ['id' => 24,  'code' => 'ZH', 'flag' => '🇨🇳', 'name' => 'Chinese'],
            (object) ['id' => 25,  'code' => 'CO', 'flag' => '🇺🇳', 'name' => 'Corsican'],
            (object) ['id' => 26,  'code' => 'HR', 'flag' => '🇭🇷', 'name' => 'Croatian'],
            (object) ['id' => 27,  'code' => 'CS', 'flag' => '🇨🇿', 'name' => 'Czech'],
            (object) ['id' => 28,  'code' => 'DA', 'flag' => '🇩🇰', 'name' => 'Danish'],
            (object) ['id' => 29,  'code' => 'NL', 'flag' => '🇳🇱', 'name' => 'Dutch'],
            (object) ['id' => 30,  'code' => 'EN', 'flag' => '🇬🇧', 'name' => 'English'],
            (object) ['id' => 31,  'code' => 'EO', 'flag' => '🇺🇳', 'name' => 'Esperanto'],
            (object) ['id' => 32,  'code' => 'ET', 'flag' => '🇪🇪', 'name' => 'Estonian'],
            (object) ['id' => 33,  'code' => 'FO', 'flag' => '🇺🇳', 'name' => 'Faeroese'],
            (object) ['id' => 34,  'code' => 'FJ', 'flag' => '🇫🇯', 'name' => 'Fiji'],
            (object) ['id' => 35,  'code' => 'FI', 'flag' => '🇫🇮', 'name' => 'Finnish'],
            (object) ['id' => 36,  'code' => 'FR', 'flag' => '🇫🇷', 'name' => 'French'],
            (object) ['id' => 37,  'code' => 'FY', 'flag' => '🇺🇳', 'name' => 'Frisian'],
            (object) ['id' => 38,  'code' => 'GL', 'flag' => '🇺🇳', 'name' => 'Galician'],
            (object) ['id' => 39,  'code' => 'KA', 'flag' => '🇬🇪', 'name' => 'Georgian'],
            (object) ['id' => 40,  'code' => 'DE', 'flag' => '🇩🇪', 'name' => 'German'],
            (object) ['id' => 41,  'code' => 'EL', 'flag' => '🇬🇷', 'name' => 'Greek'],
            (object) ['id' => 42,  'code' => 'KL', 'flag' => '🇺🇳', 'name' => 'Greenlandic'],
            (object) ['id' => 43,  'code' => 'GN', 'flag' => '🇺🇳', 'name' => 'Guarani'],
            (object) ['id' => 44,  'code' => 'GU', 'flag' => '🇮🇳', 'name' => 'Gujarati'],
            (object) ['id' => 45,  'code' => 'HA', 'flag' => '🇺🇳', 'name' => 'Hausa'],
            (object) ['id' => 46,  'code' => 'IW', 'flag' => '🇮🇱', 'name' => 'Hebrew'],
            (object) ['id' => 47,  'code' => 'HI', 'flag' => '🇮🇳', 'name' => 'Hindi'],
            (object) ['id' => 48,  'code' => 'HU', 'flag' => '🇭🇺', 'name' => 'Hungarian'],
            (object) ['id' => 49,  'code' => 'IS', 'flag' => '🇮🇸', 'name' => 'Icelandic'],
            (object) ['id' => 50,  'code' => 'IN', 'flag' => '🇮🇩', 'name' => 'Indonesian'],
            (object) ['id' => 51,  'code' => 'IA', 'flag' => '🇺🇳', 'name' => 'Interlingua'],
            (object) ['id' => 52,  'code' => 'IE', 'flag' => '🇺🇳', 'name' => 'Interlingue'],
            (object) ['id' => 53,  'code' => 'IK', 'flag' => '🇺🇳', 'name' => 'Inupiak'],
            (object) ['id' => 54,  'code' => 'GA', 'flag' => '🇮🇪', 'name' => 'Irish'],
            (object) ['id' => 55,  'code' => 'IT', 'flag' => '🇮🇹', 'name' => 'Italian'],
            (object) ['id' => 56,  'code' => 'JA', 'flag' => '🇯🇵', 'name' => 'Japanese'],
            (object) ['id' => 57,  'code' => 'JW', 'flag' => '🇺🇳', 'name' => 'Javanese'],
            (object) ['id' => 58,  'code' => 'KN', 'flag' => '🇺🇳', 'name' => 'Kannada'],
            (object) ['id' => 59,  'code' => 'KS', 'flag' => '🇮🇳', 'name' => 'Kashmiri'],
            (object) ['id' => 60,  'code' => 'KK', 'flag' => '🇰🇿', 'name' => 'Kazakh'],
            (object) ['id' => 61,  'code' => 'RW', 'flag' => '🇷🇼', 'name' => 'Kinyarwanda'],
            (object) ['id' => 62,  'code' => 'KY', 'flag' => '🇰🇬', 'name' => 'Kirghiz'],
            (object) ['id' => 63,  'code' => 'RN', 'flag' => '🇧🇮', 'name' => 'Kirundi'],
            (object) ['id' => 64,  'code' => 'KO', 'flag' => '🇰🇷', 'name' => 'Korean'],
            (object) ['id' => 65,  'code' => 'KU', 'flag' => '🇮🇶', 'name' => 'Kurdish'],
            (object) ['id' => 66,  'code' => 'LO', 'flag' => '🇱🇦', 'name' => 'Laothian'],
            (object) ['id' => 67,  'code' => 'LA', 'flag' => '🇻🇦', 'name' => 'Latin'],
            (object) ['id' => 68,  'code' => 'LV', 'flag' => '🇱🇻', 'name' => 'Latvian / Lettish'],
            (object) ['id' => 69,  'code' => 'LN', 'flag' => '🇨🇬', 'name' => 'Lingala'],
            (object) ['id' => 70,  'code' => 'LT', 'flag' => '🇱🇹', 'name' => 'Lithuanian'],
            (object) ['id' => 71,  'code' => 'MK', 'flag' => '🇲🇰', 'name' => 'Macedonian'],
            (object) ['id' => 72,  'code' => 'MG', 'flag' => '🇲🇬', 'name' => 'Malagasy'],
            (object) ['id' => 73,  'code' => 'MS', 'flag' => '🇲🇾', 'name' => 'Malay'],
            (object) ['id' => 74,  'code' => 'ML', 'flag' => '🇺🇳', 'name' => 'Malayalam'],
            (object) ['id' => 75,  'code' => 'MT', 'flag' => '🇲🇹', 'name' => 'Maltese'],
            (object) ['id' => 76,  'code' => 'MI', 'flag' => '🇳🇿', 'name' => 'Maori'],
            (object) ['id' => 77,  'code' => 'MR', 'flag' => '🇺🇳', 'name' => 'Marathi'],
            (object) ['id' => 78,  'code' => 'MO', 'flag' => '🇲🇩', 'name' => 'Moldavian'],
            (object) ['id' => 79,  'code' => 'MN', 'flag' => '🇲🇳', 'name' => 'Mongolian'],
            (object) ['id' => 80,  'code' => 'NA', 'flag' => '🇺🇳', 'name' => 'Nauru'],
            (object) ['id' => 81,  'code' => 'NE', 'flag' => '🇳🇵', 'name' => 'Nepali'],
            (object) ['id' => 82,  'code' => 'NO', 'flag' => '🇳🇴', 'name' => 'Norwegian'],
            (object) ['id' => 83,  'code' => 'OC', 'flag' => '🇺🇳', 'name' => 'Occitan'],
            (object) ['id' => 84,  'code' => 'PS', 'flag' => '🇦🇫', 'name' => 'Pashto / Pushto'],
            (object) ['id' => 85,  'code' => 'FA', 'flag' => '🇮🇷', 'name' => 'Persian'],
            (object) ['id' => 86,  'code' => 'PL', 'flag' => '🇵🇱', 'name' => 'Polish'],
            (object) ['id' => 87,  'code' => 'PT', 'flag' => '🇵🇹', 'name' => 'Portuguese'],
            (object) ['id' => 88,  'code' => 'PA', 'flag' => '🇮🇳', 'name' => 'Punjabi'],
            (object) ['id' => 89,  'code' => 'QU', 'flag' => '🇺🇳', 'name' => 'Quechua'],
            (object) ['id' => 90,  'code' => 'RM', 'flag' => '🇨🇭', 'name' => 'Rhaeto-Romance'],
            (object) ['id' => 91,  'code' => 'RO', 'flag' => '🇷🇴', 'name' => 'Romanian'],
            (object) ['id' => 92,  'code' => 'RU', 'flag' => '🇷🇺', 'name' => 'Russian'],
            (object) ['id' => 93,  'code' => 'SM', 'flag' => '🇺🇳', 'name' => 'Samoan'],
            (object) ['id' => 94,  'code' => 'SG', 'flag' => '🇨🇫', 'name' => 'Sangro'],
            (object) ['id' => 95,  'code' => 'SA', 'flag' => '🇺🇳', 'name' => 'Sanskrit'],
            (object) ['id' => 96,  'code' => 'GD', 'flag' => '🏴󠁧󠁢󠁳󠁣󠁴󠁿', 'name' => 'Scots / Gaelic'],
            (object) ['id' => 97,  'code' => 'SR', 'flag' => '🇷🇸', 'name' => 'Serbian'],
            (object) ['id' => 98,  'code' => 'SH', 'flag' => '🇺🇳', 'name' => 'Serbo-Croatian'],
            (object) ['id' => 99,  'code' => 'ST', 'flag' => '🇱🇸', 'name' => 'Sesotho'],
            (object) ['id' => 100, 'code' => 'TN', 'flag' => '🇧🇼', 'name' => 'Setswana'],
            (object) ['id' => 101, 'code' => 'SN', 'flag' => '🇿🇼', 'name' => 'Shona'],
            (object) ['id' => 102, 'code' => 'SD', 'flag' => '🇺🇳', 'name' => 'Sindhi'],
            (object) ['id' => 103, 'code' => 'SI', 'flag' => '🇱🇰', 'name' => 'Singhalese'],
            (object) ['id' => 104, 'code' => 'SS', 'flag' => '🇸🇿', 'name' => 'Siswati'],
            (object) ['id' => 105, 'code' => 'SK', 'flag' => '🇸🇰', 'name' => 'Slovak'],
            (object) ['id' => 106, 'code' => 'SL', 'flag' => '🇸🇮', 'name' => 'Slovenian'],
            (object) ['id' => 107, 'code' => 'SO', 'flag' => '🇸🇴', 'name' => 'Somali'],
            (object) ['id' => 108, 'code' => 'ES', 'flag' => '🇪🇸', 'name' => 'Spanish'],
            (object) ['id' => 109, 'code' => 'SU', 'flag' => '🇺🇳', 'name' => 'Sundanese'],
            (object) ['id' => 110, 'code' => 'SW', 'flag' => '🇺🇳', 'name' => 'Swahili'],
            (object) ['id' => 111, 'code' => 'SV', 'flag' => '🇸🇪', 'name' => 'Swedish'],
            (object) ['id' => 112, 'code' => 'TL', 'flag' => '🇵🇭', 'name' => 'Tagalog'],
            (object) ['id' => 113, 'code' => 'TG', 'flag' => '🇹🇯', 'name' => 'Tajik'],
            (object) ['id' => 114, 'code' => 'TA', 'flag' => '🇱🇰', 'name' => 'Tamil'],
            (object) ['id' => 115, 'code' => 'TT', 'flag' => '🇺🇳', 'name' => 'Tatar'],
            (object) ['id' => 116, 'code' => 'TE', 'flag' => '🇮🇳', 'name' => 'Telugu'],
            (object) ['id' => 117, 'code' => 'TH', 'flag' => '🇹🇭', 'name' => 'Thai'],
            (object) ['id' => 118, 'code' => 'BO', 'flag' => '🇺🇳', 'name' => 'Tibetan'],
            (object) ['id' => 119, 'code' => 'TI', 'flag' => '🇪🇷', 'name' => 'Tigrinya'],
            (object) ['id' => 120, 'code' => 'TO', 'flag' => '🇺🇳', 'name' => 'Tonga'],
            (object) ['id' => 121, 'code' => 'TS', 'flag' => '🇿🇦', 'name' => 'Tsonga'],
            (object) ['id' => 122, 'code' => 'TR', 'flag' => '🇹🇷', 'name' => 'Turkish'],
            (object) ['id' => 123, 'code' => 'TK', 'flag' => '🇹🇲', 'name' => 'Turkmen'],
            (object) ['id' => 124, 'code' => 'TW', 'flag' => '🇺🇳', 'name' => 'Twi'],
            (object) ['id' => 125, 'code' => 'UK', 'flag' => '🇺🇦', 'name' => 'Ukrainian'],
            (object) ['id' => 127, 'code' => 'UR', 'flag' => '🇵🇰', 'name' => 'Urdu'],
            (object) ['id' => 128, 'code' => 'UZ', 'flag' => '🇺🇿', 'name' => 'Uzbek'],
            (object) ['id' => 129, 'code' => 'VI', 'flag' => '🇻🇳', 'name' => 'Vietnamese'],
            (object) ['id' => 130, 'code' => 'VO', 'flag' => '🇺🇳', 'name' => 'Volapuk'],
            (object) ['id' => 131, 'code' => 'CY', 'flag' => '🏴󠁧󠁢󠁷󠁬󠁳󠁿', 'name' => 'Welsh'],
            (object) ['id' => 132, 'code' => 'WO', 'flag' => '🇸🇳', 'name' => 'Wolof'],
            (object) ['id' => 133, 'code' => 'XH', 'flag' => '🇿🇦', 'name' => 'Xhosa'],
            (object) ['id' => 134, 'code' => 'JI', 'flag' => '🇮🇱', 'name' => 'Yiddish'],
            (object) ['id' => 135, 'code' => 'YO', 'flag' => '🇺🇳', 'name' => 'Yoruba'],
            (object) ['id' => 136, 'code' => 'ZU', 'flag' => '🇿🇦', 'name' => 'Zulu'],
        ];
    }

    /**
     * Generate a comma-separated list of languages used by the given model.
     *
     */
    public static function list(Model $model) : string
    {
        $fields = [
            'first_language',
            'second_language',
            'third_language',
        ];

        return collect($model->only($fields))
            ->filter(fn($item) => $item)
            ->map(fn($item)    => static::find($item)->name)
            ->implode(', ');
    }
}
