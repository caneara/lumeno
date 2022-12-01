<template>
    <v-panel :border="false">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Position
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify where you live, together
                with your country and time zone.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">

                <!-- Text -->
                For area, specify your town or city, followed
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
                For legal reasons, you must be eligible
                to work in the country you select.
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
            <p class="text-14px text-gray-600/90 mb-4">
                Coordinates are used only when matching
                you to a vacancy. They are not shared
                with anyone.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                For privacy reasons, limit coordinates
                to two decimal places. This provides a
                relative accuracy of around 1 kilometer.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Area -->
            <v-textbox id="area"
                       icon="map"
                       class="mb-4"
                       label="Area e.g. Dallas, Texas"
                       v-model="session.forms.account.area"
                       :error="session.forms.account.errors.area">
            </v-textbox>

            <!-- Country -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="globe"
                        id="country"
            			label="Country"
            			:items="prop('countries')"
                        v-model="session.forms.account.country"
                        :error="session.forms.account.errors.country">
            </v-dropdown>

            <!-- Time Zone -->
            <v-dropdown v="id"
            			k="name"
            			icon="clock"
                        class="mb-4"
                        id="time_zone"
            			label="Time zone"
            			:items="prop('time_zones')"
                        v-model="session.forms.account.time_zone"
                        :error="session.forms.account.errors.time_zone">
            </v-dropdown>

            <!-- Coordinates -->
            <v-coordinates class="mb-4"
                           id="coordinates"
                           label="Coordinates"
                           icon="map-marker-alt"
                           :token="prop('token')"
                           v-model="session.forms.account.coordinates"
                           :error="session.forms.account.errors.coordinates">
            </v-coordinates>

            <!-- Update -->
            <v-button label="Update"
                      class="md:flex justify-end"
                      :processing="session.forms.account.processing"
                      @click="submit(session.forms.account, 'account.update', 'patch', { preserveScroll : true })">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';
    import CoordinatesComponent from '@/components/coordinates.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'      : ButtonComponent,
            'v-coordinates' : CoordinatesComponent,
            'v-dropdown'    : DropDownComponent,
            'v-link'        : LinkComponent,
            'v-panel'       : PanelComponent,
            'v-textbox'     : TextBoxComponent,
        },
    }
</script>