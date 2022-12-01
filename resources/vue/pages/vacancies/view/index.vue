<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Vacancies
            </h4>

            <!-- Information -->
            <p class="mb-9">
                View the directory of all vacancies within the organization. If you are
                intending to send a great many invitations for them, consider upgrading
                to a paid subscription to reduce the overall cost per invitation.
            </p>

            <!-- Empty -->
            <v-empty :visible="isPaginatorEmpty()"
                     message="You have not added any vacancies"
                     :action="{ command : () => redirect('vacancies.create') }">
            </v-empty>

            <!-- Vacancies -->
            <div :key="vacancy.id"
                 v-show="! isPaginatorEmpty()"
                 class="border-t border-gray-300/50"
                 v-for="(vacancy, index) in prop('vacancies.data')"
                 :class="index !== prop('vacancies.data').length - 1 ? 'pt-9 pb-10' : 'pt-10'">

                <!-- Header -->
                <div class="flex justify-between mb-4">

                    <!-- Role -->
                    <h5 @click="redirect(['vacancies.show', vacancy.id])"
                        class="font-semibold text-17px cursor-pointer mb-0">

                        <!-- Text -->
                        {{ vacancy.role }}

                    </h5>

                    <!-- Actions -->
                    <v-menu :items="context(vacancy)"
                            :id="`context-vacancies-${vacancy.id}`">
                    </v-menu>

                </div>

                <!-- Status -->
                <div class="flex mb-5">

                    <!-- Invitations -->
                    <v-pill color="blue"
                            class="mr-1"
                            :text="`${metric(vacancy.metrics.invitation_count, 'invitation')} sent`">
                    </v-pill>

                    <!-- Archived -->
                    <v-pill color="orange"
                            text="Archived"
                            v-if="vacancy.archived_at">
                    </v-pill>

                </div>

                <!-- Overview -->
                <div class="grid grid-cols-1 md:grid-cols-shrink gap-x-10 gap-y-2px ml-3px md:ml-0">

                    <!-- Commitment -->
                    <span title="Commitment"
                          class="block text-15px text-gray-700/80 whitespace-nowrap mb-2">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-calendar-alt text-13px text-red-700/70 -ml-9px mr-1"></i>

                        <!-- Text -->
                        {{ prop('commitments').find(item => item.id === vacancy.commitment).name }}
                        {{ vacancy.months ? ` - ${vacancy.months} ${singularOrPlural(vacancy.months, 'month')}` : '' }}

                    </span>

                    <!-- Location -->
                    <span title="Location"
                          class="block text-15px text-gray-700/80 mb-2">

                        <!-- Icon -->
                        <span class="flag text-14px mr-3">
                            {{ prop('countries').find(item => item.id === vacancy.country).flag }}
                        </span>

                        <!-- Text -->
                        <span class="country">
                            {{ vacancy.area }},
                            {{ prop('countries').find(item => item.id === vacancy.country).name }}
                        </span>

                    </span>

                    <!-- Remuneration -->
                    <span title="Income per month"
                          class="block text-15px text-gray-700/80 whitespace-nowrap mb-2">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-coins text-13px text-yellow-600/70 -ml-9px mr-1"></i>

                        <!-- Text -->
                        {{ prop('currencies').find(item => item.id === vacancy.currency).code }}
                        {{ number(vacancy.remuneration) }} per month

                    </span>

                    <!-- Languages -->
                    <span title="Languages"
                          class="block text-15px text-gray-700/80 mb-6">

                        <!-- Icon -->
                        <i class="fa-fw fas fa-language text-13px text-emerald-600/70 -ml-9px mr-1"></i>

                        <!-- Text -->
                        {{ vacancy.languages }}

                    </span>

                </div>

                <!-- Summary -->
                <p class="clamp two-lines leading-normal mb-0">
                    {{ vacancy.summary }}
                </p>

            </div>

            <!-- Pagination -->
            <v-pagination styles="mt-8"
                          :paginator="paginator">
            </v-pagination>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total Vacancies -->
            <v-statistic icon="id-card-alt"
                         :text="metric(prop('total', 0), 'vacancy', '$vacancies')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

            <!-- Filter -->
            <v-filter v-model="session.search.role"
                      @change="(event) => reloadPaginator(event, 'role')">
            </v-filter>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import EmptyComponent from '@/components/empty.vue';
    import ActionComponent from '@/components/actions.vue';
    import FilterComponent from '@/components/filter.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import PaginationComponent from '@/components/pagination.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithPagination from '@/mixins/InteractsWithPagination';
    import InteractsWithAuthorization from '@/mixins/InteractsWithAuthorization';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
            InteractsWithPagination,
            InteractsWithAuthorization,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'    : ActionComponent,
            'v-empty'      : EmptyComponent,
            'v-filter'     : FilterComponent,
            'v-layout'     : Layout,
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
            paginator : 'vacancies',

            actions : [
                {
                    id      : 'create-vacancy',
                    show    : true,
                    icon    : 'briefcase',
                    color   : 'text-emerald-700/70',
                    title   : 'Add vacancy',
                    summary : 'Create a new vacancy',
                    action  : () => redirect('vacancies.create'),
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
                role : queryString('role'),
            }, 'search');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given vacancy.
             *
             */
            context(vacancy)
            {
                return [
                    {
                        id     : `context-vacancies-${vacancy.id}-show`,
                        icon   : vacancy.permissions.archive ? 'search' : 'eye',
                        show   : true,
                        type   : 'link',
                        label  : `${vacancy.permissions.archive ? 'Find' : 'View'} candidates`,
                        action : () => redirect(['vacancies.show', vacancy.id]),
                    }, {
                        show   : vacancy.permissions.edit,
                        type   : 'separator',
                    }, {
                        id     : `context-vacancies-${vacancy.id}-edit`,
                        icon   : 'edit',
                        show   : vacancy.permissions.edit,
                        type   : 'link',
                        label  : 'Edit vacancy',
                        action : () => redirect(['vacancies.edit', vacancy.id]),
                    }, {
                        show   : vacancy.permissions.export,
                        type   : 'separator',
                    }, {
                        id     : `context-vacancies-${vacancy.id}-export`,
                        icon   : 'download',
                        show   : vacancy.permissions.export,
                        type   : 'link',
                        label  : 'Export candidates',
                        action : () => window.open(route('vacancies.export', vacancy.id)),
                    }, {
                        show   : vacancy.permissions.archive,
                        type   : 'separator',
                    }, {
                        id     : `context-vacancies-${vacancy.id}-archive`,
                        icon   : 'box-archive',
                        show   : vacancy.permissions.archive,
                        type   : 'link',
                        label  : 'Archive vacancy',
                        action : () => confirmAction('This will archive the vacancy / make it read only.', () => submit(
                            createInertiaForm(), ['vacancies.archive', vacancy.id], 'patch')
                        ),
                    }, {
                        show   : vacancy.permissions.delete,
                        type   : 'separator',
                    }, {
                        id     : `context-vacancies-${vacancy.id}-delete`,
                        icon   : 'trash-alt',
                        show   : vacancy.permissions.delete,
                        type   : 'link',
                        label  : 'Delete vacancy',
                        action : () => confirmAction('This will delete the vacancy.', () => submit(
                            createInertiaForm(), ['vacancies.delete', vacancy.id], 'delete')
                        ),
                    }
                ];
            },
        }
    }
</script>