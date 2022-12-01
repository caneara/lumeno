<template>
    <div class="password">

        <!-- Control -->
        <div @mouseover="hover = true"
             @mouseout="hover = false"
             class="control rounded relative w-full transition duration-400 bg-white border border-gray-400/75">

            <!-- Input -->
            <input :id="name"
                   :name="name"
                   type="password"
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
                     :optional="optional"
                     :value="filled(modelValue)">
            </v-label>

            <!-- Clear -->
            <v-clear :focus="focus"
                     :hover="hover"
                     v-if="! dusk()"
                     @clear="change('')"
                     :value="filled(modelValue)">
            </v-clear>

			<!-- Generate -->
			<i v-if="generate"
               @click="random()"
               title="Generate a random password"
               :class="filled(modelValue) ? 'hidden' : ''"
               class="far fa-lightbulb absolute right-17px top-19px text-gray-500 transition duration-400 cursor-pointer">
            </i>

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
        emits : ['random'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'generate' : { type : Boolean, default : true },
            'optional' : { type : Boolean, default : false },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Create a pseudo-random password.
             *
             */
            random()
            {
                let lower   = 'abcdefghijklmnopqrstuvwxyz';
                let upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let numbers = '0123456789';
                let symbols = '!@#$%^&*_-+=';

                let password = '';

                [lower, upper, numbers, symbols].forEach(type => {
                    for (var i = 0; i < 5; i++) {
                        password += type.charAt(Math.floor(Math.random() * type.length));
                    }
                });

                let result = [...password].sort(() => Math.random() - 0.5).join('');

                this.change(result);

                this.$emit('random', result);

                this.showNotification(`Your new password is: <span class="block font-mono mt-10px">${result}</span>`, 'info', true);
            },
        },
    }
</script>