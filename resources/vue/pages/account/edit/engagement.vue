<template>
    <v-panel :border="false">

        <!-- Summary -->
        <template #left>

            <!-- Title -->
            <h6>
                Engagement
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify whether you are open to
                receiving job invitations at this time.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                When disabled, you will not appear in any
                recruitment search results and you will not
                receive any invitations to apply for a position.
            </p>

        </template>

        <!-- Panel -->
        <template #right>

            <!-- Available -->
            <v-checkbox class="mb-6"
                        id="available"
                        label="Receive invitations"
                        v-model="session.forms.account.available"
                        :error="session.forms.account.errors.available">
            </v-checkbox>

            <!-- Notice -->
            <v-alert class="mb-4"
                     :border="false"
                     :spacing="false">

                <!-- Text -->
                Prevent invitations being marked as junk by whitelisting
                this email: {{ prop('email') }}

            </v-alert>

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
    import AlertComponent from '@/components/alert.vue';
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
            'v-alert'    : AlertComponent,
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-panel'    : PanelComponent,
        },
    }
</script>