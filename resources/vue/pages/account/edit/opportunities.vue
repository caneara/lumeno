<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Opportunities
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Filter the vacancies that you receive
                based on time commitment.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Full-time is 40 hours a week or more,
                while part-time is less than 30 hours.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Full Time -->
            <v-checkbox class="mb-4"
                        id="full_time"
                        label="Full-time work"
                        v-model="session.forms.account.full_time"
                        :error="session.forms.account.errors.full_time">
            </v-checkbox>

            <!-- Part Time -->
            <v-checkbox class="mb-4"
                        id="part_time"
                        label="Part-time work"
                        v-model="session.forms.account.part_time"
                        :error="session.forms.account.errors.part_time">
            </v-checkbox>

            <!-- Contract -->
            <v-checkbox class="mb-8"
                        id="contract"
                        label="Contract positions"
                        v-model="session.forms.account.contract"
                        :error="session.forms.account.errors.contract">
            </v-checkbox>

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
    import CheckBoxComponent from '@/components/checkbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-panel'    : PanelComponent,
        },
    }
</script>