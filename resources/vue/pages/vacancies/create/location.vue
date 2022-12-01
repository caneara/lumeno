<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-location">
                Location
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the area, country and main
                coordinates of the workplace.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">

                <!-- Text -->
                For area, specify the town or city, followed
                by the county, state or province e.g.

                <!-- USA -->
                <span class="block mt-4 mb-2">

                    <!-- Identity -->
                    🇺🇸

                    <!-- Phone -->
                    <span class="ml-1">
                        Los Angeles, California
                    </span>

                </span>

                <!-- UK -->
                <span class="block mb-2">

                    <!-- Identity -->
                    🇬🇧

                    <!-- Phone -->
                    <span class="ml-1">
                        Leeds, West Yorkshire
                    </span>

                </span>

                <!-- France -->
                <span class="block mb-2">

                    <!-- Identity -->
                    🇫🇷

                    <!-- Phone -->
                    <span class="ml-1">
                        Marseille, Bouches-du-Rhône
                    </span>

                </span>

                <!-- Germany -->
                <span class="block mb-8">

                    <!-- Identity -->
                    🇩🇪

                    <!-- Phone -->
                    <span class="ml-1">
                        München, Bayern
                    </span>

                </span>

            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                When allowing for foreign workers, candidates
                already residing in the selected country
                will be ranked higher in the search results.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">

                <!-- Text -->
                Click

                <!-- Icon -->
                <i class="text-teal-600 text-12px fas fa-location-arrow text-gray-500 relative top-1px ml-2px mr-1"></i>

                <!-- Text -->
                to insert your coordinates. If that fails,
                type your address and select the best option
                provided by Google Maps. If necessary, click on

                <!-- Icon -->
                <i class="text-teal-600 text-11px fas fa-map-location-dot text-gray-500 relative mx-1"></i>

                <!-- Text -->
                to show a map and adjust your location.

            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Coordinates should be limited to two
                decimal places. This provides a relative
                accuracy of around one kilometer.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Area -->
            <v-textbox id="area"
                       icon="map"
                       class="mb-4"
                       v-model="session.form.area"
                       label="Area e.g. Dallas, Texas"
                       :error="session.form.errors.area">
            </v-textbox>

            <!-- Country -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="globe"
                        id="country"
            			label="Country"
            			:items="prop('countries')"
                        v-model="session.form.country"
                        :error="session.form.errors.country">
            </v-dropdown>

            <!-- Coordinates -->
            <v-coordinates class="mb-4"
                           id="coordinates"
                           label="Coordinates"
                           icon="map-marker-alt"
                           :token="prop('token')"
                           v-model="session.form.coordinates"
                           :error="session.form.errors.coordinates">
            </v-coordinates>

            <!-- Emigrate -->
            <v-checkbox id="emigrate"
                        label="International workers"
                        v-model="session.form.emigrate"
                        :error="session.form.errors.emigrate">
            </v-checkbox>

        </template>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import PanelComponent from '@/components/panel.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';
    import CoordinatesComponent from '@/components/coordinates.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-checkbox'    : CheckBoxComponent,
            'v-coordinates' : CoordinatesComponent,
            'v-dropdown'    : DropDownComponent,
            'v-link'        : LinkComponent,
            'v-panel'       : PanelComponent,
            'v-textbox'     : TextBoxComponent,
        },
    }
</script>