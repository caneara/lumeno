<template>
    <div class="flex flex-col justify-between items-center relative overflow-hidden"
         style="background-image: linear-gradient(125deg, #0E1F52, #2C5DA1, #00A8F1, #004176)">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Graph Texture -->
        <div class="absolute inset-0 opacity-90"
             :style="`background-image: url('${asset('img/graph.svg')}'); background-position-x: -6px; background-position-y: -6px`">
        </div>

        <!-- Header -->
        <v-header></v-header>

        <!-- Container -->
        <div class="container flex flex-col items-center relative px-6 md:px-0 md:pt-50px">

            <!-- Content -->
            <div class="flex flex-col justify-center w-full md:w-3/4 lg:w-2/3 xl:w-1/2 py-10">

                <!-- Teaser -->
                <h1 class="text-30px md:text-[36px] lg:text-[39px] xl:text-[43px] text-white text-center mb-8">
                    The portfolio and recruitment platform for IT professionals
                </h1>

                <!-- Introduction -->
                <p class="text-17px md:text-18px lg:text-20px text-center text-gray-500 mb-10">
                    Centralize your résumé, project portfolio &amp; written articles,
                    then get invited for jobs that match your personal and tech requirements.
                </p>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row justify-center mb-6 lg:mb-10">

                    <!-- Get Started -->
                    <div @click="redirect('register')"
                         class="bg-emerald-700 hover:bg-emerald-600 border border-emerald-700 hover:border-emerald-600 font-semibold text-13px text-white text-center uppercase rounded-md cursor-pointer transition duration-300 px-8 pt-3 pb-11px md:mr-4 mb-4 md:mb-0">

                        <!-- Text -->
                        Get Started

                    </div>

                    <!-- Employers -->
                    <div @click="redirect('employers')"
                         class="bg-sky-700 hover:bg-sky-600 border border-sky-700 hover:border-sky-600 font-semibold text-13px text-white text-center uppercase rounded-md cursor-pointer transition duration-300 px-8 pt-3 pb-11px md:mr-4 mb-4 md:mb-0">

                        <!-- Text -->
                        For Employers

                    </div>

                </div>

            </div>

            <!-- Tablet -->
            <div class="hidden md:block w-full max-w-700px lg:max-w-900px xl:max-w-1100px">

                <!-- Device -->
                <div class="border-5 border-gray-600/60 flex flex-col items-center md:h-[480px] lg:h-[490px] xl:h-[515px] rounded-t-[26px] overflow-hidden relative top-6px p-5 pb-0">

                    <!-- Inner -->
                    <div class="bg-sky-50 w-full h-full rounded-t-[10px] pt-9 lg:pt-12 xl:pt-14">
                        <v-profile></v-profile>
                    </div>

                    <!-- Border -->
                    <div style="width: calc(100% - 40px)"
                         class="border-b border-gray-200 absolute bottom-1px">
                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
    import HeaderPartial from './header.vue';
    import ProfilePartial from './profile.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-header'  : HeaderPartial,
            'v-profile' : ProfilePartial,
        },

    }
</script>