<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6>
            Content
        </h6>

        <!-- Description -->
        <p class="mb-8">
            Now it's time to write the body of your article. Lumeno employs
            the CommonMark flavor of Markdown to style your article's content,
            so be sure to take full advantage of what it offers.
        </p>

        <!-- Content -->
        <v-writer v-model="session.form.content"
                  :error="session.form.errors.content"
                  @uploading="session.uploading = true"
                  @uploaded="session.uploading = false"
                  @change="events.emit('refresh-reading-metrics', $event)">
        </v-writer>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import MarkdownWriterComponent from '@/components/writer.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-panel'  : PanelComponent,
            'v-writer' : MarkdownWriterComponent,
        },
    }
</script>