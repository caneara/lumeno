<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Skills
            </h4>

            <!-- Information -->
            <p class="mb-8">
                Manage the tools that you use and the experience level that
                you have with them. This information is used to match you
                with vacancies that employers are attempting to fill, so
                be sure to regularly review this section.
            </p>

            <!-- Setup -->
            <v-setup v-if="isPaginatorEmpty()"></v-setup>

            <!-- List -->
            <v-list :simple="true"
                    :show="! isPaginatorEmpty()"
                    :items="prop('skills.data')"
                    :action="(item) => { skill = item; modals.edit = true }">

                <!-- Left -->
                <template v-slot:left="{ item }">
                    <div class="w-full md:w-3/4">

                        <!-- Name & Status -->
                        <div class="flex items-center mb-6px">

                            <!-- Name -->
                            <span class="block font-semibold text-15px text-gray-800/85">
                                {{ item.name }}
                            </span>

                            <!-- Approved -->
                            <v-pill :small="true"
                                    color="orange"
                                    text="Pending"
                                    v-if="! item.approved"
                                    class="relative -top-1 ml-6px -mb-1"
                                    title="This tool has not been approved yet and may be removed">
                            </v-pill>

                        </div>

                        <!-- Category -->
                        <span class="block text-15px text-gray-600/75 break-all">
                            {{ item.category }}
                        </span>

                    </div>
                </template>

                <!-- Right -->
                <template v-slot:right="{ item }">
                    <div class="flex items-center">

                        <!-- Experience -->
                        <div class="flex items-center w-70px">

                            <!-- Dot -->
                            <span class="block w-8px h-8px bg-white rounded-full">
                                <span class="block w-8px h-8px rounded-full"
                                      :class="convertExperienceToColor(item)"
                                      :title="yearsOld(item.originated) < 3 ? 'This tool is relatively new so we do not use color-coding for it yet.' : ''">
                                </span>
                            </span>

                            <!-- Years -->
                            <span class="text-14px text-gray-600 whitespace-nowrap ml-2">
                                {{ metric(item.years, 'year') }}
                            </span>

                        </div>

                        <!-- Actions -->
                        <v-menu :items="context(item)"
                                :id="`context-skills-${item.id}`">
                        </v-menu>

                    </div>
                </template>

            </v-list>

            <!-- Pagination -->
            <v-pagination :paginator="paginator"></v-pagination>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total -->
            <v-statistic icon="tools"
                         :text="metric(prop('total'), 'skill')">
            </v-statistic>

            <!-- Permitted -->
            <v-statistic icon="wrench"
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
            <v-edit :skill="skill"
                    v-if="modals.edit"
                    :visible="modals.edit"
                    @closed="modals.edit = false">
            </v-edit>

            <!-- Tool Modal -->
            <v-tool :back="back"
                    v-if="modals.tool"
                    :visible="modals.tool"
                    @closed="modals.tool = false">
            </v-tool>

        </template>

    </v-layout>
</template>

<script>
    import EditPartial from './edit.vue';
    import SetupPartial from './setup.vue';
    import Layout from '@/layout/index.vue';
    import CreatePartial from './create.vue';
    import ToolPartial from '../tools/create.vue';
    import ListComponent from '@/components/list.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import ActionComponent from '@/components/actions.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import PaginationComponent from '@/components/pagination.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithPagination from '@/mixins/InteractsWithPagination';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
            InteractsWithPagination,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'    : ActionComponent,
            'v-create'     : CreatePartial,
            'v-edit'       : EditPartial,
            'v-layout'     : Layout,
            'v-list'       : ListComponent,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-pill'       : PillComponent,
            'v-setup'      : SetupPartial,
            'v-statistic'  : StatisticComponent,
            'v-tool'       : ToolPartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            skill : null,

            back : false,

            paginator : 'skills',

            modals : {
                edit   : false,
                tool   : false,
                create : false,
            },

            actions : [
                {
                    id      : 'create-skill',
                    show    : (prop('limit') - prop('total')) > 0,
                    icon    : 'wrench',
                    color   : 'text-emerald-700/70',
                    title   : 'Add skill',
                    summary : 'Assign a tool to your profile',
                    action  : () => this.modals.create = true,
                }, {
                    id      : 'create-tool',
                    show    : true,
                    icon    : 'window-maximize',
                    color   : 'text-sky-700/70',
                    title   : 'Create tool',
                    summary : 'Add a tool to the library',
                    action  : () => { this.back = false; this.modals.tool = true },
                },
            ],
        }},

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on('open-create-tool-modal', () => this.modals.tool = true);
            events.on('open-create-skill-modal', () => this.modals.create = true);
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('open-create-tool-modal');
            clearEventListener('open-create-skill-modal');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given skill.
             *
             */
            context(skill)
            {
                return [
                    {
                        id     : `context-skills-${skill.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit skill',
                        action : () => { this.skill = skill; this.modals.edit = true },
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-skills-${skill.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete skill',
                        action : () => submit(createInertiaForm(), ['skills.delete', skill.id], 'delete'),
                    }
                ];
            },

            /**
             * Determine the color scheme to assign to given skill.
             *
             */
            convertExperienceToColor(skill)
            {
                if (this.yearsOld(skill.originated) < 3) {
                    return 'bg-gray-600/70';
                }

                return skill.years === 1
                    ? 'bg-red-600/70'
                    : skill.years === 2 ? 'bg-yellow-600/70' : 'bg-green-700/70';
            },
        }
    }
</script>