<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Communication
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the languages that you are able
                to use with confidence.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                You should be a fluent speaker and
                writer of any languages that you select.
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
                        v-model="session.forms.account.first_language"
                        :error="session.forms.account.errors.first_language">
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
                        v-model="session.forms.account.second_language"
                        :error="session.forms.account.errors.second_language">
            </v-dropdown>

            <!-- Third Language -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="language"
                        :optional="true"
                        id="third_language"
            			label="Third language"
            			:items="prop('languages')"
                        v-model="session.forms.account.third_language"
                        :error="session.forms.account.errors.third_language">
            </v-dropdown>

            <!-- Update -->
            <v-button label="Update"
                      class="md:flex justify-end"
                      :processing="session.forms.account.processing"
                      @click="submit(session.forms.account, 'account.update', 'patch', { preserveScroll : true })">
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
            'v-dropdown' : DropDownComponent,
            'v-panel'    : PanelComponent,
        },
    }
</script>