<template>
    <div class="bg-sky-50 border-t border-gray-200 flex justify-center">
        <div class="container flex flex-col lg:flex-row px-0 pt-0 pb-5 md:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-200/50 absolute inset-0 rounded-xl rotate-12 scale-72"></div>
                <div class="bg-teal-600/80 absolute inset-0 rounded-xl -rotate-12 scale-72"></div>

                <!-- Skills -->
                <v-list :items="skills"
                        class="bg-white w-full scale-85 relative">

                    <!-- Left -->
                    <template v-slot:left="{ item }">
                        <div class="w-full pr-10">

                            <!-- Name -->
                            <span class="block font-semibold text-15px text-gray-800/85 my-6px">
                                {{ item.tool }}
                            </span>

                            <!-- Category -->
                            <span class="block text-15px text-gray-600/75 break-all">
                                {{ item.category }}
                            </span>

                            <!-- Summary -->
                            <span class="block text-15px text-gray-700/80 leading-normal mt-3 mb-1">
                                {{ item.summary }}
                            </span>

                        </div>
                    </template>

                    <!-- Right -->
                    <template v-slot:right="{ item }">

                        <!-- Experience -->
                        <v-pill class="mr-1"
                                :text="metric(item.years, 'year')"
                                :color="item.years <= 1 ? 'red' : item.years <= 2 ? 'yellow' : 'green'">
                        </v-pill>

                    </template>

                </v-list>

            </div>

            <!-- Right -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-16 md:mt-10 lg:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-sky-500/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Modern
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-28px xl:text-30px text-center lg:text-left mb-8">
                    Say hello to searchable résumés
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Forget archaic PDFs filled with unparsable blocks of text.
                    Résumés on Lumeno are rich, structured documents driven by
                    your experience with design tools, programming languages,
                    DevOps utilities, and more.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    Résumés also include private settings to ensure you are only
                    contacted about vacancies that satisfy your requirements.
                    From salary and skills to time commitment and commute distance.
                    You're in complete control.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Workplaces -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="resume1">
                                        <stop stop-color="#a855f7" offset="0" />
                                        <stop stop-color="#f472b6" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#resume1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-briefcase text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Workplaces
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Maintain a timeline of your employment
                            </span>

                        </div>

                    </div>

                    <!-- Schools -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="resume2">
                                        <stop stop-color="#14b8a6" offset="0" />
                                        <stop stop-color="#22c55e" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#resume2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-university text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Education
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Record your academic achievements
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import ListComponent from '@/components/list.vue';
    import PillComponent from '@/components/pill.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-list' : ListComponent,
            'v-pill' : PillComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            skills : [
                {
                    tool     : 'JavaScript',
                    category : 'Programming Languages',
                    years    : 4,
                    summary  : 'Extensive experience with NodeJS. Familiarity with most common build tools including Webpack.',
                }, {
                    tool     : 'Figma',
                    category : 'Design Tools',
                    years    : 2,
                    summary  : 'Experienced at interface protoyping. Competent with designing shapes, polygons and using frames.',
                }, {
                    tool     : 'MySQL',
                    category : 'Database Servers',
                    years    : 1,
                    summary  : 'Capable of constructing most common queries. Currently learning about optimization and indexing.',
                },
            ],
        }},
    }
</script>