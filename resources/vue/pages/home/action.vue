<template>
    <div :style="`background-image: url('${asset('img/signal.svg')}')`"
         class="bg-sky-1000 flex flex-col justify-center pt-20 md:pt-30">

        <!-- Container -->
        <div class="flex flex-col justify-center items-center container pb-10 md:pb-20">

            <!-- Teaser -->
            <h2 class="text-27px md:text-30px text-white text-center mb-4">
                Join hundreds of IT professionals
            </h2>

            <!-- Supplemental -->
            <p class="text-20px text-gray-500 text-center max-w-500px mb-10">

                <!-- Text -->
                Click below to sign up for an account. It's

                <!-- Highlight -->
                <span class="font-semibold text-amber-400">
                    free for all
                </span>

                <!-- Text -->
                IT professionals, so why not get started today?

            </p>

            <!-- Action -->
            <div @click="redirect('register')"
                 class="bg-emerald-700 hover:bg-emerald-600 border border-emerald-700 hover:border-emerald-600 font-semibold text-13px text-white text-center uppercase rounded-md cursor-pointer transition duration-300 px-8 pt-3 pb-11px">

                <!-- Text -->
                Register Now

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