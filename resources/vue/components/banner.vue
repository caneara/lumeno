<template>
    <div v-if="show"
         class="rounded-lg relative p-10 -mt-2 mb-11 overflow-hidden"
         :style="`background-image: linear-gradient(to bottom right, ${colors})`">

        <!-- Icon -->
        <i style="opacity: 0.08"
           :class="`fa-${icon}`"
           class="fas text-white text-[185px] hidden md:inline absolute -bottom-2 -right-14 -rotate-32">
        </i>

        <!-- Content -->
        <div class="text-18px text-white text-shadow leading-relaxed relative md:w-4/5 lg:w-full xl:w-4/5">
            <slot></slot>
        </div>

        <!-- Close -->
        <i v-if="close"
           @click="hide()"
           title="Hide this message"
           class="fas fa-times text-gray-500 hover:text-white transition duration-200 cursor-pointer text-16px absolute top-0 right-0 mr-14px mt-3">
        </i>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the data model.
         *
         */
        data() { return {
            show : true,
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'     : { type : String,  default : '' },
            'icon'   : { type : String,  default : 'cog' },
            'close'  : { type : Boolean, default : true },
            'colors' : { type : String,  default : '#844AD8, #3885D2' },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            if (blank(this.id)) return;

            if (filled(window.localStorage.getItem(this.id))) {
                this.show = false;
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Hide the component on demand.
             *
             */
            hide()
            {
                this.show = false;

                window.localStorage.setItem(this.id, 1);
            }
        }
    }
</script>