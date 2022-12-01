<template>
    <v-layout :padding="false"
              class="GuidePage">

        <!-- Panes -->
        <div class="flex flex-col md:flex-row flex-1 h-full">

            <!-- Sidebar -->
            <div :class="sidebar ? '' : 'hidden lg:block'"
                 class="md:bg-sidebar w-full md:max-w-250px border-gray-300 md:border-r py-9 md:pt-15">

                <!-- Links -->
                <v-reader :html="true"
                          :current="true"
                          prefix="sidebar"
                          :file="asset('docs/sidebar.md')">
                </v-reader>

                <!-- Advert -->
                <v-advert :simple="true"></v-advert>

            </div>

            <!-- Content -->
            <div :class="sidebar ? 'md:px-16' : ''"
                 class="flex-1 py-6 md:py-14 lg:px-16">

                <!-- Page -->
                <v-reader :html="true"
                          class="w-full max-w-800px break-words"
                          :file="asset(`docs/${prop('page')}.md`)">
                </v-reader>

            </div>

            <!-- Toggle -->
            <div @click="sidebar = ! sidebar"
                 class="lg:hidden group rounded-r-lg cursor-pointer fixed top-17 right-10px md:top-25 md:right-8 z-10 p-4">

                <!-- Icon -->
                <i class="fas fa-book-open text-22px text-gray-500 group-hover:text-gray-700 transition duration-300"></i>

            </div>

        </div>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import AdvertComponent from '@/components/advert.vue';
    import MarkdownReaderComponent from '@/components/reader.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-layout' : Layout,
            'v-advert' : AdvertComponent,
            'v-reader' : MarkdownReaderComponent,
        },

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
			sidebar : false,
		}},
    }
</script>