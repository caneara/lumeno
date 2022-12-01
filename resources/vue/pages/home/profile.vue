<template>
    <div class="lg:flex lg:justify-between flex-1 container h-full">

        <!-- Left Panel -->
        <article class="content w-full xl:pl-6">

            <!-- Overview -->
            <div class="flex items-start mb-10 md:mb-7 lg:mb-8 xl:mb-12">

                <!-- Avatar -->
                <div class="image w-100px h-100px min-w-100px min-h-100px max-w-100px max-h-100px rounded-full">
                    <img style="object-position: -30px 0"
                         class="w-100px h-100px min-w-100px min-h-100px max-w-100px max-h-100px rounded-full object-cover"
                         src="https://images.unsplash.com/photo-1564564244660-5d73c057f2d2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80">
                </div>

                <!-- Profile -->
                <div class="ml-6 md:ml-9">

                    <!-- Name -->
                    <h4 class="mb-2px">
                        David Harper
                    </h4>

                    <!-- Handle -->
                    <span class="block text-15px text-gray-500 mb-6">
                        @DavidHarper
                    </span>

                    <!-- Location -->
                    <span class="block text-15px text-gray-700 mb-2">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-map-marker-alt text-13px text-red-700/70 -ml-9px"></i>

                        <!-- Text -->
                        Palo Alto, California

                    </span>

                    <!-- Country -->
                    <span class="block text-15px text-gray-700 mb-2">

                        <!-- Icon -->
                        <span class="flag text-14px mr-2">🇺🇸</span>

                        <!-- Text -->
                        <span class="country">
                            United States / UTC-8
                        </span>

                    </span>

                    <!-- Languages -->
                    <span class="block text-15px text-gray-700 mb-6">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-language text-13px text-emerald-600/70 -ml-9px"></i>

                        <!-- Text -->
                        English, Spanish

                    </span>

                    <!-- Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-x-6 gap-y-2">

                        <!-- Website -->
                        <span class="block text-15px text-gray-700">

                            <!-- Icon -->
                            <i class="fa-fw fas fa-globe text-13px text-orange-600/70 -ml-9px"></i>

                            <!-- Link -->
                            <a class="pointer-events-none">
                                harper.me
                            </a>

                        </span>

                        <!-- Github -->
                        <span class="block text-15px text-gray-700">

                            <!-- Icon -->
                            <i class="fab fa-fw fa-github text-13px text-gray-600/70 -ml-9px"></i>

                            <!-- Link -->
                            <a class="pointer-events-none">
                                dharper
                            </a>

                        </span>

                        <!-- Twitter -->
                        <span class="block text-15px text-gray-700">

                            <!-- Icon -->
                            <i class="fab fa-fw fa-twitter text-13px text-sky-600/70 -ml-9px"></i>

                            <!-- Link -->
                            <a class="pointer-events-none">
                                DavidH
                            </a>

                        </span>

                        <!-- LinkedIn -->
                        <span class="block text-15px text-gray-700">

                            <!-- Icon -->
                            <i class="fab fa-fw fa-linkedin text-13px text-blue-800/70 -ml-9px"></i>

                            <!-- Link -->
                            <a class="pointer-events-none">
                                david.harper
                            </a>

                        </span>

                        <!-- YouTube -->
                        <span class="block text-15px text-gray-700">

                            <!-- Icon -->
                            <i class="fa-fw fas fa-play-circle text-13px text-red-700/60 -ml-9px"></i>

                            <!-- Link -->
                            <a class="pointer-events-none">
                                DevTutorials
                            </a>

                        </span>

                    </div>

                </div>

            </div>

            <!-- Tabs -->
            <div class="flex items-end overflow-x-auto md:-mb-6">

                <!-- Tab -->
                <div class="whitespace-nowrap select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-user text-sky-600 mr-4"></i>

                        <!-- Text -->
                        <span class="text-sky-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Statement
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-sky-600/80"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-sky-600/80"></div>

                </div>

                <!-- Tab -->
                <div class="whitespace-nowrap select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-tools text-gray-500/65"></i>

                        <!-- Text -->
                        <span class="text-gray-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Skills
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-gray-300"></div>

                </div>

                <!-- Tab -->
                <div class="whitespace-nowrap md:hidden lg:block select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-briefcase text-gray-500/65"></i>

                        <!-- Text -->
                        <span class="text-gray-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Employment
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-gray-300"></div>

                </div>

                <!-- Tab -->
                <div class="whitespace-nowrap md:hidden lg:block select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-graduation-cap text-gray-500/65"></i>

                        <!-- Text -->
                        <span class="text-gray-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Education
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-gray-300"></div>

                </div>

                <!-- Tab -->
                <div class="whitespace-nowrap select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-cube text-gray-500/65"></i>

                        <!-- Text -->
                        <span class="text-gray-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Projects
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-gray-300"></div>

                </div>

                <!-- Tab -->
                <div class="whitespace-nowrap xl:hidden select-none transition duration-300 relative z-1">

                    <!-- Content -->
                    <div class="px-4 py-3 md:px-3 md:mx-1">

                        <!-- Icon -->
                        <i class="fas text-20px lg:text-13px transition duration-300 mr-3 fa-newspaper text-gray-500/65"></i>

                        <!-- Text -->
                        <span class="text-gray-600 font-semibold text-13px uppercase transition duration-300 relative -top-2px lg:top-0">
                            Articles
                        </span>

                    </div>

                    <!-- Border -->
                    <div class="w-full h-1px transition duration-300 relative z-1"></div>
                    <div class="w-full h-1px transition duration-300 relative z-1 bg-gray-300"></div>

                </div>

                <!-- Border -->
                <div class="w-full h-1px bg-gray-300 rounded-lg relative z-2"></div>

            </div>

            <!-- Statement -->
            <p class="clamp three-lines pt-16">
                My fascination with technology was sparked when, as a child I thought it would be a
                great idea to take apart my Playstation console. Aware of the danger, I was still
                eager to see how it all worked inside. I find it intriguing how fast society has
                been shaped and continues to be, by the influence of Computer Science. A few years
                ago if someone were to have claimed that cars would become autonomous, people would
                have doubted them.
            </p>

        </article>

        <!-- Sidebar -->
        <aside class="sidebar hidden xl:block w-250px min-w-250px max-w-250px overflow-y-auto ml-75px">

            <!-- Title -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Activity
            </span>

            <!-- Articles -->
            <div class="statistic mb-6 flex items-center">

                <!-- Icon -->
                <i class="fa-fw text-15px mr-3 -ml-6px text-gray-500 fa-newspaper fas"></i>

                <!-- Text -->
                <span class="text-15px font-medium text-gray-700">
                    19 articles
                </span>

            </div>

            <!-- Projects -->
            <div class="statistic mb-6 flex items-center">

                <!-- Icon -->
                <i class="fa-fw text-15px mr-3 -ml-6px text-gray-500 fa-cubes fas"></i>

                <!-- Text -->
                <span class="text-15px font-medium text-gray-700">
                    5 projects
                </span>

            </div>

            <!-- Actions -->
            <div class="actions border-t border-gray-300/70 pt-9 mt-9">

                <!-- Share -->
                <div class="mb-7 flex items-center">

                    <!-- Icon -->
                    <i class="fas fa-fw -ml-6px text-15px opacity-80 text-emerald-600/70 fa-external-link-alt"></i>

                    <!-- Content -->
                    <div class="ml-3">

                        <!-- Text -->
                        <span class="block text-15px font-semibold text-gray-800">
                            Share profile
                        </span>

                        <!-- Summary -->
                        <span class="text-13px text-gray-600 block mt-6px">
                            Tell others about this person
                        </span>

                    </div>

                </div>

                <!-- Articles -->
                <div class="mb-7 flex items-center">

                    <!-- Icon -->
                    <i class="fas fa-fw -ml-6px text-15px opacity-80 text-sky-600/70 fa-newspaper"></i>

                    <!-- Content -->
                    <div class="ml-3">

                        <!-- Text -->
                        <span class="block text-15px font-semibold text-gray-800">
                            View articles
                        </span>

                        <!-- Summary -->
                        <span class="text-13px text-gray-600 block mt-6px">
                            Read their latest content
                        </span>

                    </div>

                </div>

            </div>
        </aside>
    </div>

</template>