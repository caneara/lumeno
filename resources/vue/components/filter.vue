<template>
    <div class="filter">

        <!-- Divider -->
        <div class="border-t border-gray-300/70 pt-7 mt-9"></div>

        <!-- Content -->
        <div class="flex items-center">

            <!-- Icon -->
            <i class="fas fa-search fa-fw -ml-6px text-15px text-gray-500/80"></i>

            <!-- Search -->
            <v-textbox icon=""
                       :length="50"
                       :small="true"
                       :border="false"
                       v-model="value"
                       label="Search..."
                       @change="search($event)"
                       class="w-full md:max-w-225px lg:max-w-250px"
                       :id="`${blank(id) ? '' : `${id}_`}filter_query`">
            </v-textbox>

        </div>

    </div>
</template>

<script>
    import { debounce } from 'lodash-es';
    import TextBoxComponent from './textbox.vue';
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
            'v-textbox' : TextBoxComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            value : this.modelValue,
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'     : { type : String,  default : '' },
            'min'    : { type : Number,  default : 3 },
            'icon'   : { type : Boolean, default : true },
            'border' : { type : Boolean, default : true },
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'modelValue' computed property.
             *
             */
            modelValue : function(current, previous)
            {
                this.value = current;
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Change the keys and values in the page's query string.
             *
             */
            search : debounce(function(event)
            {
                if (blank(event) || event.length >= this.min) {
                    this.change(event);
                }
            }, 300)
        }
    }
</script>