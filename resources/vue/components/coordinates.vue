<template>
    <div class="coordinates">

        <!-- Control -->
        <div @mouseover="hover = true"
             @mouseout="hover = false"
             class="control rounded relative w-full transition duration-400 bg-white border border-gray-400/75">

            <!-- Input -->
            <input :id="name"
                   type="text"
                   ref="input"
                   :name="name"
                   placeholder=""
                   :value="modelValue"
                   :autocomplete="fill"
                   @focus="focus = true"
                   @focusout="focus = false"
                   @input="change($event.target.value)"
                   class="field rounded appearance-none bg-inherit w-full text-gray-900 px-3 pb-7px pt-25px" />

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :value="filled(modelValue)">
            </v-label>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     v-if="! dusk()"
                     :value="filled(modelValue)"
                     @clear="term = ''; change('')">
            </v-clear>

            <!-- Google Maps -->
			<span @click="createMapSelector()"
                  title="Find my coordinates using Google Maps">

                <!-- Icon -->
                <i :class="filled(modelValue) ? 'right-21' : 'right-12'"
                   class="text-14px fas fa-map-location-dot text-gray-500 hover:fas transition duration-300 absolute top-19px cursor-pointer">
                </i>

            </span>

            <!-- Current Location -->
			<span @click="useCurrentLocation()"
                  title="Find my coordinates using my device">

                <!-- Icon -->
                <i :class="filled(modelValue) ? 'right-12' : 'right-17px'"
                   class="text-14px fas fa-location-arrow text-gray-500 hover:fas transition duration-300 absolute top-20px cursor-pointer">
                </i>

            </span>

        </div>

        <!-- Map -->
        <div ref="map"
             v-show="show"
             class="w-full h-300px rounded my-4">
        </div>

        <!-- Notice -->
        <v-alert color="blue"
                 v-if="show"
                 :spacing="false">

            <!-- Text -->
            When adjusting a pin's position, Lumeno will limit
            its coordinates to two decimal places. This
            may result in the coordinates remaining the same if
            the pin is only moved a short distance.

        </v-alert>

        <!-- Error -->
        <v-error :message="message"></v-error>

    </div>
</template>

<script>
    import AlertComponent from './alert.vue';
    import ClearComponent from './clear.vue';
    import ErrorComponent from './error.vue';
    import LabelComponent from './label.vue';
    import InteractsWithField from '@/mixins/InteractsWithField';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithField,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-alert' : AlertComponent,
            'v-clear' : ClearComponent,
            'v-error' : ErrorComponent,
            'v-label' : LabelComponent,
        },

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
			map      : null,
            show     : false,
 			pin      : null,
			list     : false,
			term     : '',
			place    : null,
			observer : null,
		}},

        /**
         * Define the public properties.
         *
         */
        props : {
            'token' : { type : String, default : '' },
        },

		/**
		 * Execute actions when the component is instantiated.
		 *
		 */
		created()
		{
            if (filled(this.modelValue)) {
                this.term = this.modelValue;
            }

            loadScript(`https://maps.googleapis.com/maps/api/js?key=${this.token}&libraries=places`);
		},

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
			when(() => window.google, () => this.createPlaceSelector());
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            if (filled(this.pin)) {
                google.maps.event.clearListeners(this.map, 'click');
            }

            if (filled(this.place)) {
                google.maps.event.clearListeners(this.place, 'place_changed');
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
			/**
			 * Attach a Google Maps pin to the map.
			 *
			 */
			attachPin(coordinates)
			{
				let position = new google.maps.LatLng(
                    coordinates.split(',')[0],
                    coordinates.split(',')[1].trim()
                );

                if (this.pin === null) {
                    this.pin = new google.maps.Marker({ map : this.map });
                }

				this.pin.setPosition(position);

				this.map.panTo(position);
			},

			/**
			 * Configure the Google Maps map field.
			 *
			 */
			createMapSelector()
			{
				if (this.map !== null) return;

                this.show = true;

                let lat = parseFloat(this.modelValue.split(',')[0]);
                let lng = parseFloat(this.modelValue.split(',')[1]);

				this.map = new google.maps.Map(this.$refs.map, {
					zoom               : isNaN(lat) ? 1 : 15,
					controlSize        : 22,
					mapTypeControl     : true,
					streetViewControl  : false,
					fullscreenControl  : false,
					center             : {
                        lat : isNaN(lat) ? 0.00 : lat,
                        lng : isNaN(lng) ? 0.00 : lng,
                    },
					zoomControlOptions : {
						style    : google.maps.ZoomControlStyle.SMALL,
						position : google.maps.ControlPosition.RIGHT_BOTTOM
					}
				});

				if (filled(this.modelValue)) {
					this.attachPin(this.modelValue);
				}

				this.map.addListener('click', (e) => {
					this.term = `${parseFloat(e.latLng.lat()).toFixed(2)}, ${parseFloat(e.latLng.lng()).toFixed(2)}`;
					this.change(`${parseFloat(e.latLng.lat()).toFixed(2)}, ${parseFloat(e.latLng.lng()).toFixed(2)}`);
					this.attachPin(`${parseFloat(e.latLng.lat()).toFixed(6)}, ${parseFloat(e.latLng.lng()).toFixed(6)}`);
				});
			},

			/**
			 * Configure the Google Maps places field.
			 *
			 */
			createPlaceSelector()
			{
				this.place = new google.maps.places.Autocomplete(
                    this.$refs.input, { fields: ['geometry'] }
                );

				this.place.addListener('place_changed', () => {
					let location = this.place.getPlace().geometry.location;

					this.map  = null;
					this.pin  = null;
					this.term = `${parseFloat(location.lat()).toFixed(2)}, ${parseFloat(location.lng()).toFixed(2)}`;
					this.change(`${parseFloat(location.lat()).toFixed(2)}, ${parseFloat(location.lng()).toFixed(2)}`);
				});
			},

            /**
             * Handle a failure to get the user's location.
             *
             */
            failedToGetLocation()
            {
                this.message = '';

                alert('Unable to get location, try clicking on the map icon.');
            },

            /**
             * Extract the latitude and longitude from the given position.
             *
             */
            parseCoordinates(position)
            {
                let latitude  = position.coords.latitude.toFixed(2);
                let longitude = position.coords.longitude.toFixed(2);

                return `${latitude}, ${longitude}`;
            },

			/**
			 * Format the Google Places component for use.
			 *
			 */
			updatePlaceSelector()
			{
				if (this.observer !== null) return;

				let element = document.querySelector('.pac-container');

				this.observer = new MutationObserver((events) =>
					events.filter((event) => event.attributeName === 'style')
						  .forEach((event) => this.list = element.style.display !== 'none')
				).observe(element, { attributes: true });
			},

			/**
			 * Change the component's value to the user's current location.
			 *
			 */
			useCurrentLocation()
			{
                if (! navigator.geolocation) {
                    return alert('Geolocation is not supported, try clicking on the map icon.');
                }

                this.message = 'Determining coordinates...';

                navigator.geolocation.getCurrentPosition(
                    position => this.change(this.parseCoordinates(position)),
                    () => this.failedToGetLocation()
                );
			},
        }
    }
</script>