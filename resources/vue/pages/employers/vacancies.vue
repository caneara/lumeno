<template>
    <div class="flex justify-center">

        <!-- Container -->
        <div class="container flex flex-col lg:flex-row px-0 pt-0 pb-5 md:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-100/80 absolute inset-0 rounded-xl rotate-12 scale-72"></div>
                <div class="bg-teal-600/80 absolute inset-0 rounded-xl -rotate-12 scale-72"></div>

                <!-- Candidates -->
                <v-list :items="users"
                        class="bg-white w-full scale-85 relative">

                    <!-- Left -->
                    <template v-slot:left="{ item }">
                        <div class="flex items-start w-full px-2 pt-4 md:pb-4">

                            <!-- Avatar -->
                            <img :src="item.avatar"
                                 class="w-60px h-60px object-cover rounded-md mr-6" />

                            <!-- Profile -->
                            <div class="w-full">

                                <!-- Header -->
                                <div class="flex items-center">

                                    <!-- Name -->
                                    <h5 class="font-semibold text-18px clamp one-line mb-0 mr-4">
                                        {{ item.name }}
                                    </h5>

                                    <!-- Invited -->
                                    <v-pill class="relative top-1px"
                                            :color="item.invited ? 'green' : 'blue'"
                                            :text="item.invited ? 'Invited' : 'Not Yet Invited'">
                                    </v-pill>

                                </div>

                                <!-- Area -->
                                <span class="block text-15px text-gray-700 clamp one-line mt-4 mb-6px">

                                    <!-- Icon -->
                                    <i class="fa-fw fas fa-map-marker-alt text-13px text-red-700/70 -ml-9px mr-1"></i>

                                    <!-- Text -->
                                    {{ item.area }}

                                </span>

                                <!-- Country -->
                                <span class="block text-15px text-gray-700 mb-2">

                                    <!-- Icon -->
                                    <span class="flag text-14px mr-3">
                                        {{ item.flag }}
                                    </span>

                                    <!-- Text -->
                                    <span class="country">
                                        {{ item.country }}
                                    </span>

                                </span>

                                <!-- Languages -->
                                <span class="block text-15px text-gray-700 mb-6">

                                    <!-- Icon -->
                                    <i class="fa-fw fas fa-language text-13px text-emerald-600/70 -ml-9px mr-1"></i>

                                    <!-- Text -->
                                    {{ item.languages }}

                                </span>

                                <!-- Statement -->
                                <p class="clamp two-lines mb-0">
                                    {{ item.statement }}
                                </p>

                            </div>

                        </div>
                    </template>

                </v-list>

            </div>

            <!-- Right -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-11 md:mt-3 lg:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-sky-500/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Simple
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-28px xl:text-30px text-center lg:text-left mb-8">
                    Create vacancies in minutes
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Say goodbye to blinking cursors on a blank page. With Lumeno,
                    it's a breath of fresh air. Just fill in a few fields to cover
                    the basics, add your technical requirements, then hit save. It
                    really is that simple.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    Lumeno will immediately show you a ranked list of every
                    professional that meets your needs. Simply review their
                    profiles and have Lumeno contact them. No more praying
                    the right candidate sees your listing.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Profiles -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="vacancies1">
                                        <stop stop-color="#a855f7" offset="0" />
                                        <stop stop-color="#f472b6" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#vacancies1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-user text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 mr:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Profiles
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                View user résumés, projects and articles
                            </span>

                        </div>

                    </div>

                    <!-- Bulk -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="vacancies2">
                                        <stop stop-color="#14b8a6" offset="0" />
                                        <stop stop-color="#22c55e" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#vacancies2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-envelopes-bulk text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 mr:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Invitations
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Reach many qualified people in seconds
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
            users : [
                {
                    avatar    : 'https://images.unsplash.com/photo-1542909168-6296a31d7689?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80',
                    name      : 'Rajesh Putera',
                    invited   : true,
                    area      : 'Irvine, California - 17 KM away',
                    flag      : '🇺🇸',
                    country   : 'United States of America',
                    languages : 'English, Hindi',
                    statement : 'My fascination with technology was sparked when, as a child, I thought it would be a great idea to take apart my Playstation console.',
                }, {
                    avatar    : 'https://images.unsplash.com/photo-1618938700817-fe48bd93f20b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80',
                    name      : 'Alice Smith',
                    invited   : false,
                    area      : 'Anaheim, California - 32 KM away',
                    flag      : '🇺🇸',
                    country   : 'United States of America',
                    languages : 'English, Spanish',
                    statement : 'I understand that computer science is not just about programming and hardware but also about the ethics entailed in the process of a design as well as innovative thinking',
                },
            ],
        }},
    }
</script>