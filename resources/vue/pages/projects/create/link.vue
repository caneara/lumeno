<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-link">
                Link
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify a url for the project. You can also
                use a social media account.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Unlike other parts of Lumeno that only require
                handles (social media accounts), you should
                provide full urls here e.g. https://example.com
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- URL -->
            <v-textbox id="url"
                       icon="link"
                       label="URL"
                       class="mb-4"
                       :optional="true"
                       v-model="session.form.url"
                       :error="session.form.errors.url">
            </v-textbox>

            <!-- Create -->
            <v-button label="Create"
                      class="flex justify-end"
                      :disabled="session.form.uploading"
                      :processing="session.form.processing"
                      @click="submit(session.form, 'projects.store')">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'  : ButtonComponent,
            'v-panel'   : PanelComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>