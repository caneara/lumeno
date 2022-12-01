<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-overview">
                Overview
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Provide the title of your project, as
                well as a brief summary of its scope.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                The tags section should be used to add key details
                regarding the stack or tools used to create the
                project e.g. 'PHP' and 'JavaScript'.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Projects appear on your profile, so make sure that
                you do not include confidential information or
                contact details that should not be exposed.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Title -->
            <v-textbox id="title"
                       icon="font"
                       class="mb-4"
                       label="Title"
                       v-model="session.form.title"
                       :error="session.form.errors.title">
            </v-textbox>

            <!-- Summary -->
            <v-textbox :lines="5"
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

        </template>

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