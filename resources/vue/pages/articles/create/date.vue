<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Date
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                If you're republishing the article, then
                you can specify its original date.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                If you're writing a new article, then
                you do not need to alter this field.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Created At -->
            <v-date class="mb-4"
                    id="created_at"
                    icon="calendar-alt"
                    label="Created date"
                    v-model="session.form.created_at"
                    :error="session.form.errors.created_at">
            </v-date>

            <!-- Create -->
            <v-button label="Create"
                      class="flex justify-end"
                      :disabled="session.uploading"
                      :processing="session.form.processing"
                      @click="submit(session.form, 'articles.store')">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import DateComponent from '@/components/date.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button' : ButtonComponent,
            'v-date'   : DateComponent,
            'v-panel'  : PanelComponent,
        },
    }
</script>