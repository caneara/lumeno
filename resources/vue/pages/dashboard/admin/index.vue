<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Dashboard
            </h4>

            <!-- Information -->
            <p class="mb-8">
                Welcome to the admin dashboard, which contains analytical data on
                users, articles, organizations, subscriptions and vacancies. If
                there are any tools awaiting approval, then this will be highlighted.
            </p>

            <!-- Tool Status -->
            <v-banner></v-banner>

            <!-- Header -->
            <h5>
                Metrics
            </h5>

            <!-- Information -->
            <p class="mb-8">
                Review the latest metrical figures derived from users, articles,
                organizations, subscriptions, tools and vacancies. These figures are
                not cached and are therefore always accurate.
            </p>

            <!-- Metrics -->
            <v-metrics></v-metrics>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Platform
            </span>

            <!-- Users -->
            <v-statistic icon="users"
                         :text="metric(prop('metrics.users'), 'user')">
            </v-statistic>

            <!-- Articles -->
            <v-statistic icon="newspaper"
                         :text="metric(prop('metrics.articles'), 'article')">
            </v-statistic>

            <!-- Text -->
            <span class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase pt-9 my-9">
                Business
            </span>

            <!-- Vacancies -->
            <v-statistic icon="id-card-alt"
                         :text="metric(prop('metrics.vacancies'), 'vacancy', '$vacancies')">
            </v-statistic>

            <!-- Organizations -->
            <v-statistic icon="building"
                         :text="metric(prop('metrics.organizations'), 'organization')">
            </v-statistic>

            <!-- Text -->
            <span class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase pt-9 my-9">
                Financial
            </span>

            <!-- Subscriptions -->
            <v-statistic icon="coins"
                         :text="metric(prop('metrics.subscriptions'), 'subscription')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import BannerPartial from './banner.vue';
    import MetricPartial from './metrics.vue';
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
            'v-banner'    : BannerPartial,
            'v-layout'    : Layout,
            'v-metrics'   : MetricPartial,
            'v-statistic' : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            actions : [
                {
                    id      : 'go-to-tools',
                    show    : true,
                    icon    : 'wrench',
                    color   : 'text-emerald-600/70',
                    title   : 'Manage tools',
                    summary : 'Add or approve new tools',
                    action  : () => redirect('tools'),
                },
            ],
        }},
    }
</script>