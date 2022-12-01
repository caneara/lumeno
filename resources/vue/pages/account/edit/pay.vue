<template>
    <v-panel :border="false">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Pay
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Set the minimum income you will accept
                and the currency you should be paid in.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">

                <!-- Text -->
                The minimum income field must equal what
                you expect to make in

                <!-- Warning -->
                <strong class="text-red-700">
                    one month.
                </strong>

                <!-- Text -->
                The figure should be gross income, not
                net income.

            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Always select the currency that is in
                use within the country you reside. It is not
                necessary to select another currency, as Lumeno
                will automatically perform a conversion.
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
                        v-model="session.forms.account.currency"
                        :error="session.forms.account.errors.currency">
            </v-dropdown>

            <!-- Remuneration -->
            <v-textbox icon="coins"
                       class="mb-4"
                       id="remuneration"
                       label="Minimum monthly income"
                       v-model="session.forms.account.remuneration"
                       :error="session.forms.account.errors.remuneration">
            </v-textbox>

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
    import TextBoxComponent from '@/components/textbox.vue';
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
            'v-textbox'  : TextBoxComponent,
        },
    }
</script>