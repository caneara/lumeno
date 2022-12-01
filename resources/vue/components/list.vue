<template>
    <div :dusk="dusk"
         class="list">

        <!-- Content -->
        <div v-if="show"
             class="rounded-lg">

            <!-- Items -->
            <div :key="item[ref]"
                 v-for="item in items"
                 :dusk="`${dusk}-item-${item[ref]}`"
                 @click="filled(action) && ! $event.target.classList.contains('trigger-item') ? action(item) : null"
                 class="md:py-4 md:flex-row md:items-center flex transition duration-300 flex-col p-6
                        odd:bg-white odd:hover:bg-orange-100/25 even:bg-sky-50 even:hover:bg-orange-100/25"
                 :class="[
                    blank(action) ? '' : 'cursor-pointer',
                    border ? `border border-b-0 border-gray-400/75 border-t-gray-300/50 last:rounded-b
                              first-of-type:border-t-gray-400/75 first-of-type:border-l-gray-400/75
                              last-of-type:border-b first-of-type:border-r-gray-400/75 first:rounded-t`
                           : `border-t border-t-gray-300/50 first-of-type:border-t-0 last-of-type:border-b`
                 ]">

                <!-- Left Side -->
                <div :class="left"
                     class="mb-6 md:mb-0">

                     <!-- Slot -->
                    <slot name="left"
                          :item="item">
                    </slot>

                </div>

                <!-- Right Side -->
                <div :class="right">

                    <!-- Slot -->
                    <slot name="right"
                          :item="item">
                    </slot>

                </div>

            </div>

        </div>

        <!-- Empty -->
        <v-empty :action="start"
                 :border="border"
                 :visible="! show && ! simple"
                 :message="blank(empty) ? 'There are no items to display' : empty">
        </v-empty>

    </div>

</template>

<script>
    import EmptyComponent from './empty.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-empty' : EmptyComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'ref'    : { type : String,   default : 'id' },
            'dusk'   : { type : String,   default : 'list' },
            'left'   : { type : String,   default : 'flex grow items-center' },
            'show'   : { type : Boolean,  default : true },
            'empty'  : { type : String,   default : '' },
            'items'  : { type : Array,    default : [] },
            'right'  : { type : String,   default : 'flex flex-wrap shrink items-center justify-end' },
            'start'  : { type : Object,   default : {} },
            'action' : { type : Function, default : null },
            'border' : { type : Boolean,  default : true },
            'simple' : { type : Boolean,  default : false },
        },
    }
</script>