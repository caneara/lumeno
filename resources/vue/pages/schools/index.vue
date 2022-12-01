<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Schools
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Manage the academic institutions that you have attended and the qualifications
                that you obtained. In some cases, the presence of a college degree will allow
                Lumeno to match you with vacancies that require one.
            </p>

            <!-- Empty -->
            <v-empty :visible="blank(prop('schools'))"
                     message="You have not added any schools"
                     :action="{ command : () => modals.create = true }">
            </v-empty>

            <!-- Timeline -->
            <div :key="i"
                 class="relative group"
                 v-for="(year, i) in Object.keys(prop('schools')).sort((a, b) => b - a).map(k => prop(`schools.${k}`))">

                <!-- Period -->
                <div class="flex items-start">

                    <!-- Year -->
                    <div class="flex justify-center items-center h-50px min-w-50px bg-yellow-600/25 rounded-full">
                        <span class="font-semibold text-14px text-amber-800">
                            {{ year[0].started_at.substring(0, 4) }}
                        </span>
                    </div>

                    <!-- Schools -->
                    <div class="flex-1 pt-3 ml-6 md:ml-8">
                        <div v-for="(school, index) in year">

                            <!-- Header -->
                            <div class="flex justify-between items-center mb-6px">

                                <!-- Course -->
                                <span class="font-semibold text-gray-800 leading-normal mr-3">
                                    {{ school.course }}
                                </span>

                                <!-- Actions -->
                                <v-menu :items="context(school)"
                                        :id="`context-schools-${school.id}`">
                                </v-menu>

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
                                    :title="school.finished_at ? 'The user has graduated' : 'This user has not graduated'"
                                    :text="prop('qualifications').find(qualification => qualification.id === school.qualification).name">
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

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total -->
            <v-statistic icon="graduation-cap"
                         :text="metric(prop('total'), 'school')">
            </v-statistic>

            <!-- Permitted -->
            <v-statistic icon="university"
                         :text="`${prop('limit')} permitted`">
            </v-statistic>

            <!-- Remaining -->
            <v-statistic icon="hourglass"
                         :text="`${prop('limit') - prop('total')} remaining`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Create Modal -->
            <v-create v-if="modals.create"
                      :visible="modals.create"
                      @closed="modals.create = false">
            </v-create>

            <!-- Edit Modal -->
            <v-edit :school="school"
                    v-if="modals.edit"
                    :visible="modals.edit"
                    @closed="modals.edit = false">
            </v-edit>

        </template>

    </v-layout>
</template>

<script>
    import EditPartial from './edit.vue';
    import Layout from '@/layout/index.vue';
    import CreatePartial from './create.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import EmptyComponent from '@/components/empty.vue';
    import ActionComponent from '@/components/actions.vue';
    import StatisticComponent from '@/components/statistic.vue';
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
            'v-actions'   : ActionComponent,
            'v-empty'     : EmptyComponent,
            'v-create'    : CreatePartial,
            'v-edit'      : EditPartial,
            'v-layout'    : Layout,
            'v-menu'      : MenuComponent,
            'v-pill'      : PillComponent,
            'v-statistic' : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            school : null,

            modals : {
                edit   : false,
                create : false,
            },

            actions : [
                {
                    id      : 'create-school',
                    show    : (prop('limit') - prop('total')) > 0,
                    icon    : 'university',
                    color   : 'text-emerald-700/70',
                    title   : 'Create school',
                    summary : 'Add a school to your account',
                    action  : () => this.modals.create = true,
                },
            ],
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given school.
             *
             */
            context(school)
            {
                return [
                    {
                        id     : `context-schools-${school.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit school',
                        action : () => { this.school = school; this.modals.edit = true },
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-schools-${school.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete school',
                        action : () => submit(
                            createInertiaForm(), ['schools.delete', school.id], 'delete'
                        ),
                    }
                ];
            },
        }
    }
</script>