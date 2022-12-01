<template>
    <v-modal id="delete-modal"
             :visible="visible"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Delete your account
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Please provide your password to delete your account.
            If you are the only member of an organization,
            it will be deleted too.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            This action cannot be reversed. Once your data has
            been deleted, it will not be possible to recover it.

        </v-alert>

        <!-- Password -->
        <v-password icon="key"
                    class="mb-4"
                    label="Password"
                    id="current_password"
                    fill="current-password"
                    v-model="form.password"
                    :error="form.errors.password">
        </v-password>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-delete-modal')">
            </v-button>

            <!-- Delete -->
            <v-button color="red"
                      label="Delete"
                      :disabled="! form.password"
                      :processing="form.processing"
                      @click="submit(form, 'account.delete', 'delete')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';
    import PasswordComponent from '@/components/password.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'    : AlertComponent,
            'v-button'   : ButtonComponent,
            'v-modal'    : ModalComponent,
            'v-password' : PasswordComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['closed'],

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                password : '',
            }, 'delete'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'visible' : { type : Boolean, default : false },
        },
    }
</script>