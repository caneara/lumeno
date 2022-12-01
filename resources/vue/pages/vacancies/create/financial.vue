<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6 id="title-financial">
                Financial
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the currency and the monthly
                income for the position.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                Lumeno matches candidates based on their
                minimum financial requirements, so there
                is no need to provide brackets.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                On Lumeno, a month is equal to 31 days.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Currency -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
                        id="currency"
            			label="Currency"
            			icon="money-bill-alt"
            			:items="prop('currencies')"
                        v-model="session.form.currency"
                        :error="session.form.errors.currency">
            </v-dropdown>

            <!-- Remuneration -->
            <v-textbox class="mb-4"
                       icon="coins"
                       id="remuneration"
                       label="Monthly income"
                       v-model="session.form.remuneration"
                       :error="session.form.errors.remuneration">
            </v-textbox>

            <!-- Notice -->
            <v-alert color="blue"
                     :border="false"
                     :spacing="false">

                <!-- Text -->
                Even if the position pays weekly or daily,
                you should still enter the sum for a full
                month's work.

            </v-alert>

        </template>

    </v-panel>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
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
            'v-dropdown' : DropDownComponent,
            'v-panel'    : PanelComponent,
            'v-textbox'  : TextBoxComponent,
        },
    }
</script>