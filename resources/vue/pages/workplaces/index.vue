<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Workplaces
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Manage your current and past employment history. While
                this information is not used by Lumeno to match you with
                vacancies, it is made available to potential employers.
            </p>

            <!-- Empty -->
            <v-empty :visible="blank(prop('workplaces'))"
                     message="You have not added any workplaces"
                     :action="{ command : () => modals.create = true }">
            </v-empty>

            <!-- Timeline -->
            <div :key="i"
                 class="relative group"
                 v-for="(year, i) in Object.keys(prop('workplaces')).sort((a, b) => b - a).map(k => prop(`workplaces.${k}`))">

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

                            <!-- Header -->
                            <div class="flex justify-between items-center mb-6px">

                                <!-- Role -->
                                <span class="font-semibold text-gray-800 leading-normal mr-3">
                                    {{ workplace.role }}
                                </span>

                                <!-- Actions -->
                                <v-menu :items="context(workplace)"
                                        :id="`context-workplaces-${workplace.id}`">
                                </v-menu>

                            </div>

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

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total -->
            <v-statistic icon="briefcase"
                         :text="metric(prop('total'), 'workplace')">
            </v-statistic>

            <!-- Permitted -->
            <v-statistic icon="building"
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
            <v-edit v-if="modals.edit"
                    :workplace="workplace"
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
            workplace : null,

            modals : {
                edit   : false,
                create : false,
            },

            actions : [
                {
                    id      : 'create-workplace',
                    show    : (prop('limit') - prop('total')) > 0,
                    icon    : 'university',
                    color   : 'text-emerald-700/70',
                    title   : 'Create workplace',
                    summary : 'Add employment details',
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
             * Retrieve the menu options for the given workplace.
             *
             */
            context(workplace)
            {
                return [
                    {
                        id     : `context-workplaces-${workplace.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit workplace',
                        action : () => { this.workplace = workplace; this.modals.edit = true },
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-workplaces-${workplace.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete workplace',
                        action : () => submit(
                            createInertiaForm(), ['workplaces.delete', workplace.id], 'delete'
                        ),
                    }
                ];
            },
        }
    }
</script>