<template>
    <div class="bg-sky-50 border-t border-gray-200 flex justify-center">
        <div class="container flex flex-col lg:flex-row px-0 pt-0 pb-5 md:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-200/50 absolute inset-0 rounded-xl rotate-12 scale-72"></div>
                <div class="bg-yellow-600/80 absolute inset-0 rounded-xl -rotate-12 scale-72"></div>

                <!-- Article -->
                <div class="bg-white border border-gray-400/75 rounded-md w-full scale-85 relative p-10 pb-2">

                    <!-- Title -->
                    <h4 class="mb-1">
                        Increase query performance with indexing
                    </h4>

                    <!-- Subtitle -->
                    <p class="text-14px text-gray-600 mb-4">

                        <!-- Icon -->
                        <i class="fas fa-user text-10px text-emerald-600/80 relative -top-1px mr-6px"></i>

                        <!-- Author -->
                        <span class="text-gray-600 mr-5">
                            John Doe
                        </span>

                        <!-- Icon -->
                        <i class="fas fa-at text-10px text-sky-600/80 relative -top-1px mr-1"></i>

                        <!-- Handle -->
                        <span class="text-gray-600/80 mr-5">
                            @JohnDoe
                        </span>

                        <!-- Icon -->
                        <i class="fas fa-calendar-alt text-10px text-purple-600/60 relative -top-1px mr-2"></i>

                        <!-- Date -->
                        <span class="text-gray-600/80 mr-5">
                            Mar 18th, 2022
                        </span>

                    </p>

                    <!-- Summary -->
                    <p class="text-15px text-gray-700/80 clamp two-lines">
                        In this article, we'll review how using indexing, both simple and composite,
                        can drastically improve database query performance.
                    </p>

                    <!-- Tags -->
                    <div class="flex flex-wrap border-b border-gray-400/50 pb-6 mb-10">

                        <!-- Tag -->
                        <div :key="tag"
                             v-for="tag in tags">

                            <!-- Pill -->
                            <div class="bg-sky-100/70 font-medium text-11px text-sky-800 uppercase rounded-full cursor-pointer px-2 py-1 mr-2">
                                {{ tag }}
                            </div>

                        </div>

                    </div>

                    <!-- Markdown -->
                    <v-reader :content="markdown"></v-reader>

                </div>

            </div>

            <!-- Right -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-11 md:mt-3 lg:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-purple-600/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Community
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-28px xl:text-30px text-center lg:text-left mb-8">
                    Write and share great content
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Engage with the community and grow your own personal following
                    by hosting articles on anything tech related. From tips,
                    tricks and how-to guides, to work journals, to the latest
                    tools &amp; features.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    As an added bonus, businesses and recruiters can also review
                    your work in order to get a better idea of your experience, as
                    well as your overall writing abilities&hellip; an essential
                    skill for the modern professional.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Upload -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="articles1">
                                        <stop stop-color="#10b981" offset="0" />
                                        <stop stop-color="#22c55e" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#articles1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-image text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Upload
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Share relevent images directly with our CDN
                            </span>

                        </div>

                    </div>

                    <!-- Code -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="articles2">
                                        <stop stop-color="#fb923c" offset="0" />
                                        <stop stop-color="#db2777" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#articles2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-code text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Code
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Embed snippets with syntax highlighting
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import MarkdownReaderComponent from '@/components/reader.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link'   : LinkComponent,
            'v-reader' : MarkdownReaderComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            tags     : ['Database', 'MySQL', 'Indexing'],
            markdown : "```sql\r\nCREATE TABLE `articles` (\r\n  `id` char(36) NOT NULL,\r\n  `title` varchar(100) NOT NULL,\r\n  `content` mediumtext NOT NULL,\r\n  PRIMARY KEY (`id`),\r\n  KEY `articles_title_index` (`title`),\r\n);\r\n```",
        }},
    }
</script>