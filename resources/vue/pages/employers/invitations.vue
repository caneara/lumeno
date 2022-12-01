<template>
    <div class="border-t border-gray-200 flex justify-center">

        <!-- Container -->
        <div class="container flex flex-col lg:flex-row px-0 pt-0 pb-5 md:py-20 xl:py-30">

            <!-- Left -->
            <div class="flex items-center w-full lg:w-1/2 pointer-events-none scale-85 md:scale-100 relative md:p-10">

                <!-- Wallpaper -->
                <div class="bg-gray-100/80 absolute inset-0 rounded-xl -rotate-12 scale-72"></div>
                <div class="bg-sky-600/80 absolute inset-0 rounded-xl rotate-12 scale-72"></div>

                <!-- Invitation -->
                <div class="bg-white rounded-b-md scale-85">

                    <!-- Border -->
                    <div class="h-10px rounded-t"
                         style="background: linear-gradient(-45deg, #f25953 0%, #f25953 12.5%, #fff 12.5%, #fff 25%, #5590d6 25%, #5590d6 37.5%, #fff 37.5%, #fff 50%, #f25953 50%, #f25953 62.5%, #fff 62.5%, #fff 75%, #5590d6 75%, #5590d6 87.5%, #fff 87.5%, #fff 100% ); background-size: 80px 80px; background-position: 0 -20px">
                    </div>

                    <!-- Header -->
                    <div class="border-x border-gray-400/75 flex justify-between items-start p-10 pb-0">

                        <!-- Content -->
                        <div class="pr-6">

                            <!-- Title -->
                            <h1 class="text-18px mb-20px">
                                Vacancy Invitation
                            </h1>

                            <!-- Introduction -->
                            <p>
                                Great news! Acme Products has invited you to apply for the
                                following position that they have available:
                            </p>

                        </div>

                        <!-- Stamp -->
                        <div class="flex-none">

                            <!-- Image -->
                            <img :src="asset('img/logo.png')"
                                 style="border: dashed 2px #ddd"
                                 class="h-60px w-60px opacity-40 p-3" />

                        </div>

                    </div>

                    <!-- Content -->
                    <div class="border border-t-0 border-gray-400/75 rounded-b-md px-10">

                        <!-- Role -->
                        <h2 class="font-normal text-17px text-sky-700 mb-6">
                            Web Developer
                        </h2>

                        <!-- Commitment -->
                        <span class="flex items-center mb-2px">

                            <!-- Icon -->
                            <img class="h-12px"
                                 :src="asset('img/icons/calendar.png')" />

                            <!-- Detail -->
                            <p class="text-15px pl-10px mb-0">
                                Full Time
                            </p>

                        </span>

                        <!-- Remuneration -->
                        <span class="flex items-center mb-2px">

                            <!-- Icon -->
                            <img class="h-12px"
                                 :src="asset('img/icons/coins.png')" />

                            <!-- Detail -->
                            <p class="text-15px pl-10px mb-0">
                                140,000 USD
                            </p>

                        </span>

                        <!-- Location -->
                        <span class="flex items-center mb-2px">

                            <!-- Icon -->
                            <img class="h-12px"
                                 :src="asset('img/icons/globe.png')" />

                            <!-- Detail -->
                            <p class="text-15px pl-10px mb-0">
                                San Francisco, USA (38 KM)
                            </p>

                        </span>

                        <!-- Subheader -->
                        <h3 class="font-medium text-13px text-gray-600 uppercase mt-30px mb-2">
                            Summary
                        </h3>

                        <!-- Summary -->
                        <p class="text-14px clamp two-lines">
                            This exciting opportunity will involve you designing and building key
                            systems to support our primary business of providing educational platforms
                            for universities.
                        </p>

                        <!-- Requirements -->
                        <table style="margin: 30px auto 35px; width: 100%; border-spacing: 0">
                            <thead>
                                <tr>
                                    <th style="box-sizing: border-box; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; text-align: left; color: #8795A1">
                                        Tool
                                    </th>
                                    <th style="box-sizing: border-box; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; text-align: left; color: #8795A1">
                                        Experience
                                    </th>
                                    <th align="center" style="box-sizing: border-box; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; color: #8795A1; text-align: center">
                                        Required
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px; padding-top: 15px">
                                        PHP
                                    </td>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px; padding-top: 15px">
                                        4 years
                                    </td>
                                    <td align="center" style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px; padding-top: 15px">
                                        <span style="box-sizing: border-box; border-radius: 10px; padding: 2px 12px 1px; font-family: Arial, sans-serif; font-weight: 600; font-size: 11px; text-align: center; text-transform: uppercase; display: inline-block; color: #d88453">
                                            Yes
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        Laravel
                                    </td>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        3 years
                                    </td>
                                    <td align="center" style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        <span style="box-sizing: border-box; border-radius: 10px; padding: 2px 12px 1px; font-family: Arial, sans-serif; font-weight: 600; font-size: 11px; text-align: center; text-transform: uppercase; display: inline-block; color: #d88453">
                                            Yes
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        Mandrake Linux
                                    </td>
                                    <td style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        1 year
                                    </td>
                                    <td align="center" style="background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 6px 15px">
                                        <span style="box-sizing: border-box; border-radius: 10px; padding: 2px 12px 1px; font-family: Arial, sans-serif; font-weight: 600; font-size: 11px; text-align: center; text-transform: uppercase; display: inline-block; color: #5fa784">
                                            No
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <!-- Right -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-10 -mt-11 md:mt-3 lg:mt-0">

                <!-- Subliminal -->
                <span class="font-bold text-12px text-red-600/55 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                    Targeted
                </span>

                <!-- Teaser -->
                <h2 class="text-black text-27px lg:text-25px xl:text-30px text-center lg:text-left mb-8">
                    Reach candidates the right way
                </h2>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0">
                    Lumeno abandons the archaic job board and instead puts you in
                    the driving seat. Your vacancy already does the heavy lifting,
                    leaving you to explore and contact your preferred candidates.
                </p>

                <!-- Summary -->
                <p class="text-17px xl:text-18px text-gray-700/85 text-center lg:text-left md:px-16 lg:px-0 mb-10 lg:mb-6 xl:mb-10">
                    Lumeno will then send a rich email containing everything the
                    candidate needs to make a decision. If the job looks good to them,
                    then all they have to do to reach you, is click reply.
                    It couldn't be easier.
                </p>

                <!-- Features -->
                <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row md:justify-center lg:justify-start relative md:left-4pc lg:left-0">

                    <!-- Checklist -->
                    <div class="flex items-center w-full md:w-2/5 lg:w-full xl:w-1/2 md:pr-2 lg:pr-0 xl:pr-2 mb-4 md:mb-0 lg:mb-2 xl:mb-0">

                        <!-- Graphic -->
                        <div class="opacity-90 relative">

                            <!-- Blob -->
                            <svg viewBox="0 0 200 200"
                                 class="w-60px h-60px xl:w-80px xl:h-80px">

                                <!-- Gradient -->
                                <defs>
                                    <linearGradient id="invitations1">
                                        <stop stop-color="#14b8a6" offset="0" />
                                        <stop stop-color="#22c55e" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#invitations1)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-list-check text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Complete
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                The full vacancy in a single, beautiful email
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
                                    <linearGradient id="invitations2">
                                        <stop stop-color="#fb923c" offset="0" />
                                        <stop stop-color="#db2777" offset="1" />
                                    </linearGradient>
                                </defs>

                                <!-- Object -->
                                <path fill="url(#invitations2)"
                                      transform="translate(100 100)"
                                      d="M62.4,-37.6C74.2,-15.6,72.5,12.7,59.9,35.2C47.2,57.8,23.6,74.7,0.5,74.4C-22.6,74.2,-45.2,56.7,-58.4,33.7C-71.7,10.8,-75.5,-17.5,-64.2,-39.2C-52.9,-60.9,-26.4,-76,-0.6,-75.7C25.3,-75.3,50.6,-59.6,62.4,-37.6Z" />

                            </svg>

                            <!-- Icon -->
                            <div class="flex justify-center items-center absolute inset-0">
                                <i class="fas fa-envelopes-bulk text-white text-18px xl:text-23px relative -top-1px"></i>
                            </div>

                        </div>

                        <!-- Explanation -->
                        <div class="pl-3 md:pr-6">

                            <!-- Header -->
                            <h5 class="font-sans text-16px text-sky-700 tracking-normal mb-1">
                                Bulk
                            </h5>

                            <!-- Text -->
                            <span class="text-15px text-gray-600 leading-normal">
                                Reach hundreds of candidates at once
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>