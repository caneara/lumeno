<template>
    <v-panel>

        <!-- Summary -->
        <template #left>

            <!-- Title -->
            <h6>
                Movement
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Set your preferences on remote working,
                commute distance and emigration.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                The commute distance is calculated from
                the coordinates that you provide in the
                position section of your profile.
            </p>

        </template>

        <!-- Panel -->
        <template #right>

            <!-- Remote -->
            <v-dropdown v="id"
            			k="name"
                        id="remote"
                        class="mb-4"
            			icon="laptop-house"
            			label="Remote working"
            			:items="prop('remote')"
                        v-model="session.forms.account.remote"
                        @change="changeRemoteWorkStatus($event)"
                        :error="session.forms.account.errors.remote">
            </v-dropdown>

            <!-- Commute -->
            <v-dropdown v="id"
            			k="name"
                        class="mb-4"
            			icon="train"
                        id="commute"
            			:items="prop('commute')"
            			label="Maximum commute distance"
                        v-model="session.forms.account.commute"
                        v-if="session.forms.account.commute !== 0"
                        :error="session.forms.account.errors.commute">
            </v-dropdown>

            <!-- Full Time -->
            <v-checkbox class="mb-4"
                        id="emigrate"
                        label="Prepared to emigrate"
                        v-model="session.forms.account.emigrate"
                        :error="session.forms.account.errors.emigrate">
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
    import DropDownComponent from '@/components/dropdown.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-dropdown' : DropDownComponent,
            'v-panel'    : PanelComponent,
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle a change in the status of remote working.
             *
             */
            changeRemoteWorkStatus(event)
            {
                if (event.value === 3) {
                    session.forms.account.commute = 0;
                }

                if (event.previous === 3 && event.value !== 3) {
                    session.forms.account.commute = 5;
                }
            }
        }
    }
</script>