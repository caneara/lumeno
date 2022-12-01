<template>
    <div :class="[
            border ? 'border-t border-gray-300/70 pt-10 md:pt-15 lg:pt-17 xl:pt-20' : '',
            tab ? 'tab' : '',
            tab === active ? '' : 'hidden'
         ]"
         :data-tab="tab"
         class="panel flex flex-wrap mt-12 md:mt-15 lg:mt-17 xl:mt-20 first-of-type:mt-0">

        <!-- Left Side -->
        <div v-if="! stack"
             class="left w-full md:w-1/2 lg:w-9/20 pb-6 md:pb-0 md:pr-18 lg:pr-9 xl:pr-18">

            <!-- Slot -->
            <slot name="left"></slot>

        </div>

        <!-- Right Side -->
        <div v-if="! stack"
             class="right w-full md:w-1/2 lg:w-11/20 md:pl-10">

            <!-- Slot -->
            <slot name="right"></slot>

        </div>

        <!-- Single -->
        <div v-if="stack"
             class="left w-full">

            <!-- Slot -->
            <slot></slot>

        </div>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the public properties.
         *
         */
        props : {
            'tab'    : { type : String,  default : '' },
            'stack'  : { type : Boolean, default : false },
            'active' : { type : String,  default : '' },
            'border' : { type : Boolean, default : true },
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'active' property.
             *
             */
            active : function(current, previous)
            {
                if (this.tab && (current === this.tab)) {
                    events.emit(`set-active-tab-${this.tab}`);
                }
            }
        },
    }
</script>