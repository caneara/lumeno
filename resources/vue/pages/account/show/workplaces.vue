<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Description (Empty) -->
        <p v-if="blank(prop('account.workplaces'))">
            {{ prop('account.name') }} has not added any employment history.
        </p>

        <!-- Description (Not Empty) -->
        <p v-if="filled(prop('account.workplaces'))">
            Review the record of {{ prop('account.name') }}'s employment. Note
            that Lumeno does not verify any of the information supplied. If you
            are considering this person for a position, then you will need to
            verify their résumé yourself.
        </p>

        <!-- Timeline -->
        <div :key="i"
             class="relative group first-of-type:mt-10"
             v-for="(year, i) in Object.keys(prop('account.workplaces')).sort((a, b) => b - a).map(k => prop(`account.workplaces.${k}`))">

            <!-- Period -->
            <div class="flex items-start">

                <!-- Year -->
                <div class="flex justify-center items-center h-50px min-w-50px bg-yellow-600/25 rounded-full">
                    <span class="font-semibold text-14px text-amber-800">
                        {{ year[0].started_at.substring(0, 4) }}
                    </span>
                </div>

                <!-- Workplaces -->
                <div class="pt-3 ml-6 md:ml-8">
                    <div v-for="(workplace, index) in year">

                        <!-- Role -->
                        <span class="block font-semibold text-gray-800 mb-6px leading-normal">
                            {{ workplace.role }}
                        </span>

                        <!-- Dates -->
                        <span class="block text-14px text-gray-600 mb-6">

                            <!-- Start -->
                            {{ date(workplace.started_at) }}

                            <!-- End -->
                            {{ workplace.finished_at ? ` - ${date(workplace.finished_at)}` : ' - Present' }}

                        </span>

                        <!-- Employer -->
                        <span class="block text-15px text-gray-700 mb-2">

                            <!-- Icon -->
                            <i class="fas fa-fw fa-briefcase text-13px text-teal-700/80 opacity-70 -ml-2 mr-2px"></i>

                            <!-- Text -->
                            {{ workplace.employer }}

                        </span>

                        <!-- Location -->
                        <span class="block text-15px text-gray-700 mb-6">

                            <!-- Icon -->
                            <i class="fas fa-fw fa-map-location-dot text-13px text-sky-700/80 opacity-70 -ml-2 mr-2px"></i>

                            <!-- Text -->
                            {{ workplace.location }}

                        </span>

                        <!-- Summary -->
                        <p class="whitespace-pre-wrap"
                           :class="index === year.length - 1 ? 'mb-10 group-last-of-type:mb-0' : 'mb-0 md:-mb-2'">

                            <!-- Text -->
                            {{ workplace.summary }}

                        </p>

                        <!-- Divider -->
                        <div class="mb-12 md:mb-14"
                             v-if="index !== year.length - 1">
                        </div>

                    </div>
                </div>

            </div>

            <!-- Connector -->
            <div class="border-l-2 border-gray-400/65 rounded absolute top-[58px] bottom-0 left-24px mb-8px group-last-of-type:mb-0"></div>

        </div>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
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
            'v-panel' : PanelComponent,
        },
    }
</script>