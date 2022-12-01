<template>
    <v-layout class="ArticlePage">

        <!-- Content -->
        <template #content>

            <!-- Window -->
            <div :class="fullscreen ? 'flex flex-col bg-white min-h-screen overflow-y-auto fixed inset-0 z-1000 p-10' : ''">

                <!-- Compact -->
                <div @click="fullscreen = false"
                     class="rounded-md cursor-pointer fixed top-4 right-3 lg:top-6 lg:right-5 lg:px-3 lg:py-2">

                    <!-- Icon -->
                    <i class="fas fa-down-left-and-up-right-to-center text-amber-600/70"></i>

                    <!-- Text -->
                    <span class="hidden lg:inline text-13px text-gray-700 uppercase relative -top-1px ml-2">
                        Exit
                    </span>

                </div>

                <!-- Article -->
                <div :class="fullscreen ? 'zen w-full lg:max-w-600px xl:max-w-800px mx-auto' : ''">

                    <!-- Author -->
                    <div @click="redirect(['account.show', { user : prop('article.user.handle') }])"
                         class="bg-gray-100 flex items-center rounded-md cursor-pointer px-6 py-5 mb-10">

                        <!-- Avatar -->
                        <v-image type="user"
                                 :source="prop('article.user')"
                                 @click="redirect(['account.show', { user : prop('article.user.handle') }])"
                                 class="w-40px h-40px min-w-40px min-h-40px max-w-40px max-h-40px md:w-50px md:h-50px md:min-w-50px md:min-h-50px md:max-w-50px md:max-h-50px rounded-full cursor-pointer">
                        </v-image>

                        <!-- Profile -->
                        <div class="ml-4">

                            <!-- Name -->
                            <h5 class="font-medium text-16px flex items-center mb-1">

                                <!-- Text -->
                                {{ prop('article.user.name') }}

                                <!-- Handle -->
                                <span class="font-sans font-normal text-13px text-gray-500 tracking-normal ml-3">
                                    @{{ prop('article.user.handle') }}
                                </span>

                            </h5>

                            <!-- Date -->
                            <span class="text-15px text-gray-700/80">
                                {{ date(prop('article.created_at')) }}
                            </span>

                            <!-- Divider -->
                            <i class="fas fa-circle text-5px text-teal-700/80 relative -top-3px mx-10px"></i>

                            <!-- Reading Time -->
                            <span class="text-15px text-gray-700/80">
                                {{ reading.minutes }} minute read
                            </span>

                        </div>

                    </div>

                    <!-- Title -->
                    <h3 class="mb-8">
                        {{ prop('article.title') }}
                    </h3>

                    <!-- Markdown -->
                    <v-reader :content="prop('article.content')"></v-reader>

                    <!-- Tags -->
                    <div class="flex flex-wrap">

                        <!-- Tag -->
                        <div :key="tag"
                             class="mb-2 md:mb-0"
                             v-for="tag in ['first_tag', 'second_tag', 'third_tag', 'fourth_tag']">

                            <!-- Pill -->
                            <div v-if="prop(`article.${tag}`)"
                                 class="bg-sky-100/70 font-medium text-11px text-sky-800 uppercase rounded-full px-2 py-1 mr-2">

                                <!-- Text -->
                                {{ prop(`article.${tag}`) }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Divider -->
            <div v-if="isGuest()"
                 class="border-t border-gray-400/50 mt-10 md:mt-12 mb-11">
            </div>

            <!-- Register -->
            <v-banner icon="user"
                      class="mt-12"
                      :close="false"
                      v-if="isGuest()">

                <!-- Text -->
                Lumeno helps IT professionals to centralize their résumé, project
                portfolio and blog content so they can be discovered for jobs&hellip;

                <!-- Link -->
                <v-link :url="route('register')"
                        class="text-yellow-300 hover:text-emerald-300">

                    <!-- Text -->
                    sign up for free!

                </v-link>

            </v-banner>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Actions -->
            <v-actions :border="false"
                       :items="actions">
            </v-actions>

        </template>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import LinkComponent from '@/components/link.vue';
    import ImageComponent from '@/components/image.vue';
    import BannerComponent from '@/components/banner.vue';
    import ActionComponent from '@/components/actions.vue';
    import MarkdownReaderComponent from '@/components/reader.vue';
    import InteractsWithImages from '@/mixins/InteractsWithImages';
    import InteractsWithReading from '@/mixins/InteractsWithReading';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithAuthentication from '@/mixins/InteractsWithAuthentication';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithImages,
            InteractsWithReading,
            InteractsWithFormatting,
            InteractsWithAuthentication,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions' : ActionComponent,
            'v-banner'  : BannerComponent,
            'v-image'   : ImageComponent,
            'v-layout'  : Layout,
            'v-link'    : LinkComponent,
            'v-reader'  : MarkdownReaderComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            fullscreen : false,

            actions : [
                {
                    id      : 'share-article',
                    show    : true,
                    icon    : 'external-link-alt',
                    color   : 'text-emerald-700/70',
                    title   : 'Share article',
                    summary : 'Tell others about this article',
                    action  : () => shareLink(),
                }, {
                    id      : 'edit-article',
                    show    : this.isAuthenticated() && (prop('user.id') === prop('article.user.id')),
                    icon    : 'edit',
                    color   : 'text-sky-600/70',
                    title   : 'Edit article',
                    summary : "Revise the article's content",
                    action  : () => redirect(['articles.edit', prop('article.id')]),
                }, {
                    id      : 'view-fullscreen',
                    show    : true,
                    icon    : 'up-right-and-down-left-from-center',
                    color   : 'text-amber-700/70',
                    title   : 'View fullscreen',
                    summary : 'Read without distractions',
                    action  : () => this.fullscreen = true,
                },
            ],
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            this.readingMetrics(prop('article.content'));
        },
    }
</script>