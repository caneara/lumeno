<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Account
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Manage your account details, such as your name, email address
                and photo, as well as your public profile information, which
                is used by Lumeno to match you with vacancies that employers
                are attempting to fill.
            </p>

            <!-- Tabs -->
            <v-tabs id="account_edit"
                    :tabs="tabs.items"
                    :active="tabs.show"
                    @change="tabs.show = $event">
            </v-tabs>

            <!-- Identity -->
            <v-identity tab="general"
                        :active="tabs.show">
            </v-identity>

            <!-- Communication -->
            <v-communication tab="general"
                             :active="tabs.show">
            </v-communication>

            <!-- Avatar -->
            <v-avatar tab="general"
                      :active="tabs.show">
            </v-avatar>

            <!-- Statement -->
            <v-statement tab="general"
                         :active="tabs.show">
            </v-statement>

            <!-- Position -->
            <v-position tab="location"
                        :active="tabs.show">
            </v-position>

            <!-- Movement -->
            <v-movement tab="location"
                        :active="tabs.show">
            </v-movement>

            <!-- Pay -->
            <v-pay tab="financial"
                   :active="tabs.show">
            </v-pay>

            <!-- Engagement -->
            <v-engagement tab="availability"
                          :active="tabs.show">
            </v-engagement>

            <!-- Opportunities -->
            <v-opportunities tab="availability"
                             :active="tabs.show">
            </v-opportunities>

            <!-- Presence -->
            <v-presence tab="internet"
                        :active="tabs.show">
            </v-presence>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Handle -->
            <v-statistic icon="at"
                         :text="prop('user.handle')">
            </v-statistic>

            <!-- Created At -->
            <v-statistic icon="calendar-alt"
                         :text="`Joined ${date(prop('account.created_at'))}`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Password Modal -->
            <v-password :visible="modals.password"
                        @closed="modals.password = false">
            </v-password>

            <!-- Delete Modal -->
            <v-delete :visible="modals.delete"
                      @closed="modals.delete = false">
            </v-delete>

        </template>

    </v-layout>
</template>

<script>
    import PayPartial from './pay.vue';
    import Layout from '@/layout/index.vue';
    import AvatarPartial from './avatar.vue';
    import DeletePartial from './delete.vue';
    import IdentityPartial from './identity.vue';
    import MovementPartial from './movement.vue';
    import PasswordPartial from './password.vue';
    import PresencePartial from './presence.vue';
    import PositionPartial from './position.vue';
    import StatementPartial from './statement.vue';
    import TabComponent from '@/components/tabs.vue';
    import EngagementPartial from './engagement.vue';
    import OpportunityPartial from './opportunities.vue';
    import ActionComponent from '@/components/actions.vue';
    import CommunicationPartial from './communication.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import InteractsWithTabs from '@/mixins/InteractsWithTabs';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithPersonalization from '@/mixins/InteractsWithPersonalization';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithTabs,
            InteractsWithFormatting,
            InteractsWithPersonalization,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'       : ActionComponent,
            'v-avatar'        : AvatarPartial,
            'v-communication' : CommunicationPartial,
            'v-delete'        : DeletePartial,
            'v-engagement'    : EngagementPartial,
            'v-identity'      : IdentityPartial,
            'v-layout'        : Layout,
            'v-movement'      : MovementPartial,
            'v-opportunities' : OpportunityPartial,
            'v-password'      : PasswordPartial,
            'v-pay'           : PayPartial,
            'v-presence'      : PresencePartial,
            'v-position'      : PositionPartial,
            'v-statement'     : StatementPartial,
            'v-statistic'     : StatisticComponent,
            'v-tabs'          : TabComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            modals : {
                delete   : false,
                password : false,
            },

            tabs : {
                show  : localStorage.getItem('tab_account_edit') ?? 'general',
                items : [
                    {
                        id    : 'general',
                        icon  : 'user',
                        show  : true,
                        label : 'General',
                    }, {
                        id    : 'location',
                        icon  : 'map-marker-alt',
                        show  : true,
                        label : 'Location',
                    }, {
                        id    : 'financial',
                        icon  : 'coins',
                        show  : true,
                        label : 'Financial',
                    }, {
                        id    : 'availability',
                        icon  : 'calendar-alt',
                        show  : true,
                        label : 'Availability',
                    }, {
                        id    : 'internet',
                        icon  : 'globe',
                        show  : true,
                        label : 'Internet',
                    },
                ],
            },

            actions : [
                {
                    id      : 'view-profile',
                    show    : true,
                    icon    : 'user',
                    color   : 'text-emerald-600/70',
                    title   : 'View profile',
                    summary : 'Visit your public profile',
                    action  : () => redirect(['account.show', { user : prop('user.handle') }]),
                }, {
                    id      : 'change-password',
                    show    : true,
                    icon    : 'key',
                    color   : 'text-sky-600/70',
                    title   : 'Change password',
                    summary : 'Replace your current password',
                    action  : () => this.modals.password = true,
                }, {
                    id      : 'delete-account',
                    show    : true,
                    icon    : 'trash-alt',
                    color   : 'text-red-700/70',
                    title   : 'Delete account',
                    summary : 'Remove your account and data',
                    action  : () => this.modals.delete = true,
                },
            ],
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.forms = {
                account : createInertiaForm({
                    name            : prop('account.name'),
                    email           : prop('account.email'),
                    available       : prop('account.available'),
                    country         : prop('account.country', this.getUserCountryID()),
                    area            : prop('account.area'),
                    coordinates     : prop('account.coordinates'),
                    time_zone       : prop('account.time_zone', this.getUserTimeZoneID()),
                    full_time       : prop('account.full_time', false),
                    part_time       : prop('account.part_time', false),
                    contract        : prop('account.contract', false),
                    first_language  : prop('account.first_language', this.getUserLanguageID()),
                    second_language : prop('account.second_language'),
                    third_language  : prop('account.third_language'),
                    emigrate        : prop('account.emigrate', false),
                    remote          : prop('account.remote'),
                    commute         : prop('account.commute'),
                    currency        : prop('account.currency', this.getUserCurrencyID()),
                    remuneration    : prop('account.remuneration'),
                    website         : prop('account.website'),
                    github          : prop('account.github'),
                    twitter         : prop('account.twitter'),
                    linkedin        : prop('account.linkedin'),
                    discord         : prop('account.discord'),
                    youtube         : prop('account.youtube'),
                    facebook        : prop('account.facebook'),
                    instagram       : prop('account.instagram'),
                    statement       : prop('account.statement'),
                }, 'account'),

                avatar : createInertiaForm({
                    avatar : prop('account.avatar'),
                }, 'avatar'),
            }
        },
    }
</script>