<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Organization
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Manage your organization's profile information, such
                as its name, phone number and website. If you no longer
                need the account, then you can delete it, however you
                should make sure to download any important data first.
            </p>

            <!-- Sections -->
            <v-profile></v-profile>
            <v-tasks></v-tasks>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Created At -->
            <v-statistic icon="calendar-alt"
                         :text="`Joined ${date(prop('organization.created_at'))}`">
            </v-statistic>

            <!-- Text -->
            <span class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase pt-9 my-9">
                Subscription
            </span>

            <!-- Subscription Plan -->
            <v-statistic icon="credit-card"
                         :text="prop('subscription_plan')">
            </v-statistic>

            <!-- Next Payment Date -->
            <v-statistic icon="calendar-alt"
                         :text="`Due ${date(prop('organization.next_payment_date'))}`">
            </v-statistic>

            <!-- Invitations -->
            <v-statistic icon="envelope-open-text"
                         :text="`${metric(prop('organization.usage_this_cycle', 0), 'invitation')} sent`">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Delete Modal -->
            <v-delete :visible="modal"
                      @closed="modal = false">
            </v-delete>

        </template>

    </v-layout>
</template>

<script>
    import TaskPartial from './tasks.vue';
    import Layout from '@/layout/index.vue';
    import DeletePartial from './delete.vue';
    import ProfilePartial from './profile.vue';
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
            'v-delete'    : DeletePartial,
            'v-layout'    : Layout,
            'v-profile'   : ProfilePartial,
            'v-statistic' : StatisticComponent,
            'v-tasks'     : TaskPartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            modal : false,

            actions : [
                {
                    id      : 'manage-subscription',
                    show    : true,
                    icon    : 'coins',
                    color   : 'text-yellow-600/70',
                    title   : 'Manage subscription',
                    summary : 'Change plan or payment method',
                    action  : () => location.href = route('spark.portal', { type : 'organization' }),
                }, {
                    id      : 'delete-organization',
                    show    : true,
                    icon    : 'trash',
                    color   : 'text-rose-700/70',
                    title   : 'Delete organization',
                    summary : 'Remove all organization data',
                    action  : () => this.modal = true,
                }
            ],
        }},
    }
</script>