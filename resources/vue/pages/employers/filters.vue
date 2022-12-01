<template>
    <div class="flex justify-center">
        <div class="container flex flex-col items-center pt-20 pb-19 md:py-30 lg:py-36 xl:py-40">

            <!-- Subliminal -->
            <span class="font-bold text-12px text-sky-500/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                Precise
            </span>

            <!-- Teaser -->
            <h2 class="text-black text-27px xl:text-30px text-center lg:text-left mb-8">
                Find the perfect candidate
            </h2>

            <!-- Summary -->
            <p class="text-19px md:text-20px text-gray-700/85 text-center max-w-600px mb-18">
                Filter the candidate list using powerful search
                criteria. From pay and time commitment to education
                and tech stack&hellip; all as standard.
            </p>

            <!-- Matrix -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12 max-w-1000px">

                <!-- Feature -->
                <div v-for="feature in features"
                     class="flex flex-col justify-center items-center">

                    <!-- Blob -->
                    <div class="bg-no-repeat flex justify-center items-center w-100px h-100px mb-3"
                         :style="`background-image: url('${asset('img/blob.svg')}'); background-position: -5px 0`">

                        <!-- Icon -->
                        <i class="fas text-26px"
                           :class="[`fa-${feature.icon}`, feature.color]">
                        </i>

                    </div>

                    <!-- Name -->
                    <h5 class="text-18px mb-2">
                        {{ feature.name }}
                    </h5>

                    <!-- Summary -->
                    <span class="text-gray-700 text-center leading-normal px-10">
                        {{ feature.summary }}
                    </span>

                </div>

            </div>


        </div>
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
            features : [
                {
                    name    : 'Time',
                    icon    : 'clock',
                    color   : 'text-rose-600',
                    summary : 'Search for full-time, part-time or contract-based professionals.',
                }, {
                    name    : 'Pay',
                    icon    : 'coins',
                    color   : 'text-yellow-600',
                    summary : 'Search for candidates that fit within your available budget.',
                }, {
                    name    : 'Location',
                    icon    : 'globe',
                    color   : 'text-emerald-600',
                    summary : 'Search for candidates within your country or go international.',
                }, {
                    name    : 'Language',
                    icon    : 'language',
                    color   : 'text-purple-600/80',
                    summary : 'Search for people that speak & write in one or more languages.',
                }, {
                    name    : 'Remote',
                    icon    : 'house-laptop',
                    color   : 'text-teal-600',
                    summary : 'Search for candidates that are prepared to work from home.',
                }, {
                    name    : 'Degree',
                    icon    : 'graduation-cap',
                    color   : 'text-sky-600',
                    summary : 'Search for professionals that possess college education.',
                }, {
                    name    : 'Emigrate',
                    icon    : 'plane',
                    color   : 'text-lime-600',
                    summary : 'Find candidates that are prepared to emigrate for your vacancy.',
                }, {
                    name    : 'Tech Stack',
                    icon    : 'layer-group',
                    color   : 'text-indigo-600',
                    summary : 'Find candidates with the exact skills and experience you need.',
                },{
                    name    : 'Smart Matching',
                    icon    : 'cog',
                    color   : 'text-gray-600',
                    summary : 'Automatic filters for essentials such as commute and availability.',
                },
            ],
        }},
    }
</script>