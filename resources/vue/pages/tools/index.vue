<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Tools
            </h4>

            <!-- Information -->
            <p class="mb-8">
                Manage the library of tools that users may use to add skills
                to their profiles, or that organizations may use to add
                requirements to their vacancies. Tools that are awaiting
                approval are shown first and are marked as pending.
            </p>

            <!-- List -->
            <v-list :items="prop('tools.data')"
                    :show="! isPaginatorEmpty()"
                    :action="(item) => { tool = item; modals.edit = true }"
                    :empty="getPaginatorEmptyMessage('There are no tools in the database')">

                <!-- Left -->
                <template v-slot:left="{ item }">
                    <div class="w-full md:w-3/4">

                        <!-- Tool -->
                        <div class="flex items-center">

                            <!-- Name -->
                            <span class="font-semibold text-15px text-gray-800">
                                {{ item.name }}
                            </span>

                            <!-- Status -->
                            <v-pill :small="true"
                                    color="orange"
                                    text="Pending"
                                    v-if="! item.approved"
                                    title="This tool has not been approved yet and may be removed"
                                    class="relative -top-half-px md:-top-1px lg:-top-half-px ml-6px">
                            </v-pill>

                        </div>

                        <!-- Category -->
                        <span class="block text-14px text-gray-600"
                              :class="item.approved ? 'mt-2' : 'mt-6px'">

                            <!-- Text -->
                            {{ item.category }}

                        </span>

                    </div>
                </template>

                <!-- Right -->
                <template v-slot:right="{ item }">

                    <!-- Originated -->
                    <v-pill :text="item.originated"
                            :color="yearsOld(item.originated) < 2 ? 'red' : (yearsOld(item.originated) < 3 ? 'orange' : 'green')">
                    </v-pill>

                    <!-- Actions -->
                    <v-menu :items="context(item)"
                            :id="`context-tools-${item.id}`">
                    </v-menu>

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

            <!-- Pending -->
            <v-statistic icon="vial"
                         :text="`${number(prop('metrics.unapproved'))} pending`">
            </v-statistic>

            <!-- Approved -->
            <v-statistic icon="check"
                         :text="`${number(prop('metrics.approved'))} approved`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

            <!-- Filter -->
            <v-filter :min="1"
                      v-model="session.search.name"
                      @change="(event) => reloadPaginator(event, 'name')">
            </v-filter>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Create Modal -->
            <v-create v-if="modals.create"
                      :visible="modals.create"
                      @closed="modals.create = false">
            </v-create>

            <!-- Edit Modal -->
            <v-edit :tool="tool"
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
    import ListComponent from '@/components/list.vue';
    import PillComponent from '@/components/pill.vue';
    import MenuComponent from '@/components/menu.vue';
    import ActionComponent from '@/components/actions.vue';
    import FilterComponent from '@/components/filter.vue';
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
            'v-filter'     : FilterComponent,
            'v-layout'     : Layout,
            'v-list'       : ListComponent,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-pill'       : PillComponent,
            'v-statistic'  : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            tool : null,

            paginator : 'tools',

            modals : {
                edit   : false,
                create : false,
            },

            form : createInertiaForm({
                category_id : '',
                name        : '',
                originated  : '',
                approved    : true,
            }, 'approve'),

            actions : [
                {
                    id      : 'create-tool',
                    show    : true,
                    icon    : 'plus',
                    color   : 'text-emerald-700/70',
                    title   : 'Create tool',
                    summary : 'Add one to the library',
                    action  : () => this.modals.create = true,
                },
            ],
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.search = createInertiaForm({
                name : queryString('name'),
            }, 'search');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Approve the given tool.
             *
             */
            approve(tool)
            {
                this.form.category_id = tool.category_id;
                this.form.originated  = tool.originated;
                this.form.name        = tool.name;

                submit(this.form, ['tools.update', tool.id], 'patch');
            },

            /**
             * Retrieve the menu options for the given tool.
             *
             */
            context(tool)
            {
                return [
                    {
                        id     : `context-tools-${tool.id}-approve`,
                        icon   : 'check',
                        show   : ! tool.approved,
                        type   : 'link',
                        label  : 'Approve tool',
                        action : () => this.approve(tool),
                    }, {
                        show   : ! tool.approved,
                        type   : 'separator',
                    }, {
                        id     : `context-tools-${tool.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit tool',
                        action : () => { this.tool = tool; this.modals.edit = true },
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-tools-${tool.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete tool',
                        action : () => confirmAction('This will delete the tool.', () => submit(
                            createInertiaForm(), ['tools.delete', tool.id], 'delete')
                        ),
                    }
                ];
            },
        }
    }
</script>