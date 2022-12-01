<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Edit Article
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Revise a written article. It will be included within your public profile for
                other IT professionals, as well as potential employers to discover.
            </p>

            <!-- Sections -->
            <v-overview></v-overview>
            <v-banner></v-banner>
            <v-content></v-content>
            <v-date></v-date>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Characters -->
            <v-statistic icon="font"
                         :text="metric(reading.characters, 'character')">
            </v-statistic>

            <!-- Words -->
            <v-statistic icon="align-left"
                         :text="metric(reading.words, 'word')">
            </v-statistic>

            <!-- Minutes -->
            <v-statistic icon="clock"
                         :text="metric(reading.minutes, 'minute')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import DatePartial from './date.vue';
    import Layout from '@/layout/index.vue';
    import BannerPartial from './banner.vue';
    import ContentPartial from './content.vue';
    import OverviewPartial from './overview.vue';
    import ActionComponent from '@/components/actions.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import InteractsWithReading from '@/mixins/InteractsWithReading';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithReading,
            InteractsWithFormatting,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'   : ActionComponent,
            'v-banner'    : BannerPartial,
            'v-date'      : DatePartial,
            'v-content'   : ContentPartial,
            'v-layout'    : Layout,
            'v-overview'  : OverviewPartial,
            'v-statistic' : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            actions : [
                {
                    id      : 'back-to-index',
                    show    : true,
                    icon    : 'arrow-left',
                    color   : 'text-gray-700/70',
                    title   : 'View articles',
                    summary : 'Back to main directory',
                    action  : () => redirect('articles'),
                }, {
                    id      : 'show-article',
                    show    : true,
                    icon    : 'book-open',
                    color   : 'text-emerald-700/70',
                    title   : 'Read article',
                    summary : 'View the article in full',
                    action  : () => redirect(['articles.show', { article : prop('article.id'), slug : prop('article.slug') }]),
                }, {
                    id      : 'learn-markdown',
                    show    : true,
                    icon    : 'graduation-cap',
                    color   : 'text-sky-700/70',
                    title   : 'Learn markdown',
                    summary : 'Get familiar with the standard',
                    action  : () => window.open('https://www.markdownguide.org/basic-syntax', '_blank', 'noopener'),
                },
            ],
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.uploading = false;

            session.form = createInertiaForm({
                title      : prop('article.title'),
                summary    : prop('article.summary'),
                content    : prop('article.content'),
                banner     : prop('article.banner'),
                first_tag  : prop('article.first_tag'),
                second_tag : prop('article.second_tag'),
                third_tag  : prop('article.third_tag'),
                fourth_tag : prop('article.fourth_tag'),
                created_at : prop('article.created_at'),
            }, 'edit');

            this.readingMetrics(session.form.content);
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on('refresh-reading-metrics', (content) => this.readingMetrics(content));
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('refresh-reading-metrics');
        },
    }
</script>