<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Description (Empty) -->
        <p v-if="blank(prop('account.articles.data'))">
            {{ prop('account.name') }} has not added any articles.
        </p>

        <!-- Description (Not Empty) -->
        <p class="mb-9"
           v-if="filled(prop('account.articles.data'))">

            <!-- Text -->
            Review the articles that {{ prop('account.name') }} has written.
            Note that Lumeno does not verify any of the information supplied. If
            you are considering this person for a position, then you will need
            to verify their résumé yourself.

        </p>

        <!-- Articles -->
        <div :key="article.id"
             v-show="! isPaginatorEmpty()"
             v-for="article in prop('account.articles.data')">

            <!-- Article -->
            <div class="border-t border-gray-300/50 py-10">

                <!-- Header -->
                <div class="flex items-start md:justify-between">

                    <!-- Link -->
                    <v-link :url="route('articles.show', { article : article.id, slug : article.slug })"
                            class="block font-inter font-semibold text-17px text-gray-900 hover:text-gray-900 tracking-tight leading-normal mb-2 md:mb-1px">

                        <!-- Title -->
                        {{ article.title }}

                    </v-link>

                    <!-- Menu -->
                    <v-menu class="relative top-3px"
                            :items="context(article)"
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
                <p class="text-gray-800 clamp three-lines mb-26px md:mb-6">
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

        </div>

        <!-- Pagination -->
        <v-pagination :paginator="paginator"></v-pagination>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import MenuComponent from '@/components/menu.vue';
    import PanelComponent from '@/components/panel.vue';
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
            'v-link'       : LinkComponent,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-panel'      : PanelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            paginator : 'account.articles',
        }},

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
                        id     : `context-articles-${article.id}-share`,
                        icon   : 'external-link-alt',
                        show   : true,
                        type   : 'link',
                        label  : 'Share article',
                        action : () => shareLink(route('articles.show', { article : article.id, slug : article.slug })),
                    },
                ];
            },
        }
    }
</script>