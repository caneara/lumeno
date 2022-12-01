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
                Define the employment conditions e.g.
                full-time, part-time or contract.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Full-time is generally considered to be 40
                hours a week, or more, while part-time is
                less than 30 hours per week.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Commitment -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="clock"
                        id="commitment"
            			label="Commitment"
            			:items="prop('commitments')"
                        v-model="session.form.commitment"
                        :error="session.form.errors.commitment"
                        @change="session.form.commitment !== 1 ? session.form.months = '' : null">
            </v-dropdown>

            <!-- Months -->
            <v-textbox id="months"
                       class="mb-4"
                       icon="calendar-alt"
                       label="Duration (months)"
                       v-model="session.form.months"
                       :error="session.form.errors.months"
                       v-if="session.form.commitment === 1">
            </v-textbox>

            <!-- Notice -->
            <v-alert class="mb-4"
                     color="blue"
                     :border="false"
                     :spacing="false"
                     v-if="session.form.commitment === 1">

                <!-- Text -->
                If the contract is for less than a month, type '1' into the duration field.
                You should then specify the exact duration within the summary field.

            </v-alert>

            <!-- Update -->
            <v-button label="Update"
                      class="flex justify-end"
                      :processing="session.form.processing"
                      @click="submit(session.form, ['vacancies.update', prop('vacancy.id')], 'patch')">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'    : AlertComponent,
            'v-button'   : ButtonComponent,
            'v-dropdown' : DropDownComponent,
            'v-panel'    : PanelComponent,
            'v-textbox'  : TextBoxComponent,
        },
    }
</script>