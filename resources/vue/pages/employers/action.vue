<template>
    <div :style="`background-image: url('${asset('img/signal.svg')}')`"
         class="bg-sky-1000 flex flex-col justify-center pt-20 md:pt-30">

        <!-- Container -->
        <div class="flex flex-col justify-center items-center container pb-10 md:pb-20">

            <!-- Teaser -->
            <h2 class="text-27px md:text-30px text-white text-center">
                Ready to fill your vacancy?
            </h2>

            <!-- Supplemental -->
            <p class="text-20px text-gray-500 text-center max-w-500px mb-10">
                Easily reach hundreds of IT professionals across a range
                of technical disciplines. Click below to start your journey.
            </p>

            <!-- Action -->
            <div @click="redirect('register')"
                class="bg-sky-700 hover:bg-sky-600 text-white rounded-lg cursor-pointer transition duration-300 px-12 pt-3 pb-11px">

                <!-- Text -->
                Register Today

            </div>

        </div>

        <!-- Footer -->
        <v-footer></v-footer>

    </div>
</template>

<script>
    import FooterPartial from '@/layout/footer.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-footer' : FooterPartial,
        },
    }
</script>