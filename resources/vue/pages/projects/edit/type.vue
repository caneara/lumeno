<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-type">
                Type
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the project's type e.g. personal,
                educational, design, or prototype.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Other is a catch-all type, but is generally
                best suited for business projects.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Type -->
            <v-dropdown v="id"
                        k="name"
                        id="type"
                        icon="code"
                        label="Type"
                        class="mb-4"
                        :items="prop('types')"
                        v-model="session.form.type"
                        :error="session.form.errors.type">
            </v-dropdown>

            <!-- Update -->
            <v-button label="Update"
                      class="flex justify-end"
                      :disabled="session.form.uploading"
                      :processing="session.form.processing"
                      @click="submit(session.form, ['projects.update', prop('project.id')], 'patch', { preserveScroll : true })">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import DropDownComponent from '@/components/dropdown.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-panel'    : PanelComponent,
            'v-dropdown' : DropDownComponent,
        },
    }
</script>