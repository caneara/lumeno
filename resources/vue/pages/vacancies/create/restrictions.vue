<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-restrictions">
                Restrictions
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Filter the potential candidate list
                using one or more additional constraints.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                These filters are optional. You should only
                use them if they are applicable to the vacancy.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Remote -->
            <v-checkbox id="remote"
                        class="mb-4"
                        label="Position is remote"
                        v-model="session.form.remote"
                        :error="session.form.errors.remote">
            </v-checkbox>

            <!-- Degree -->
            <v-checkbox id="degree"
                        v-model="session.form.degree"
                        :error="session.form.errors.degree"
                        label="Must have a college degree">
            </v-checkbox>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-checkbox' : CheckBoxComponent,
            'v-panel'    : PanelComponent,
        },
    }
</script>