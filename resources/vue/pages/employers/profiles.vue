<template>
    <div class="bg-sky-50 border-t border-gray-200 flex justify-center">
        <div class="container flex flex-col-reverse lg:flex-row px-0 pt-4 pb-5 md:pt-14 md:pb-20 lg:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-6 md:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-teal-600/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Detailed
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-27px xl:text-30px text-center lg:text-left mb-8">
                    Discover people not paperwork
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Unlike traditional résumés, which are mostly sets of statistics,
                    Lumeno's users are also able to share a portfolio of projects and
                    written articles. This material helps you to decide whether to
                    contact a candidate.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    Projects allow you to discover a person's tech interests, past work,
                    and capabilities, while articles provide a means of examining a
                    candidate's knowledge and written skills. As such, they are great
                    screening tools.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Projects -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="profiles1">
                                        <stop stop-color="#2563eb" offset="0" />
                                        <stop stop-color="#0ea5e9" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#profiles1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-cube text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Projects
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Explore and match with user tech interests
                            </span>

                        </div>

                    </div>

                    <!-- Articles -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="profiles2">
                                        <stop stop-color="#d97706" offset="0" />
                                        <stop stop-color="#eab308" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#profiles2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-newspaper text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Articles
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Review written ability and experience
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right -->
            <div class="flex justify-center items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-200/50 absolute inset-0 rounded-xl -rotate-12 scale-72 md:scale-62 lg:scale-72"></div>
                <div class="bg-violet-600/80 absolute inset-0 rounded-xl rotate-12 scale-72 md:scale-62 lg:scale-72"></div>

                <!-- Profiles -->
                <div class="bg-white border border-gray-400/75 rounded-md scale-80 md:scale-85 relative overflow-hidden">

                    <!-- Projects -->
                    <div :key="project.name"
                         :class="project.styles"
                         v-for="project in projects"
                         class="bg-white border border-gray-400/75 max-w-450px rounded-md absolute p-10">

                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">

                            <!-- Detail -->
                            <div class="flex items-center">

                                <!-- Logo -->
                                <div class="bg-gray-100 flex justify-center items-center w-[45px] h-[45px] rounded-md mr-5">

                                    <!-- Icon -->
                                    <i :class="project.icon"
                                       class="fas text-[20px]">
                                    </i>

                                </div>

                                <!-- Overview -->
                                <div class="flex flex-col">

                                    <!-- Title -->
                                    <span class="font-inter font-semibold text-17px text-gray-900 tracking-tight leading-tight mb-0">
                                        {{ project.name }}
                                    </span>

                                    <!-- Type -->
                                    <div class="flex items-center text-14px text-gray-600 mt-1">

                                        <!-- Icon -->
                                        <i class="fas fa-code text-10px text-purple-600/70 mr-2"></i>

                                        <!-- Text -->
                                        <span class="mr-5">
                                            {{ project.type }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Summary -->
                        <p class="text-gray-800 clamp three-lines leading-normal">
                            {{ project.summary }}
                        </p>

                        <!-- Footer -->
                        <div class="flex flex-wrap justify-between">

                            <!-- Tags -->
                            <div class="flex flex-wrap">

                                <!-- Tag -->
                                <div :key="tag"
                                     v-for="tag in project.tags"
                                     class="bg-sky-100/70 font-medium text-11px text-sky-800 uppercase rounded-full px-2 py-1 mr-2">

                                    <!-- Text -->
                                    {{ tag }}

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Skills -->
                    <div :key="skill.tool"
                         :class="skill.styles"
                         v-for="skill in skills"
                         class="bg-white border border-gray-400/75 max-w-450px flex items-center rounded-md absolute p-10">

                        <!-- Left -->
                        <div class="w-full pr-10">

                            <!-- Name -->
                            <span class="block font-semibold text-15px text-gray-800/85 my-6px">
                                {{ skill.tool }}
                            </span>

                            <!-- Category -->
                            <span class="block text-15px text-gray-600/75 break-all">
                                {{ skill.category }}
                            </span>

                            <!-- Summary -->
                            <span class="block text-15px text-gray-700/80 leading-normal mt-3 mb-1">
                                {{ skill.summary }}
                            </span>

                        </div>

                        <!-- Right -->
                        <div>

                            <!-- Experience -->
                            <v-pill class="mr-1"
                                    :text="metric(skill.years, 'year')"
                                    :color="skill.years <= 1 ? 'red' : skill.years <= 2 ? 'yellow' : 'green'">
                            </v-pill>

                        </div>

                    </div>

                    <!-- First Row -->
                    <div class="hidden md:flex justify-between relative px-16 pt-16 mb-10">

                        <!-- Skills -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-purple-500 relative top-14 left-8 lg:left-3 xl:left-14">
                            <i class="fas fa-tools text-white text-25px"></i>
                        </div>

                        <!-- Projects -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-emerald-500 relative top-4">
                            <i class="fas fa-cube text-white text-25px"></i>
                        </div>

                        <!-- Schools -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-blue-500 relative top-14 right-8 lg:right-2 xl:right-14">
                            <i class="fas fa-university text-white text-25px"></i>
                        </div>

                    </div>

                    <!-- Second Row -->
                    <div class="flex justify-center items-center md:justify-start relative p-20 md:px-16 md:py-0">

                        <!-- Workplaces -->
                        <div class="hidden md:flex justify-center items-center rounded-full h-60px w-60px min-w-60px bg-yellow-500 relative left-2 lg:-ml-7 xl:ml-2">
                            <i class="fas fa-briefcase text-white text-25px"></i>
                        </div>

                        <!-- Avatar -->
                        <img style="object-position: -55px 0"
                             class="w-[180px] h-[180px] max-w-[180px] max-h-[180px] rounded-full object-cover md:mx-8"
                             src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&q=80">

                        <!-- Articles -->
                        <div class="hidden md:flex justify-center items-center rounded-full h-60px w-60px min-w-60px bg-rose-500 relative -left-2 xl:mr-2">
                            <i class="fas fa-newspaper text-white text-25px"></i>
                        </div>

                    </div>

                    <!-- Third Row -->
                    <div class="hidden md:flex justify-between relative px-16 pb-16 mt-10">

                        <!-- Articles -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-teal-500 relative -top-14 left-8 lg:left-3 xl:left-14">
                            <i class="fas fa-newspaper text-white text-25px"></i>
                        </div>

                        <!-- Projects -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-indigo-500 relative -top-4">
                            <i class="fas fa-cube text-white text-25px"></i>
                        </div>

                        <!-- Schools -->
                        <div class="flex justify-center items-center rounded-full h-60px w-60px bg-fuchsia-500 relative -top-14 right-8 lg:right-2 xl:right-14">
                            <i class="fas fa-university text-white text-25px"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
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
            'v-pill' : PillComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            projects : [
                {
                    name    : 'Validator',
                    type    : 'Open Source Project',
                    tags    : ['JavaScript', 'HTML', 'Validation'],
                    summary : 'A micro client-side validation library. It has no dependencies and can be used in isolation or as part of a framework. Validator also supports chainable rules, allowing you to verify that a piece of data satisfies multiple criteria.',
                    icon    : 'fa-key text-yellow-600/80',
                    styles  : '-left-100px -top-60px -rotate-16 scale-50 blur-sm opacity-25',
                }, {
                    name    : 'Acme Properties',
                    type    : 'Client Application',
                    tags    : ['Laravel', 'PHP', 'Tailwind'],
                    summary : 'A content-management and customer-relationship platform to support the back-end operations of a real-estate company selling luxury properties within the Los Angeles, San Francisco and San Diego areas.',
                    icon    : 'fa-home text-teal-600',
                    styles  : '-right-100px -bottom-50px rotate-16 scale-50 blur-sm opacity-25',
                },
            ],
            skills : [
                {
                    tool     : 'JavaScript',
                    category : 'Programming Languages',
                    years    : 4,
                    summary  : 'Extensive experience with NodeJS. Familiarity with most common build tools including Webpack.',
                    styles   : '-right-125px -top-30px rotate-16 scale-50 blur-sm opacity-25',
                }, {
                    tool     : 'Zeplin',
                    category : 'Design Tools',
                    years    : 5,
                    summary  : 'Experienced at interface protoyping. Competent with designing shapes, polygons and using frames.',
                    styles   : '-right-175px top-[80px] -rotate-16 scale-50 blur-sm opacity-25',
                }, {
                    tool     : 'Sketch',
                    category : 'Design Tools',
                    years    : 3,
                    summary  : 'Experienced at interface protoyping. Competent with designing shapes, polygons and using frames.',
                    styles   : '-right-175px top-[200px] rotate-16 scale-50 blur-sm opacity-25',
               }, {
                    tool     : 'Figma',
                    category : 'Design Tools',
                    years    : 2,
                    summary  : 'Experienced at interface protoyping. Competent with designing shapes, polygons and using frames.',
                    styles   : '-left-150px top-150px rotate-16 scale-50 blur-sm opacity-25',
                }, {
                    tool     : 'JavaScript',
                    category : 'Programming Languages',
                    years    : 4,
                    summary  : 'Extensive experience with NodeJS. Familiarity with most common build tools including Webpack.',
                    styles   : '-left-150px top-[235px] -rotate-16 scale-50 blur-sm opacity-25',
                }, {
                    tool     : 'MySQL',
                    category : 'Database Servers',
                    years    : 1,
                    summary  : 'Capable of constructing most common queries. Currently learning about optimization and indexing.',
                    styles   : '-left-[110px] -bottom-40px -rotate-16 scale-50 blur-sm opacity-25',
                },
            ],
        }},
    }
</script>