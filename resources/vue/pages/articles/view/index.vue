<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Articles
            </h4>

            <!-- Information -->
            <p class="mb-10 md:mb-9">
                Manage the written articles that you have worked on, or are currently working on.
                Your articles are included within your public profile for other professionals,
                as well as potential employers to discover.
            </p>

            <!-- Empty -->
            <v-empty :visible="isPaginatorEmpty()"
                     message="You have not added any articles"
                     :action="{ command : () => redirect('articles.create') }">
            </v-empty>

            <!-- Articles -->
            <div :key="article.id"
                 v-show="! isPaginatorEmpty()"
                 class="border-t border-gray-300/50"
                 v-for="(article, index) in prop('articles.data')"
                 :class="index !== prop('articles.data').length - 1 ? 'pt-9 pb-10' : 'pt-10'">

                <!-- Header -->
                <div class="flex justify-between items-start mb-2px">

                    <!-- Title & Status -->
                    <div class="flex flex-col">

                        <!-- Title -->
                        <h5 class="font-semibold text-17px cursor-pointer mb-0 mr-2"
                            @click="redirect(['articles.show', { article : article.id, slug : article.slug }])">

                            <!-- Text -->
                            {{ article.title }}

                        </h5>

                    </div>

                    <!-- Actions -->
                    <v-menu :items="context(article)"
                            :id="`context-articles-${article.id}`">
                    </v-menu>

                </div>

                <!-- Subtitle -->
                <p class="text-14px text-gray-600 mb-5 md:mb-4">
                    <span class="clamp md:clamp-none one-line md:mb-6px">

                        <!-- Icon -->
                        <i class="fas fa-calendar-alt text-10px text-purple-600/60 relative -top-1px mr-2"></i>

                        <!-- Date -->
                        <span class="text-gray-600/80">
                            {{ date(article.created_at) }}
                        </span>

                    </span>
                </p>

                <!-- Summary -->
                <p class="text-gray-800 clamp three-lines leading-normal">
                    {{ article.summary }}
                </p>

                <!-- Footer -->
                <div class="flex flex-col md:flex-row justify-between -mb-1 md:mb-0">

                    <!-- Tags -->
                    <div class="flex flex-wrap mb-10px md:mb-0">

                        <!-- Tag -->
                        <div :key="tag"
                             class="mb-2 md:mb-0"
                             v-for="tag in ['first_tag', 'second_tag', 'third_tag', 'fourth_tag']">

                            <!-- Pill -->
                            <div v-if="article[tag]"
                                 class="bg-sky-100/70 font-medium text-11px text-sky-800 uppercase rounded-full px-2 py-1 mr-2">

                                <!-- Text -->
                                {{ article[tag] }}

                            </div>

                        </div>

                    </div>

                </div>

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

            <!-- Total -->
            <v-statistic icon="newspaper"
                         :text="metric(prop('total'), 'article')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

            <!-- Filter -->
            <v-filter v-model="session.search.title"
                      @change="(event) => reloadPaginator(event, 'title')">
            </v-filter>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import MenuComponent from '@/components/menu.vue';
    import EmptyComponent from '@/components/empty.vue';
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
            'v-empty'      : EmptyComponent,
            'v-filter'     : FilterComponent,
            'v-layout'     : Layout,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-statistic'  : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            paginator : 'articles',

            actions : [
                {
                    id      : 'create-article',
                    show    : true,
                    icon    : 'edit',
                    color   : 'text-emerald-700/70',
                    title   : 'Write article',
                    summary : 'Submit a new article',
                    action  : () => redirect('articles.create'),
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
                title : queryString('title'),
            }, 'search');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given article.
             *
             */
            context(article)
            {
                return [
                    {
                        id     : `context-articles-${article.id}-show`,
                        icon   : 'eye',
                        show   : true,
                        type   : 'link',
                        label  : 'View article',
                        action : () => redirect(['articles.show', { article : article.id, slug : article.slug }]),
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-articles-${article.id}-edit`,
                        icon   : 'edit',
                        show   : true,
                        type   : 'link',
                        label  : 'Edit article',
                        action : () => redirect(['articles.edit', article.id]),
                    }, {
                        show   : true,
                        type   : 'separator',
                    }, {
                        id     : `context-articles-${article.id}-delete`,
                        icon   : 'trash-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Delete article',
                        action : () => confirmAction('This will delete the article.', () => submit(
                            createInertiaForm(), ['articles.delete', article.id], 'delete')
                        ),
                    }
                ];
            },
        }
    }
</script>