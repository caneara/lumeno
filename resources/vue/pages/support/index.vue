<template>
    <v-layout>

        <!-- Banner -->
        <template #banner>
            <div class="bg-sky-950 relative md:mb-2">
                <div class="container">

                    <!-- Overlay -->
                    <div :style="`background-image: url('${asset('img/world.png')}')`"
                         class="bg-no-repeat bg-cover bg-center opacity-5 absolute inset-0">
                    </div>

                    <!-- Content -->
                    <div class="px-6 md:px-12 lg:px-14 py-12 md:pt-20 md:pb-18 lg:pt-24 lg:pb-22 xl:pt-28 xl:pb-26">

                        <!-- Title -->
                        <h1 class="text-30px lg:text-35px text-white mb-6">
                            Support Center
                        </h1>

                        <!-- Information -->
                        <p class="w-full xl:w-7/10 text-18px text-gray-400/85 mb-0">
                            Welcome to the Lumeno support site. Here, you'll find useful information,
                            including answers to frequently asked questions. If you're experiencing an
                            issue, then scroll down to get in touch.
                        </p>

                    </div>

                </div>
            </div>
        </template>

        <!-- Panels -->
        <div class="xl:max-w-screen-xl p-6 md:px-12 lg:px-14">
            <v-guide></v-guide>
            <v-faq></v-faq>
            <v-contact></v-contact>
        </div>

    </v-layout>
</template>

<script>
    import FaqPartial from './faq.vue';
    import GuidePartial from './guide.vue';
    import Layout from '@/layout/index.vue';
    import ContactPartial from './contact.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-contact' : ContactPartial,
            'v-faq'     : FaqPartial,
            'v-guide'   : GuidePartial,
            'v-layout'  : Layout,
        },
    }
</script>