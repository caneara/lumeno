<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Description (Empty) -->
        <p v-if="blank(prop('account.skills'))">
            {{ prop('account.name') }} has not added any skills.
        </p>

        <!-- Description (Not Empty) -->
        <p v-if="filled(prop('account.skills'))">
            Review the tools that {{ prop('account.name') }} has experience with.
            Note that Lumeno does not verify any of the information supplied. If
            you are considering this person for a position, then you will need
            to verify their résumé yourself.
        </p>

        <!-- Border -->
        <div v-if="filled(prop('account.skills'))"
             class="border border-gray-300 rounded-md mt-10">

            <!-- Skills -->
            <div :key="skill.id"
                 v-for="skill in prop('account.skills').sort((a, b) => b.years - a.years)"
                 class="odd:bg-white even:bg-sky-50 border-b border-gray-200 last-of-type:border-b-0
                        first-of-type:rounded-t-md last-of-type:rounded-b-md p-6 md:py-4">

                <!-- Skill -->
                <div class="flex flex-wrap justify-between items-center">

                    <!-- Left Side -->
                    <div class="flex-1 mr-6">

                        <!-- Name -->
                        <span class="block font-semibold text-gray-800 leading-normal">
                            {{ skill.tool.name }}
                        </span>

                        <!-- Category -->
                        <span class="block text-15px text-gray-600/80 leading-normal">
                            {{ prop('categories').find(item => item.id === skill.tool.category_id).name }}
                        </span>

                    </div>

                    <!-- Right Side -->
                    <div class="flex flex-col items-center relative"
                         :class="skill.summary ? 'top-2px' : 'top-1'">

                        <!-- Experience -->
                        <v-pill class="mb-1"
                                :text="metric(skill.years, 'year')"
                                :color="convertExperienceToColor(skill)"
                                :title="yearsOld(skill.tool.originated) < 3 ? 'This tool is relatively new so we do not use color-coding for it yet.' : ''">
                        </v-pill>

                        <!-- Link -->
                        <span v-if="skill.summary"
                              @click="skill.show_summary = ! (skill?.show_summary ?? false)"
                              class="text-11px text-sky-600/80 hover:text-rose-700 uppercase transition duration-300 cursor-pointer">

                            <!-- Text -->
                            {{ (skill?.show_summary ?? false) ? 'Hide' : 'Details' }}

                        </span>

                    </div>

                </div>

                <!-- Summary -->
                <span class="block text-15px text-gray-700 leading-normal mt-6"
                      v-if="skill.summary && (dusk() ? true : (skill?.show_summary ?? false))">

                    <!-- Text -->
                    {{ skill.summary }}

                </span>

            </div>

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

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Determine the color scheme to assign to given skill.
             *
             */
            convertExperienceToColor(skill)
            {
                if (this.yearsOld(skill.tool.originated) < 3) {
                    return 'gray';
                }

                return skill.years === 1 ? 'red' : skill.years === 2 ? 'yellow' : 'green';
            },
        }
    }
</script>