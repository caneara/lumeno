<template>
    <v-layout>

        <!-- Markdown -->
        <v-reader class="w-full xl:w-4/5"
                  :file="asset('docs/legal.md')">
        </v-reader>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import MarkdownReaderComponent from '@/components/reader.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-layout' : Layout,
            'v-reader' : MarkdownReaderComponent,
        },
    }
</script>