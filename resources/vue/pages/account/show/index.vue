<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Sections -->
            <v-overview></v-overview>

            <!-- Tabs -->
            <v-tabs class="md:-mb-6"
                    id="account_show"
                    :tabs="tabs.items"
                    :active="tabs.show"
                    @change="tabs.show = $event">
            </v-tabs>

            <!-- Statement -->
            <v-statement tab="statement"
                         :active="tabs.show">
            </v-statement>

            <!-- Skills -->
            <v-skills tab="skills"
                      :active="tabs.show">
            </v-skills>

            <!-- Workplaces -->
            <v-workplaces tab="employment"
                          :active="tabs.show"
                          v-if="isAuthenticated() && isManagerOrAssociate()">
            </v-workplaces>

            <!-- Schools -->
            <v-schools tab="education"
                       :active="tabs.show"
                       v-if="isAuthenticated() && isManagerOrAssociate()">
            </v-schools>

            <!-- Projects -->
            <v-projects tab="projects"
                        :active="tabs.show">
            </v-projects>

            <!-- Articles -->
            <v-articles tab="articles"
                        :active="tabs.show">
            </v-articles>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Created At -->
            <v-statistic icon="calendar-alt"
                         :text="`Joined ${date(prop('account.created_at'))}`">
            </v-statistic>

            <!-- Updated At -->
            <v-statistic icon="calendar-alt"
                         :text="`Updated ${date(prop('account.updated_at'))}`">
            </v-statistic>

            <!-- Text -->
            <span class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase pt-9 my-9">
                Activity
            </span>

            <!-- Articles -->
            <v-statistic icon="newspaper"
                         :text="metric(prop('account.metrics.article_count'), 'article')">
            </v-statistic>

            <!-- Projects -->
            <v-statistic icon="cubes"
                         :text="metric(prop('account.projects').length, 'project')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import SkillPartial from './skills.vue';
    import SchoolPartial from './schools.vue';
    import ProjectPartial from './projects.vue';
    import ArticlePartial from './articles.vue';
    import OverviewPartial from './overview.vue';
    import StatementPartial from './statement.vue';
    import WorkplacePartial from './workplaces.vue';
    import TabComponent from '@/components/tabs.vue';
    import ActionComponent from '@/components/actions.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithAuthorization from '@/mixins/InteractsWithAuthorization';
    import InteractsWithAuthentication from '@/mixins/InteractsWithAuthentication';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
            InteractsWithAuthorization,
            InteractsWithAuthentication,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'    : ActionComponent,
            'v-articles'   : ArticlePartial,
            'v-layout'     : Layout,
            'v-overview'   : OverviewPartial,
            'v-projects'   : ProjectPartial,
            'v-schools'    : SchoolPartial,
            'v-skills'     : SkillPartial,
            'v-statement'  : StatementPartial,
            'v-statistic'  : StatisticComponent,
            'v-tabs'       : TabComponent,
            'v-workplaces' : WorkplacePartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            tabs : {
                show  : localStorage.getItem('tab_account_show') ?? 'statement',
                items : [
                    {
                        id    : 'statement',
                        icon  : 'user',
                        label : 'Statement',
                    }, {
                        id    : 'skills',
                        icon  : 'tools',
                        label : 'Skills',
                    }, {
                        id    : 'employment',
                        icon  : 'briefcase',
                        label : 'Employment',
                        show  : this.isAuthenticated() && this.isManagerOrAssociate(),
                    }, {
                        id    : 'education',
                        icon  : 'graduation-cap',
                        label : 'Education',
                        show  : this.isAuthenticated() && this.isManagerOrAssociate(),
                    }, {
                        id    : 'projects',
                        icon  : 'cube',
                        label : 'Projects',
                    }, {
                        id    : 'articles',
                        icon  : 'newspaper',
                        label : 'Articles',
                    },
                ],
            },

            actions : [
                {
                    id      : 'edit-account',
                    show    : this.isAuthenticated() && (prop('user.id') === prop('account.id')),
                    icon    : 'edit',
                    color   : 'text-sky-600/70',
                    title   : 'Edit account',
                    summary : 'Revise your public profile',
                    action  : () => redirect('account.edit'),
                }, {
                    id      : 'share-account',
                    show    : true,
                    icon    : 'external-link-alt',
                    color   : 'text-emerald-600/70',
                    title   : 'Share profile',
                    summary : 'Tell others about this person',
                    action  : () => shareLink(),
                },
            ],
        }},
    }
</script>