<template>
	<div class="dropdown">

		<!-- Control -->
		<div @mouseover="hover = true"
             @mouseout="hover = false"
             class="control rounded relative w-full transition duration-400 bg-white border border-gray-400/75 cursor-pointer">

			<!-- Input -->
			<select :id="name"
                    ref="input"
					:name="name"
					:value="modelValue"
                    @focus="focus = true"
                    @focusout="focus = false"
					@change="change($event.target.value)"
                    :class="filled(modelValue) ? 'pt-25px pb-7px' : ''"
					style="line-height: 1.3; padding-right: 50px; -webkit-padding-end: 50px !important"
					class="field appearance-none bg-inherit h-[52px] cursor-pointer rounded w-full px-3 text-gray-900 align-middle text-ellipsis overflow-hidden">

				<!-- Items -->
				<option :value="item[v]"
                        :selected="modelValue === item[v] ? 'selected' : ''"
                        v-for="item in items.filter(item => ! item['hidden'] ?? false)">
					{{ item[k] }}
				</option>

			</select>

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :transition="false"
                     :optional="optional"
                     :value="filled(modelValue)">
            </v-label>

			<!-- Caret -->
			<i :class="blank(modelValue) || (filled(modelValue) && ! hover) ? 'opacity-100' : 'opacity-0'"
               class="fas fa-caret-down absolute right-17px top-19px text-gray-500 transition duration-400 cursor-pointer pointer-events-none">
            </i>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     v-if="! dusk()"
                     @clear="change('')"
                     :value="filled(modelValue)">
            </v-clear>

		</div>

        <!-- Error -->
        <v-error :message="message"></v-error>

	</div>
</template>

<script>
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
            'v-clear' : ClearComponent,
            'v-error' : ErrorComponent,
            'v-label' : LabelComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['change'],

		/**
		 * Define the public properties.
		 *
		 */
		props : {
			'k'        : { type : String,          default : '' },
			'v'        : { type : String,          default : '' },
			'items'    : { type : [Array, Object], default : [] },
            'optional' : { type : Boolean,         default : false },
		},

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            if (typeof this.modelValue === 'boolean') {
                this.$emit('update:modelValue', this.modelValue ? 1 : 0);
            }

            let selected = this.items.find(item => item[this.v] === this.modelValue);

            if (selected === undefined || [null, undefined].includes(this.modelValue)) {
                this.change('');

                return this.$refs.input.selectedIndex = -1;
            }

            if (this.modelValue.toString() === '') {
                this.$refs.input.selectedIndex = -1;
            }
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods :
        {
			/**
			 * Set the component's value.
			 *
			 */
			change(payload = undefined)
			{
                this.$refs.input.blur();

				this.message = '';

                if (payload === undefined) return;

                if (! ['', null].includes(payload) && ! isNaN(payload)) {
                    payload = Number(payload);
                }

                this.$emit('update:modelValue', payload);

                this.$emit('change', {
                    text     : this.$refs.input[this.$refs.input.selectedIndex]?.text ?? '',
                    value    : payload,
                    previous : this.modelValue,
                });
			},
		}
	}
</script>