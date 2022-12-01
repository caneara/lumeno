<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Create Article
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Add a new written article. It will be included within your public profile for
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
                title      : '',
                summary    : '',
                content    : '',
                banner     : '',
                first_tag  : '',
                second_tag : '',
                third_tag  : '',
                fourth_tag : '',
                created_at : new Date().toISOString(),
            }, 'create');

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