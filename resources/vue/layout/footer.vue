<template>
    <footer class="flex justify-center border-t border-gray-400/60"
            :class="invert ? (dialog ? 'bg-gray-100 md:bg-white' : 'bg-white') : (dialog ? 'bg-white md:bg-gray-100' : 'bg-gray-100')">

        <!-- Container -->
        <div class="flex flex-col md:flex-row md:justify-between container py-5">

            <!-- Copyright -->
            <div class="text-gray-600/75 text-13px text-center md:text-left">
                &copy; {{ new Date().getFullYear() }} Caneara. All rights reserved.
            </div>

            <!-- Links -->
            <div class="text-10px md:text-12px text-center md:text-left uppercase mt-5px md:mt-0">

                <!-- Legal -->
                <v-link :url="route('legal')"
                        class="text-gray-600/75 hover:text-sky-600/100">

                    <!-- Text -->
                    Legal

                </v-link>

                <!-- Divider -->
                <span class="text-13px text-gray-500 mx-1 md:mx-2">
                    &bull;
                </span>

                <!-- Support -->
                <v-link :url="route('support')"
                        class="text-gray-600/75 hover:text-sky-600/100">

                    <!-- Text -->
                    Support

                </v-link>

            </div>

        </div>
    </footer>
</template>

<script>
    import LinkComponent from '@/components/link.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link' : LinkComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'dialog' : { type : Boolean, default : false },
            'invert' : { type : Boolean, default : false },
        },
    }
</script>