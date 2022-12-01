<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-communication">
                Communication
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the languages that candidates
                will need to be familiar with.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                All candidates are expected to be fluent
                with the languages they have specified.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- First Language -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="language"
                        id="first_language"
            			label="First language"
            			:items="prop('languages')"
                        v-model="session.form.first_language"
                        :error="session.form.errors.first_language">
            </v-dropdown>

            <!-- Second Language -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="language"
                        :optional="true"
                        id="second_language"
            			label="Second language"
            			:items="prop('languages')"
                        v-model="session.form.second_language"
                        :error="session.form.errors.second_language">
            </v-dropdown>

            <!-- Third Language -->
            <v-dropdown v="id"
            			k="name"
            			icon="language"
                        :optional="true"
                        id="third_language"
            			label="Third language"
            			:items="prop('languages')"
                        v-model="session.form.third_language"
                        :error="session.form.errors.third_language">
            </v-dropdown>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import DropDownComponent from '@/components/dropdown.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-dropdown' : DropDownComponent,
            'v-panel'    : PanelComponent,
        },
    }
</script>