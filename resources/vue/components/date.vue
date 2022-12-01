<template>
	<div class="date">

		<!-- Control -->
		<div @mouseover="hover = true"
             @mouseout="hover = false"
             :class="open ? 'rounded-t' : 'rounded'"
             class="control relative w-full transition duration-400 bg-white border border-gray-400/75">

		    <!-- Hidden -->
		    <input :id="name"
		    	   :name="name"
                   type="hidden"
		    	   @input="change()"
		    	   :value="modelValue" />

			<!-- Input -->
			<input readonly
                   type="text"
				   :value="text"
                   :id="name + '_text'"
                   @click="open = true; focus = true; picker.show()"
				   class="field appearance-none bg-inherit w-full px-3 text-gray-900 rounded pb-7px pt-25px cursor-pointer" />

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :optional="optional"
                     :value="filled(modelValue)">
            </v-label>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     v-if="! dusk()"
                     :value="filled(modelValue)"
                     @clear="reset(); change('')">
            </v-clear>

		</div>

        <!-- Picker -->
        <div ref="picker"
             class="relative z-1002">
        </div>

		<!-- Validation -->
		<v-error :message="error"></v-error>

	</div>
</template>

<script>
    import Pikaday from 'pikaday';
    import 'pikaday/css/pikaday.css';
    import ClearComponent from './clear.vue';
    import ErrorComponent from './error.vue';
    import LabelComponent from './label.vue';
	import InteractsWithField from '@/mixins/InteractsWithField';
	import InteractsWithOutside from '@/mixins/InteractsWithOutside';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

	export default
    {
		/**
		 * Define the mixins.
		 *
		 */
		mixins: [
			InteractsWithField,
            InteractsWithOutside,
            InteractsWithFormatting,
		],

        /**
         * Define the components.
         *
         */
        components : {
            'v-clear' : ClearComponent,
            'v-error' : ErrorComponent,
            'v-label' : LabelComponent,
        },

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
            open   : false,
            text   : '',
			picker : null,
		}},

		/**
		 * Define the public properties.
		 *
		 */
		props: {
            'optional' : { type : Boolean, default : false },
		},

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on(`set-date-for-${this.name}`, (date) => this.select(this.format(date)));

            this.picker = new Pikaday(this.config());

            this.$refs.picker.appendChild(this.picker.el);

            this.picker.hide();

            this.setValue();
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`set-date-for-${this.name}`);
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
	    	/**
	    	 * Close or hide the component.
	    	 *
	    	 */
	    	closeComponent()
	    	{
                this.open  = false;
                this.focus = false;

                this.picker.hide();
	    	},

            /**
             * Retrieve the configuration for the date picker.
             *
             */
            config()
            {
                return {
                    yearRange : 100,
                    format    : 'YYYY-MM-DD',
                    onSelect  : (date) => this.select(this.format(date)),
                };
            },

            /**
             * Format the given value into a valid ISO string.
             *
             */
            format(value)
            {
                if (typeof value === 'string') return value;

                return `${value.getFullYear()}-${('0' + (value.getMonth() + 1)).slice(-2)}-${('0' + value.getDate()).slice(-2)}`;
            },

	    	/**
	    	 * Determine if the component is open or visible.
	    	 *
	    	 */
	    	isComponentOpen()
	    	{
                return this.open;
	    	},

            /**
             * Clear the existing date.
             *
             */
            reset()
            {
                this.picker.gotoToday();
                this.picker.setDate(null);
                this.picker.hide();

                this.open    = false;
                this.focus   = false;
                this.text    = '';
                this.message = '';
            },

            /**
             * Update the component to the chosen date.
             *
             */
            select(value)
            {
                this.open    = false;
                this.focus   = false;
                this.message = '';

                this.picker.hide();

                this.text = this.date(value);

                this.change(value);
            },

            /**
             * Refresh the component's current value.
             *
             */
            setValue()
            {
                if (blank(this.modelValue)) {
                    return this.reset();
                }

                this.message = '';

                let parts = this.modelValue.includes('T') ? this.modelValue.split('T') : this.modelValue.split(' ');

                this.picker.setDate(parts[0]);
            }
        }
	}
</script>