<template>
    <div class="bg-white border-t border-gray-200 flex justify-center">
        <div class="container flex flex-col-reverse lg:flex-row px-0 pt-0 pb-5 md:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-11 md:mt-3 lg:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-teal-600/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Exceptional
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-27px xl:text-30px text-center lg:text-left mb-8">
                    Showcase what you're working on
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Stand out from the crowd with projects&hellip; a collection of
                    your latest work and greatest achievements. From open-source
                    repositories to client apps and tech research. It's all
                    available for others to see.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    Projects don't have to exist purely to entice employers though.
                    You can use them to document your greatest hits, demonstrate
                    your ongoing commitments, or even attract future collaborators.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Logo -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="projects1">
                                        <stop stop-color="#2563eb" offset="0" />
                                        <stop stop-color="#0ea5e9" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#projects1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-images text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Gallery
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Upload logos, photos and screenshots
                            </span>

                        </div>

                    </div>

                    <!-- Tags -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="projects2">
                                        <stop stop-color="#10b981" offset="0" />
                                        <stop stop-color="#22c55e" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#projects2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-tags text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Tags
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Easily clarify areas of project focus
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right -->
            <div class="flex items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-100/80 absolute inset-0 rounded-xl -rotate-12 scale-72"></div>
                <div class="bg-purple-600/80 absolute inset-0 rounded-xl rotate-12 scale-72"></div>

                <!-- Projects -->
                <div class="scale-85">

                    <!-- Project -->
                    <div :key="project.name"
                         v-for="project in projects"
                         class="bg-white border border-gray-400/75 rounded-md relative first-of-type:rounded-b-none first-of-type:border-b-0 last-of-type:rounded-t-none last-of-type:border-t-gray-200 p-10">

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

                </div>

            </div>
        </div>
    </div>
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
         * Define the data model.
         *
         */
        data() { return {
            projects : [
                {
                    name     : 'Validator',
                    type     : 'Open Source Project',
                    tags     : ['JavaScript', 'HTML', 'Validation', 'ES6'],
                    summary  : 'A micro client-side validation library. It has no dependencies and can be used in isolation or as part of a framework. Also adds chainable rules, allowing you to verify that a piece of data satisfies multiple criteria.',
                    icon     : 'fa-key text-sky-600/80',
                }, {
                    name     : 'Acme Properties',
                    type     : 'Client Application',
                    tags     : ['Laravel', 'PHP', 'Tailwind', 'Vue'],
                    summary  : 'A content-management and customer-relationship platform to support the back-end operations of a real-estate company selling luxury properties within the Los Angeles, San Francisco and San Diego areas.',
                    icon     : 'fa-home text-teal-600',
                },
            ],
        }},
    }
</script>