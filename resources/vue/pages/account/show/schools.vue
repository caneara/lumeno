<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Description (Empty) -->
        <p v-if="blank(prop('account.schools'))">
            {{ prop('account.name') }} has not added any education history.
        </p>

        <!-- Description (Not Empty) -->
        <p v-if="filled(prop('account.schools'))">
            Review the record of {{ prop('account.name') }}'s education. Note
            that Lumeno does not verify any of the information supplied. If you
            are considering this person for a position, then you will need to
            verify their résumé yourself.
        </p>

        <!-- Timeline -->
        <div :key="i"
             class="relative group first-of-type:mt-10"
             v-for="(year, i) in Object.keys(prop('account.schools')).sort((a, b) => b - a).map(k => prop(`account.schools.${k}`))">

            <!-- Period -->
            <div class="flex items-start">

                <!-- Year -->
                <div class="flex justify-center items-center h-50px min-w-50px bg-yellow-600/25 rounded-full">
                    <span class="font-semibold text-14px text-amber-800">
                        {{ year[0].started_at.substring(0, 4) }}
                    </span>
                </div>

                <!-- Schools -->
                <div class="pt-3 ml-6 md:ml-8">
                    <div v-for="(school, index) in year">

                        <!-- Course -->
                        <div class="font-semibold text-gray-800 leading-normal mb-6px">
                            {{ school.course }}
                        </div>

                        <!-- Dates -->
                        <span class="block text-14px text-gray-600 mb-6">

                            <!-- Start -->
                            {{ date(school.started_at) }}

                            <!-- End -->
                            {{ school.finished_at ? ` - ${date(school.finished_at)}` : ' - Present' }}

                        </span>

                        <!-- Grade -->
                        <v-pill class="mb-3"
                                :color="school.finished_at ? 'green' : 'blue'"
                                :text="prop('qualifications').find(item => item.id === school.qualification).name"
                                :title="school.finished_at ? 'The user has graduated' : 'This user has not graduated'">
                        </v-pill>

                        <!-- Name -->
                        <span class="block text-15px text-gray-700 mb-1">
                            {{ school.name }}
                        </span>

                        <!-- Location -->
                        <span class="block text-15px text-gray-700 leading-normal"
                              :class="index === year.length - 1 ? 'mb-10 group-last-of-type:mb-0' : 'mb-0 md:-mb-2'">

                            <!-- Text -->
                            {{ school.location }}

                        </span>

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
    import PillComponent from '@/components/pill.vue';
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
            'v-pill'  : PillComponent,
        },
    }
</script>