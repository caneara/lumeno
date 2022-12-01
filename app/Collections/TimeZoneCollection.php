<?php

namespace App\Collections;

use App\Types\Collection;

class TimeZoneCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => 1,  'offset' => -12, 'short' => 'UTC -12', 'name' => 'UTC -12 (Baker Island)'],
            (object) ['id' => 2,  'offset' => -11, 'short' => 'UTC -11', 'name' => 'UTC -11 (Samoa, New Zealand)'],
            (object) ['id' => 3,  'offset' => -10, 'short' => 'UTC -10', 'name' => 'UTC -10 (Hawaii, Polynesia, Cook Islands)'],
            (object) ['id' => 4,  'offset' => -9,  'short' => 'UTC -9',  'name' => 'UTC -9 (Alaska)'],
            (object) ['id' => 5,  'offset' => -8,  'short' => 'UTC -8',  'name' => 'UTC -8 (U.S. Pacific Time, Pitcairn)'],
            (object) ['id' => 6,  'offset' => -7,  'short' => 'UTC -7',  'name' => 'UTC -7 (U.S. Mountain Time)'],
            (object) ['id' => 7,  'offset' => -6,  'short' => 'UTC -6',  'name' => 'UTC -6 (U.S. Central Time, Mexico, Belize, Ecuador, Honduras, Nicaragua, Guatamala, Costa Rica)'],
            (object) ['id' => 8,  'offset' => -5,  'short' => 'UTC -5',  'name' => 'UTC -5 (U.S. Eastern Time, Colombia, Cuba, Haiti, Peru, Panama, Jamaica, Bahamas, West Brazil)'],
            (object) ['id' => 9,  'offset' => -4,  'short' => 'UTC -4',  'name' => 'UTC -4 (U.S. Atlantic Time, Bolivia, Chile, Central (West) Brazil, Dominican Republic, Paraguay, Venezuela)'],
            (object) ['id' => 10, 'offset' => -3,  'short' => 'UTC -3',  'name' => 'UTC -3 (Central (East) Brazil, Argentina, Suriname, Uruguay, Falkland Islands)'],
            (object) ['id' => 11, 'offset' => -2,  'short' => 'UTC -2',  'name' => 'UTC -2 (Sandwich Islands)'],
            (object) ['id' => 12, 'offset' => -1,  'short' => 'UTC -1',  'name' => 'UTC -1 (Azores, Cape Verde)'],
            (object) ['id' => 13, 'offset' => 0,   'short' => 'UTC',     'name' => 'UTC (UK, Ireland, Portugal, Burkina Faso, Ivory Coast, Gambia, Ghana, Iceland, Liberia, Mail, Mauritania, Senegal, Sierra Leone, Togo)'],
            (object) ['id' => 14, 'offset' => 1,   'short' => 'UTC +1',  'name' => 'UTC +1 (Germany, France, Italy, Spain, Albania, Algeria, Austria, Belgium, Croatia, Denark, Hungary, Morocco, Netherlands, Nigeria, Poland, Sweden)'],
            (object) ['id' => 15, 'offset' => 2,   'short' => 'UTC +2',  'name' => 'UTC +2 (Egypt, South Africa, Ukraine, Bulgaria, Finland, Greece, Israel, Jordan, Latvia, Libya, Romania, Syria, Rwanda, Zambia, Zimbabwe'],
            (object) ['id' => 16, 'offset' => 3,   'short' => 'UTC +3',  'name' => 'UTC +3 (Russia, Turkey, Saudi Arabia, Bahrain, Belarus, Ethiopia, Georgia, Iraq, Kenya, Qatar, Somalia, Uganda, Yemen)'],
            (object) ['id' => 17, 'offset' => 4,   'short' => 'UTC +4',  'name' => 'UTC +4 (Armenia, Azerbaijan, United Arab Emirates, Mauritius, Oman, Seychelles)'],
            (object) ['id' => 18, 'offset' => 5,   'short' => 'UTC +5',  'name' => 'UTC +5 (Pakistan, Maldives, West Kazakhstan, Tajikistan, Turkmenistan, Uzbekistan'],
            (object) ['id' => 19, 'offset' => 6,   'short' => 'UTC +6',  'name' => 'UTC +6 (India, Nepal, Bangladesh, Bhutan, East Kazakhstan, British Indian Ocean)'],
            (object) ['id' => 20, 'offset' => 7,   'short' => 'UTC +7',  'name' => 'UTC +7 (Thailand, Vietnam, Cambodia, West Indonesia, Laos, West Mongolia)'],
            (object) ['id' => 21, 'offset' => 8,   'short' => 'UTC +8',  'name' => 'UTC +8 (China, Hong Kong, Singapore, Taiwan, Malaysia, Central Indonesia, Philippines, West Australia, Brunei, East Mongolia)'],
            (object) ['id' => 22, 'offset' => 9,   'short' => 'UTC +9',  'name' => 'UTC +9 (Japan, Korea, East Indonesia, Palau)'],
            (object) ['id' => 23, 'offset' => 10,  'short' => 'UTC +10', 'name' => 'UTC +10 (Central Australia, Papua New Guinea, West Micronesia, Guam)'],
            (object) ['id' => 24, 'offset' => 11,  'short' => 'UTC +11', 'name' => 'UTC +11 (East Australia, East Micronesia, Solomon Islands, Vanuatu'],
            (object) ['id' => 25, 'offset' => 12,  'short' => 'UTC +12', 'name' => 'UTC +12 (Marshall Islands, Nauru, Fiji, Tuvalu)'],
        ];
    }
}
