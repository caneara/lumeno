<?php

namespace App\Collections;

use App\Models\Project;
use App\Types\Collection;

class ProjectTypeCollection extends Collection
{
    /**
     * The field to sort by.
     *
     */
    protected string $sort = 'name';

    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => Project::TYPE_OPEN_SOURCE,                         'name' => 'Open Source Tool / Library'],
            (object) ['id' => Project::TYPE_DESKTOP_MOBILE_APPLICATION,          'name' => 'Desktop / Mobile (Application)'],
            (object) ['id' => Project::TYPE_WEB_APPLICATION,                     'name' => 'Web Application (General)'],
            (object) ['id' => Project::TYPE_PROTOTYPE,                           'name' => 'Prototype'],
            (object) ['id' => Project::TYPE_DESIGN_UI_UX,                        'name' => 'Design / UI / UX'],
            (object) ['id' => Project::TYPE_HARDWARE,                            'name' => 'Hardware'],
            (object) ['id' => Project::TYPE_SYSTEM_ARCHITECTURAL_INFRASTRUCTURE, 'name' => 'System / Architectural / Infrastructure'],
            (object) ['id' => Project::TYPE_PERSONAL,                            'name' => 'Personal'],
            (object) ['id' => Project::TYPE_EDUCATIONAL,                         'name' => 'Educational'],
            (object) ['id' => Project::TYPE_OTHER,                               'name' => 'Other'],
            (object) ['id' => Project::TYPE_WEB_APPLICATION_SAAS,                'name' => 'Web Application (SaaS)'],
            (object) ['id' => Project::TYPE_WEB_APPLICATION_MARKETPLACE,         'name' => 'Web Application (Marketplace)'],
            (object) ['id' => Project::TYPE_WEB_APPLICATION_ECOMMERCE,           'name' => 'Web Application (eCommerce)'],
            (object) ['id' => Project::TYPE_CRYPTO_CURRENCY,                     'name' => 'Crypto Currency'],
            (object) ['id' => Project::TYPE_WEB_PLATFORM_PLUGIN,                 'name' => 'Web Platform Plugin'],
            (object) ['id' => Project::TYPE_DESKTOP_MOBILE_PLUGIN,               'name' => 'Desktop / Mobile (Plugin)'],
        ];
    }
}
