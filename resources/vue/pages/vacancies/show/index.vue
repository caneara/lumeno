<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Search Results
            </h4>

            <!-- Information -->
            <p class="mb-8">
                The following candidates matched the vacancy's requirements.
                Your next step, is to review their profiles. If you want to
                invite one of them to apply for the position, then select
                the 'send invitation' link in their context menu. To invite
                multiple candidates in one go, use the 'send invitations'
                option in the sidebar.
            </p>

            <!-- Notice -->
            <v-alert v-if="! prop('total', 0) && ! prop('vacancy.archived_at')">

                <!-- Text -->
                Once you have sent invitations for this vacancy, you will not
                be able to change it&hellip;

                <!-- Link -->
                <v-link :action="() => window.open(`${route('guide', { page : 'vacancies' })}#markdown-editing-vacancies`)">
                    learn more.
                </v-link>

            </v-alert>

            <!-- Empty -->
            <v-empty :visible="isPaginatorEmpty()"
                     message="No matches were found... try relaxing your requirements">
            </v-empty>

            <!-- Users -->
            <div :key="user.id"
                 v-show="! isPaginatorEmpty()"
                 v-for="user in prop('users.data')"
                 class="border-t border-gray-300/50 py-10 last-of-type:pb-0">

                <!-- User -->
                <div class="flex items-start">

                    <!-- Avatar -->
                    <v-image type="user"
                             :source="user"
                             @click="window.open(route('account.show', user.handle))"
                             class="w-50px h-50px min-w-50px min-h-50px max-w-50px max-h-50px md:w-100px md:h-100px md:min-w-100px md:min-h-100px md:max-w-100px md:max-h-100px rounded-full cursor-pointer">
                    </v-image>

                    <!-- Summary -->
                    <div class="flex-1 ml-6 md:ml-7">

                        <!-- Header -->
                        <div class="flex justify-between items-start relative top-2px md:top-0 mb-1">

                            <!-- Name -->
                            <h5 class="font-semibold text-18px cursor-pointer mb-0"
                                @click="window.open(route('account.show', user.handle))">

                                <!-- Text -->
                                {{ user.name }}

                                <!-- Handle -->
                                <span class="block font-sans font-normal text-15px text-gray-500 tracking-normal mt-1 mb-1 md:mb-5">
                                    @{{ user.handle }}
                                </span>

                            </h5>

                            <!-- Actions -->
                            <v-menu :items="context(user)"
                                    class="relative top-2px"
                                    :id="`context-users-${user.id}`">
                            </v-menu>

                        </div>

                        <!-- Invitation -->
                        <v-pill class="relative top-2px md:top-0"
                                title="The current status of the candidate"
                                :color="user.invitation_id ? 'green' : 'blue'"
                                :text="user.invitation_id ? 'Invited' : 'Not Invited'">
                        </v-pill>

                        <!-- Summary -->
                        <div class="-ml-70px md:ml-0 mt-8 md:mt-0">

                            <!-- Area -->
                            <span title="Location"
                                  class="block text-15px text-gray-700 mt-6 mb-2">

                                <!-- Icon -->
                                <i class="fa-fw fas fa-map-marker-alt text-13px text-red-700/70 -ml-9px mr-1"></i>

                                <!-- Text -->
                                {{ user.area }} - {{ number(Math.round(user.distance)) }} KM away

                            </span>

                            <!-- Country -->
                            <span title="Country"
                                  class="block text-15px text-gray-700 mb-2">

                                <!-- Icon -->
                                <span class="flag text-14px mr-3">
                                    {{ prop('countries').find(item => item.id === user.country).flag }}
                                </span>

                                <!-- Name -->
                                <span class="country">
                                    {{ prop('countries').find(item => item.id === user.country).name }} /
                                </span>

                                <!-- Time Zone -->
                                {{ prop('time_zones').find(item => item.id === user.time_zone).short }}

                            </span>

                            <!-- Languages -->
                            <span title="Languages"
                                  class="block text-15px text-gray-700 mb-6">

                                <!-- Icon -->
                                <i class="fa-fw fas fa-language text-13px text-emerald-600/70 -ml-9px mr-1"></i>

                                <!-- Text -->
                                {{ user.languages }}

                            </span>

                        </div>

                    </div>

                </div>

                <!-- Personal Statement -->
                <p class="text-gray-800 clamp three-lines leading-normal mb-0">
                    {{ limit(user.statement, 290) }}
                </p>

            </div>

            <!-- Pagination -->
            <v-pagination :paginator="paginator"></v-pagination>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Vacancy
            </span>

            <!-- Role -->
            <v-statistic icon="user"
                         :text="prop('vacancy.role')">
            </v-statistic>

            <!-- Commitment -->
            <v-statistic icon="clock"
                         :text="prop('commitments').find(item => item.id === prop('vacancy.commitment')).name">
            </v-statistic>

            <!-- Remuneration -->
            <v-statistic icon="coins"
                         :text="`${prop('currencies').find(item => item.id === prop('vacancy.currency')).code} ${number(prop('vacancy.remuneration'))} per month`">
            </v-statistic>

            <!-- Text -->
            <span class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase pt-9 my-9">
                Activity
            </span>

            <!-- Invitations -->
            <v-statistic icon="envelope-open-text"
                         :text="`${metric(prop('total', 0), 'invitation')} sent`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Bulk Modal -->
            <v-bulk :visible="modal"
                    @closed="modal = false">
            </v-bulk>

        </template>

    </v-layout>
