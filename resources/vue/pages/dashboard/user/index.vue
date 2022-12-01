<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                {{ greeting }}
            </h4>

            <!-- Information -->
            <p class="mb-[34px]">
                Welcome to your Lumeno dashboard. If you're new around here, we've prepared this
                handy introduction to help guide you. Lumeno is a dual-purpose platform,
                which means it provides features for IT professionals, as well as
                organizations. To get started, select the role that corresponds with
                how you intend to use Lumeno.
            </p>

            <!-- Tabs -->
            <v-tabs id="discover_role"
                    :tabs="tabs.items"
                    :active="tabs.show"
                    @change="tabs.show = $event">
            </v-tabs>

            <!-- Roles -->
            <div class="pt-12">
                <v-professional v-show="tabs.show === 'professional'"></v-professional>
                <v-organization v-show="tabs.show === 'organization'"></v-organization>
                <v-explained v-show="tabs.show === 'explained'"></v-explained>
            </div>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Tasks
            </span>

            <!-- Complete -->
            <v-statistic icon="check"
                         text="Completed"
                         v-if="prop('user.metrics.skill_count') &&
                               prop('user.metrics.project_count') &&
                               prop('user.metrics.article_count') &&
                               prop('user.metrics.workplace_count') &&
                               prop('user.metrics.school_count')">
            </v-statistic>

            <!-- Skills -->
            <v-statistic url="skills"
                         icon="hourglass"
                         text="Add your skills"
                         v-if="! prop('user.metrics.skill_count')">
            </v-statistic>

            <!-- Projects -->
            <v-statistic url="projects"
                         icon="hourglass"
                         text="Add a project"
                         v-if="! prop('user.metrics.project_count')">
            </v-statistic>

            <!-- Articles -->
            <v-statistic url="articles"
                         icon="hourglass"
                         text="Add an article"
                         v-if="! prop('user.metrics.article_count')">
            </v-statistic>

            <!-- Workplaces -->
            <v-statistic url="workplaces"
                         icon="hourglass"
                         text="Add employment history"
                         v-if="! prop('user.metrics.workplace_count')">
            </v-statistic>

            <!-- Schools -->
            <v-statistic url="schools"
                         icon="hourglass"
                         text="Add education history"
                         v-if="! prop('user.metrics.school_count')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import TabComponent from '@/components/tabs.vue';
    import LinkComponent from '@/components/link.vue';
    import ExplainedPartial from './explained.vue';
    import OrganizationPartial from './organization.vue';
    import ProfessionalPartial from './professional.vue';
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
            'v-actions'      : ActionComponent,
            'v-explained'    : ExplainedPartial,
            'v-layout'       : Layout,
            'v-link'         : LinkComponent,
            'v-organization' : OrganizationPartial,
            'v-professional' : ProfessionalPartial,
            'v-statistic'    : StatisticComponent,
            'v-tabs'         : TabComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            actions : [
                {
                    id      : 'view-profile',
                    show    : true,
                    icon    : 'user',
                    color   : 'text-emerald-600/70',
                    title   : 'View profile',
                    summary : 'Visit your public profile',
                    action  : () => redirect(['account.show', { user : prop('user.handle') }]),
                },
            ],
            tabs : {
                show  : 'professional',
                items : [
                    {
                        id    : 'professional',
                        icon  : 'tools',
                        label : 'Professional',
                    }, {
                        id    : 'organization',
                        icon  : 'building',
                        label : 'Organization',
                    }, {
                        id    : 'explained',
                        icon  : 'lightbulb',
                        fill  : true,
                        label : 'How does it work?',
                    },
                ],
            },
        }},

        /**
         * Define the computed properties.
         *
         */
        computed:
        {
            /**
             * Generate an appropriate greeting for the user.
             *
             */
            greeting()
            {
                let hours = new Date().getHours();

                let period = hours < 12 ? 'morning' : hours < 18 ? 'afternoon' : 'evening';

                return `Good ${period}, ${prop('user.name')}`;
            }
        },
    }
</script>