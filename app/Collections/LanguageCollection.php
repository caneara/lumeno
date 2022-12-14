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
            (object) ['id' => 1,   'code' => 'OM', 'flag' => 'πΊπ³', 'name' => 'Afan'],
            (object) ['id' => 2,   'code' => 'AB', 'flag' => 'πΊπ³', 'name' => 'Abkhazian'],
            (object) ['id' => 3,   'code' => 'AA', 'flag' => 'π©π―', 'name' => 'Afar'],
            (object) ['id' => 4,   'code' => 'AF', 'flag' => 'πΏπ¦', 'name' => 'Afrikaans'],
            (object) ['id' => 5,   'code' => 'SQ', 'flag' => 'π¦π±', 'name' => 'Albanian'],
            (object) ['id' => 6,   'code' => 'AM', 'flag' => 'πͺπΉ', 'name' => 'Amharic'],
            (object) ['id' => 7,   'code' => 'AR', 'flag' => 'πΊπ³', 'name' => 'Arabic'],
            (object) ['id' => 8,   'code' => 'HY', 'flag' => 'π¦π²', 'name' => 'Armenian'],
            (object) ['id' => 9,   'code' => 'AS', 'flag' => 'πΊπ³', 'name' => 'Assamese'],
            (object) ['id' => 10,  'code' => 'AY', 'flag' => 'πΊπ³', 'name' => 'Aymara'],
            (object) ['id' => 11,  'code' => 'AZ', 'flag' => 'π¦πΏ', 'name' => 'Azerbaijani'],
            (object) ['id' => 12,  'code' => 'BA', 'flag' => 'πΊπ³', 'name' => 'Bashkir'],
            (object) ['id' => 13,  'code' => 'EU', 'flag' => 'πͺπΈ', 'name' => 'Basque'],
            (object) ['id' => 14,  'code' => 'BE', 'flag' => 'π§πΎ', 'name' => 'Belarusian'],
            (object) ['id' => 15,  'code' => 'BN', 'flag' => 'π§π©', 'name' => 'Bengali / Bangla'],
            (object) ['id' => 16,  'code' => 'DZ', 'flag' => 'π§πΉ', 'name' => 'Bhutani'],
            (object) ['id' => 17,  'code' => 'BH', 'flag' => 'πΊπ³', 'name' => 'Bihari'],
            (object) ['id' => 18,  'code' => 'BI', 'flag' => 'π»πΊ', 'name' => 'Bislama'],
            (object) ['id' => 19,  'code' => 'BR', 'flag' => 'πΊπ³', 'name' => 'Breton'],
            (object) ['id' => 20,  'code' => 'BG', 'flag' => 'π§π¬', 'name' => 'Bulgarian'],
            (object) ['id' => 21,  'code' => 'MY', 'flag' => 'π²π²', 'name' => 'Burmese'],
            (object) ['id' => 22,  'code' => 'KM', 'flag' => 'π°π­', 'name' => 'Cambodian'],
            (object) ['id' => 23,  'code' => 'CA', 'flag' => 'π¦π©', 'name' => 'Catalan'],
            (object) ['id' => 24,  'code' => 'ZH', 'flag' => 'π¨π³', 'name' => 'Chinese'],
            (object) ['id' => 25,  'code' => 'CO', 'flag' => 'πΊπ³', 'name' => 'Corsican'],
            (object) ['id' => 26,  'code' => 'HR', 'flag' => 'π­π·', 'name' => 'Croatian'],
            (object) ['id' => 27,  'code' => 'CS', 'flag' => 'π¨πΏ', 'name' => 'Czech'],
            (object) ['id' => 28,  'code' => 'DA', 'flag' => 'π©π°', 'name' => 'Danish'],
            (object) ['id' => 29,  'code' => 'NL', 'flag' => 'π³π±', 'name' => 'Dutch'],
            (object) ['id' => 30,  'code' => 'EN', 'flag' => 'π¬π§', 'name' => 'English'],
            (object) ['id' => 31,  'code' => 'EO', 'flag' => 'πΊπ³', 'name' => 'Esperanto'],
            (object) ['id' => 32,  'code' => 'ET', 'flag' => 'πͺπͺ', 'name' => 'Estonian'],
            (object) ['id' => 33,  'code' => 'FO', 'flag' => 'πΊπ³', 'name' => 'Faeroese'],
            (object) ['id' => 34,  'code' => 'FJ', 'flag' => 'π«π―', 'name' => 'Fiji'],
            (object) ['id' => 35,  'code' => 'FI', 'flag' => 'π«π?', 'name' => 'Finnish'],
            (object) ['id' => 36,  'code' => 'FR', 'flag' => 'π«π·', 'name' => 'French'],
            (object) ['id' => 37,  'code' => 'FY', 'flag' => 'πΊπ³', 'name' => 'Frisian'],
            (object) ['id' => 38,  'code' => 'GL', 'flag' => 'πΊπ³', 'name' => 'Galician'],
            (object) ['id' => 39,  'code' => 'KA', 'flag' => 'π¬πͺ', 'name' => 'Georgian'],
            (object) ['id' => 40,  'code' => 'DE', 'flag' => 'π©πͺ', 'name' => 'German'],
            (object) ['id' => 41,  'code' => 'EL', 'flag' => 'π¬π·', 'name' => 'Greek'],
            (object) ['id' => 42,  'code' => 'KL', 'flag' => 'πΊπ³', 'name' => 'Greenlandic'],
            (object) ['id' => 43,  'code' => 'GN', 'flag' => 'πΊπ³', 'name' => 'Guarani'],
            (object) ['id' => 44,  'code' => 'GU', 'flag' => 'π?π³', 'name' => 'Gujarati'],
            (object) ['id' => 45,  'code' => 'HA', 'flag' => 'πΊπ³', 'name' => 'Hausa'],
            (object) ['id' => 46,  'code' => 'IW', 'flag' => 'π?π±', 'name' => 'Hebrew'],
            (object) ['id' => 47,  'code' => 'HI', 'flag' => 'π?π³', 'name' => 'Hindi'],
            (object) ['id' => 48,  'code' => 'HU', 'flag' => 'π­πΊ', 'name' => 'Hungarian'],
            (object) ['id' => 49,  'code' => 'IS', 'flag' => 'π?πΈ', 'name' => 'Icelandic'],
            (object) ['id' => 50,  'code' => 'IN', 'flag' => 'π?π©', 'name' => 'Indonesian'],
            (object) ['id' => 51,  'code' => 'IA', 'flag' => 'πΊπ³', 'name' => 'Interlingua'],
            (object) ['id' => 52,  'code' => 'IE', 'flag' => 'πΊπ³', 'name' => 'Interlingue'],
            (object) ['id' => 53,  'code' => 'IK', 'flag' => 'πΊπ³', 'name' => 'Inupiak'],
            (object) ['id' => 54,  'code' => 'GA', 'flag' => 'π?πͺ', 'name' => 'Irish'],
            (object) ['id' => 55,  'code' => 'IT', 'flag' => 'π?πΉ', 'name' => 'Italian'],
            (object) ['id' => 56,  'code' => 'JA', 'flag' => 'π―π΅', 'name' => 'Japanese'],
            (object) ['id' => 57,  'code' => 'JW', 'flag' => 'πΊπ³', 'name' => 'Javanese'],
            (object) ['id' => 58,  'code' => 'KN', 'flag' => 'πΊπ³', 'name' => 'Kannada'],
            (object) ['id' => 59,  'code' => 'KS', 'flag' => 'π?π³', 'name' => 'Kashmiri'],
            (object) ['id' => 60,  'code' => 'KK', 'flag' => 'π°πΏ', 'name' => 'Kazakh'],
            (object) ['id' => 61,  'code' => 'RW', 'flag' => 'π·πΌ', 'name' => 'Kinyarwanda'],
            (object) ['id' => 62,  'code' => 'KY', 'flag' => 'π°π¬', 'name' => 'Kirghiz'],
            (object) ['id' => 63,  'code' => 'RN', 'flag' => 'π§π?', 'name' => 'Kirundi'],
            (object) ['id' => 64,  'code' => 'KO', 'flag' => 'π°π·', 'name' => 'Korean'],
            (object) ['id' => 65,  'code' => 'KU', 'flag' => 'π?πΆ', 'name' => 'Kurdish'],
            (object) ['id' => 66,  'code' => 'LO', 'flag' => 'π±π¦', 'name' => 'Laothian'],
            (object) ['id' => 67,  'code' => 'LA', 'flag' => 'π»π¦', 'name' => 'Latin'],
            (object) ['id' => 68,  'code' => 'LV', 'flag' => 'π±π»', 'name' => 'Latvian / Lettish'],
            (object) ['id' => 69,  'code' => 'LN', 'flag' => 'π¨π¬', 'name' => 'Lingala'],
            (object) ['id' => 70,  'code' => 'LT', 'flag' => 'π±πΉ', 'name' => 'Lithuanian'],
            (object) ['id' => 71,  'code' => 'MK', 'flag' => 'π²π°', 'name' => 'Macedonian'],
            (object) ['id' => 72,  'code' => 'MG', 'flag' => 'π²π¬', 'name' => 'Malagasy'],
            (object) ['id' => 73,  'code' => 'MS', 'flag' => 'π²πΎ', 'name' => 'Malay'],
            (object) ['id' => 74,  'code' => 'ML', 'flag' => 'πΊπ³', 'name' => 'Malayalam'],
            (object) ['id' => 75,  'code' => 'MT', 'flag' => 'π²πΉ', 'name' => 'Maltese'],
            (object) ['id' => 76,  'code' => 'MI', 'flag' => 'π³πΏ', 'name' => 'Maori'],
            (object) ['id' => 77,  'code' => 'MR', 'flag' => 'πΊπ³', 'name' => 'Marathi'],
            (object) ['id' => 78,  'code' => 'MO', 'flag' => 'π²π©', 'name' => 'Moldavian'],
            (object) ['id' => 79,  'code' => 'MN', 'flag' => 'π²π³', 'name' => 'Mongolian'],
            (object) ['id' => 80,  'code' => 'NA', 'flag' => 'πΊπ³', 'name' => 'Nauru'],
            (object) ['id' => 81,  'code' => 'NE', 'flag' => 'π³π΅', 'name' => 'Nepali'],
            (object) ['id' => 82,  'code' => 'NO', 'flag' => 'π³π΄', 'name' => 'Norwegian'],
            (object) ['id' => 83,  'code' => 'OC', 'flag' => 'πΊπ³', 'name' => 'Occitan'],
            (object) ['id' => 84,  'code' => 'PS', 'flag' => 'π¦π«', 'name' => 'Pashto / Pushto'],
            (object) ['id' => 85,  'code' => 'FA', 'flag' => 'π?π·', 'name' => 'Persian'],
            (object) ['id' => 86,  'code' => 'PL', 'flag' => 'π΅π±', 'name' => 'Polish'],
            (object) ['id' => 87,  'code' => 'PT', 'flag' => 'π΅πΉ', 'name' => 'Portuguese'],
            (object) ['id' => 88,  'code' => 'PA', 'flag' => 'π?π³', 'name' => 'Punjabi'],
            (object) ['id' => 89,  'code' => 'QU', 'flag' => 'πΊπ³', 'name' => 'Quechua'],
            (object) ['id' => 90,  'code' => 'RM', 'flag' => 'π¨π­', 'name' => 'Rhaeto-Romance'],
            (object) ['id' => 91,  'code' => 'RO', 'flag' => 'π·π΄', 'name' => 'Romanian'],
            (object) ['id' => 92,  'code' => 'RU', 'flag' => 'π·πΊ', 'name' => 'Russian'],
            (object) ['id' => 93,  'code' => 'SM', 'flag' => 'πΊπ³', 'name' => 'Samoan'],
            (object) ['id' => 94,  'code' => 'SG', 'flag' => 'π¨π«', 'name' => 'Sangro'],
            (object) ['id' => 95,  'code' => 'SA', 'flag' => 'πΊπ³', 'name' => 'Sanskrit'],
            (object) ['id' => 96,  'code' => 'GD', 'flag' => 'π΄σ §σ ’σ ³σ £σ ΄σ Ώ', 'name' => 'Scots / Gaelic'],
            (object) ['id' => 97,  'code' => 'SR', 'flag' => 'π·πΈ', 'name' => 'Serbian'],
            (object) ['id' => 98,  'code' => 'SH', 'flag' => 'πΊπ³', 'name' => 'Serbo-Croatian'],
            (object) ['id' => 99,  'code' => 'ST', 'flag' => 'π±πΈ', 'name' => 'Sesotho'],
            (object) ['id' => 100, 'code' => 'TN', 'flag' => 'π§πΌ', 'name' => 'Setswana'],
            (object) ['id' => 101, 'code' => 'SN', 'flag' => 'πΏπΌ', 'name' => 'Shona'],
            (object) ['id' => 102, 'code' => 'SD', 'flag' => 'πΊπ³', 'name' => 'Sindhi'],
            (object) ['id' => 103, 'code' => 'SI', 'flag' => 'π±π°', 'name' => 'Singhalese'],
            (object) ['id' => 104, 'code' => 'SS', 'flag' => 'πΈπΏ', 'name' => 'Siswati'],
            (object) ['id' => 105, 'code' => 'SK', 'flag' => 'πΈπ°', 'name' => 'Slovak'],
            (object) ['id' => 106, 'code' => 'SL', 'flag' => 'πΈπ?', 'name' => 'Slovenian'],
            (object) ['id' => 107, 'code' => 'SO', 'flag' => 'πΈπ΄', 'name' => 'Somali'],
            (object) ['id' => 108, 'code' => 'ES', 'flag' => 'πͺπΈ', 'name' => 'Spanish'],
            (object) ['id' => 109, 'code' => 'SU', 'flag' => 'πΊπ³', 'name' => 'Sundanese'],
            (object) ['id' => 110, 'code' => 'SW', 'flag' => 'πΊπ³', 'name' => 'Swahili'],
            (object) ['id' => 111, 'code' => 'SV', 'flag' => 'πΈπͺ', 'name' => 'Swedish'],
            (object) ['id' => 112, 'code' => 'TL', 'flag' => 'π΅π­', 'name' => 'Tagalog'],
            (object) ['id' => 113, 'code' => 'TG', 'flag' => 'πΉπ―', 'name' => 'Tajik'],
            (object) ['id' => 114, 'code' => 'TA', 'flag' => 'π±π°', 'name' => 'Tamil'],
            (object) ['id' => 115, 'code' => 'TT', 'flag' => 'πΊπ³', 'name' => 'Tatar'],
            (object) ['id' => 116, 'code' => 'TE', 'flag' => 'π?π³', 'name' => 'Telugu'],
            (object) ['id' => 117, 'code' => 'TH', 'flag' => 'πΉπ­', 'name' => 'Thai'],
            (object) ['id' => 118, 'code' => 'BO', 'flag' => 'πΊπ³', 'name' => 'Tibetan'],
            (object) ['id' => 119, 'code' => 'TI', 'flag' => 'πͺπ·', 'name' => 'Tigrinya'],
            (object) ['id' => 120, 'code' => 'TO', 'flag' => 'πΊπ³', 'name' => 'Tonga'],
            (object) ['id' => 121, 'code' => 'TS', 'flag' => 'πΏπ¦', 'name' => 'Tsonga'],
            (object) ['id' => 122, 'code' => 'TR', 'flag' => 'πΉπ·', 'name' => 'Turkish'],
            (object) ['id' => 123, 'code' => 'TK', 'flag' => 'πΉπ²', 'name' => 'Turkmen'],
            (object) ['id' => 124, 'code' => 'TW', 'flag' => 'πΊπ³', 'name' => 'Twi'],
            (object) ['id' => 125, 'code' => 'UK', 'flag' => 'πΊπ¦', 'name' => 'Ukrainian'],
            (object) ['id' => 127, 'code' => 'UR', 'flag' => 'π΅π°', 'name' => 'Urdu'],
            (object) ['id' => 128, 'code' => 'UZ', 'flag' => 'πΊπΏ', 'name' => 'Uzbek'],
            (object) ['id' => 129, 'code' => 'VI', 'flag' => 'π»π³', 'name' => 'Vietnamese'],
            (object) ['id' => 130, 'code' => 'VO', 'flag' => 'πΊπ³', 'name' => 'Volapuk'],
            (object) ['id' => 131, 'code' => 'CY', 'flag' => 'π΄σ §σ ’σ ·σ ¬σ ³σ Ώ', 'name' => 'Welsh'],
            (object) ['id' => 132, 'code' => 'WO', 'flag' => 'πΈπ³', 'name' => 'Wolof'],
            (object) ['id' => 133, 'code' => 'XH', 'flag' => 'πΏπ¦', 'name' => 'Xhosa'],
            (object) ['id' => 134, 'code' => 'JI', 'flag' => 'π?π±', 'name' => 'Yiddish'],
            (object) ['id' => 135, 'code' => 'YO', 'flag' => 'πΊπ³', 'name' => 'Yoruba'],
            (object) ['id' => 136, 'code' => 'ZU', 'flag' => 'πΏπ¦', 'name' => 'Zulu'],
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