</template>

<script>
    import BulkPartial from './bulk.vue';
    import Layout from '@/layout/index.vue';
    import LinkComponent from '@/components/link.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import AlertComponent from '@/components/alert.vue';
    import EmptyComponent from '@/components/empty.vue';
    import ImageComponent from '@/components/image.vue';
    import ActionComponent from '@/components/actions.vue';
    import ButtonComponent from '@/components/button.vue';
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
            'v-alert'      : AlertComponent,
            'v-bulk'       : BulkPartial,
            'v-button'     : ButtonComponent,
            'v-empty'      : EmptyComponent,
            'v-image'      : ImageComponent,
            'v-layout'     : Layout,
            'v-link'       : LinkComponent,
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
            paginator : 'users',

            modal : false,

            actions : [
                {
                    id      : 'send-invitations',
                    show    : ! prop('vacancy.archived_at'),
                    icon    : 'mail-bulk',
                    color   : 'text-purple-700/70',
                    title   : 'Send invitations',
                    summary : 'Contact multiple people',
                    action  : () => this.modal = true,
                }, {
                    id      : 'edit-vacancy',
                    show    : ! prop('total', 0) && ! prop('vacancy.archived_at'),
                    icon    : 'edit',
                    color   : 'text-sky-700/70',
                    title   : 'Edit vacancy',
                    summary : 'Update the requirements',
                    action  : () => redirect(['vacancies.edit', prop('vacancy.id')]),
                }, {
                    id      : 'export-vacancy',
                    show    : !! prop('total', 0),
                    icon    : 'download',
                    color   : 'text-sky-700/70',
                    title   : 'Export candidates',
                    summary : 'Download invitations CSV',
                    action  : () => window.open(route('vacancies.export', prop('vacancy.id'))),
                }, {
                    id      : 'archive-vacancy',
                    show    : ! prop('vacancy.archived_at'),
                    icon    : 'box-archive',
                    color   : 'text-emerald-600/70',
                    title   : 'Archive vacancy',
                    summary : 'Disable further invitations',
                    action  : () => confirmAction('This will archive the vacancy / make it read only.', () => submit(
                        createInertiaForm(), ['vacancies.archive', prop('vacancy.id')], 'patch')
                    ),
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
             * Retrieve the menu options for the given user.
             *
             */
            context(user)
            {
                return [
                    {
                        id     : `context-users-${user.id}-show`,
                        icon   : 'eye',
                        show   : true,
                        type   : 'link',
                        label  : 'View profile',
                        action : () => window.open(route('account.show', user.handle)),
                    }, {
                        show   : ! prop('vacancy.archived_at') && blank(user.invitation_id),
                        type   : 'separator',
                    }, {
                        id     : `context-users-${user.id}-invitation`,
                        icon   : 'envelope',
                        show   : ! prop('vacancy.archived_at') && blank(user.invitation_id),
                        type   : 'link',
                        label  : 'Send invitation',
                        action : () => confirmAction('This will send an invitation.', () => submit(
                            createInertiaForm(), ['invitations.store', {
                                vacancy : prop('vacancy.id'),
                                user    : user.id,
                            }])
                        ),
                    }
                ];
            },
        }
    }
</script>