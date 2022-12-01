<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6>
            Overview
        </h6>

        <!-- Description -->
        <p class="mb-8">
            Start by providing the title for your article, then a short
            summary of the article's content and scope. Next, provide
            up to four tags (in order of relevance) that represent the
            topics your article covers e.g. 'indexing' and 'databases'.
        </p>

        <!-- Title -->
        <v-textbox id="title"
                   icon="font"
                   class="mb-4"
                   label="Title"
                   v-model="session.form.title"
                   :error="session.form.errors.title">
        </v-textbox>

        <!-- Summary -->
        <v-textbox :lines="4"
                   id="summary"
                   class="mb-4"
                   icon="file-alt"
                   label="Summary"
                   v-model="session.form.summary"
                   :error="session.form.errors.summary">
        </v-textbox>

        <!-- Editor -->
        <v-tags id="tags"
                :optional="true"
                :first="session.form.first_tag"
                :third="session.form.third_tag"
                :fourth="session.form.fourth_tag"
                :second="session.form.second_tag"
                @first="session.form.first_tag = $event; session.form.errors.first_tag = ''"
                @third="session.form.third_tag = $event; session.form.errors.third_tag = ''"
                @second="session.form.second_tag = $event; session.form.errors.second_tag = ''"
                @fourth="session.form.fourth_tag = $event; session.form.errors.fourth_tag = ''">
        </v-tags>

        <!-- Errors -->
        <v-error :message="session.form.errors.first_tag"></v-error>
        <v-error :message="session.form.errors.second_tag"></v-error>
        <v-error :message="session.form.errors.third_tag"></v-error>
        <v-error :message="session.form.errors.fourth_tag"></v-error>

    </v-panel>
</template>

<script>
    import TagComponent from '@/components/tags.vue';
    import ErrorComponent from '@/components/error.vue';
    import PanelComponent from '@/components/panel.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-error'   : ErrorComponent,
            'v-panel'   : PanelComponent,
            'v-tags'    : TagComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>