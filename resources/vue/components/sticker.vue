<template>
    <div class="sticker">

        <!-- Control -->
        <div @mouseover="hover = true"
             @mouseout="hover = false"
             class="bg-white border border-dashed border-gray-400 control rounded relative w-full">

            <!-- Input -->
            <input readonly
                   :id="name"
                   type="text"
                   :name="name"
                   v-if="lines === 1"
                   :value="displayValue"
                   class="field rounded appearance-none bg-inherit w-full px-3 text-gray-900 pb-7px pt-25px" />

            <!-- Textarea -->
            <textarea readonly
                      :id="name"
                      :name="name"
                      :rows="lines"
                      v-if="lines !== 1"
                      :value="displayValue"
                      class="field textarea rounded appearance-none bg-inherit w-full pl-3 pr-11 text-gray-900 resize-none leading-snug pt-25px">
            </textarea>

            <!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :value="filled(displayValue)">
            </v-label>

            <!-- Copy -->
            <span v-if="copy"
                  style="transition: all 0.4s ease, background-color 0s"
                  class="copy block absolute right-0 top-0 bg-inherit rounded-r-md h-[50px] w-[47px]"
                  :class="(hover && displayValue) ? 'opacity-100 pointer-events-auto z-2' : 'opacity-0 pointer-events-none'">

                <!-- Icon -->
                <i title="Copy"
                   @click="copyToClipboard(displayValue)"
                   class="fas fa-copy absolute text-gray-500/80 hover:text-gray-700 right-17px top-19px
                          cursor-pointer transition duration-400 text-15px">
                </i>

            </span>

        </div>

    </div>
</template>

<script>
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
            'v-label' : LabelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            permission : 'You need to grant Lumeno access to your clipboard within your browser settings',
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'copy'  : { type : Boolean, default : true },
            'text'  : { type : String,  default : '' },
            'lines' : { type : Number,  default : 1 },
        },

        /**
         * Define the computed properties.
         *
         */
        computed :
        {
            /**
             * Retrieve the displayed value for the component.
             *
             */
            displayValue()
            {
                if (filled(this.modelValue)) {
                    return this.modelValue;
                }

                if (filled(this.text)) {
                    return this.text;
                }

                return '';
            }
        },
    }
</script>