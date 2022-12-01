<template>
    <div class="bg-sky-1000 flex justify-center items-center relative pt-20 pb-19 md:py-24 lg:py-30">

        <!-- Graph Texture -->
        <div class="absolute inset-0 opacity-90"
             :style="`background-image: url('${asset('img/graph.svg')}'); background-position-x: -6px; background-position-y: -6px`">
        </div>

        <!-- Container -->
        <div class="flex justify-center items-center container relative">

            <!-- Left Panel -->
            <div class="max-w-400px flex flex-col items-center md:items-start">

                <!-- Teaser -->
                <h2 class="text-27px xl:text-30px text-white text-center md:text-left mb-6">
                    See it in action
                </h2>

                <!-- Supplemental -->
                <p class="text-20px text-gray-300 text-center md:text-left max-w-500px mb-10">

                    <!-- Text -->
                    Watch a demo on how to create a vacancy
                    from scratch and then contact up to 100
                    candidates&hellip;

                    <!-- Highlight -->
                    <span class="font-semibold text-amber-300">
                        all in under two minutes.
                    </span>

                </p>

                <!-- Action -->
                <div @click="window.open('https://youtu.be/OWwYtOGa_MQ')"
                     class="bg-emerald-600 hover:bg-emerald-500 text-white inline rounded-lg cursor-pointer transition duration-300 px-12 pt-3 pb-11px">

                    <!-- Icon -->
                    <i class="fas fa-play-circle text-12px relative -top-1px mr-1"></i>

                    <!-- Text -->
                    Watch Video

                </div>

            </div>

            <!-- Right Panel -->
            <div class="hidden md:block relative ml-20" style="perspective: 2000px">

                <!-- Underlay -->
                <div style="transform: rotateY(322deg)"
                     class="border-2 border-gray-600/30 w-full h-full rounded-[9px] absolute z-1 left-4 top-4">
                </div>

                <!-- Graphic -->
                <img :src="asset('img/demo.svg')"
                     style="transform: rotateY(322deg)"
                     class="lg:h-350px cursor-pointer relative z-2"
                     @click="window.open('https://youtu.be/OWwYtOGa_MQ')">

            </div>

        </div>

    </div>
</template>