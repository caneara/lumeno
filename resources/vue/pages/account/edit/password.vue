<template>
    <v-modal :visible="visible"
             @closed="$emit('closed')"
             id="change-password-modal">

        <!-- Title -->
        <h4 class="text-center">
            Change your password
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Replace your password with a secure alternative.
            You are free to either create one or use a
            randomly-generated password.
        </p>

        <!-- Form -->
	    <form @submit.prevent="submit(form, 'password.update')">

            <!-- Current Password -->
            <v-password icon="key"
                        class="mb-4"
                        :generate="false"
                        id="old_password"
                        fill="current-password"
                        label="Current password"
                        v-model="form.old_password"
                        :error="form.errors.old_password">
            </v-password>

            <!-- New Passwords -->
            <div class="flex flex-col md:flex-row">

                <!-- Password -->
                <v-password icon="key"
                            id="new_password"
                            fill="new-password"
                            label="New Password"
                            v-model="form.new_password"
                            :error="form.errors.new_password"
                            class="w-full md:w-1/2 mb-4 md:mr-2"
                            @random="($event) => { form.new_password_confirmation = $event; form.errors.new_password_confirmation = '' }">
                </v-password>

                <!-- Confirm Password -->
                <v-password icon="key"
                            label="Confirm"
                            fill="new-password"
                            id="new_password_confirmation"
                            class="w-full md:w-1/2 mb-4 md:ml-2"
                            v-model="form.new_password_confirmation"
                            :error="form.errors.new_password_confirmation"
                            @random="($event) => { form.new_password = $event; form.errors.new_password = '' }">
                </v-password>

            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse md:flex-row justify-end">

                <!-- Cancel -->
                <v-button color="gray"
                          label="Cancel"
                          scheme="light"
                          class="md:mr-8"
                          @click="events.emit('hide-change-password-modal')">
                </v-button>

                <!-- Update -->
                <v-button label="Update"
                          :classic="true"
                          id="save-password"
                          :processing="form.processing">
                </v-button>

            </div>

        </form>

    </v-modal>
</template>

<script>
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
                old_password              : '',
                new_password              : '',
                new_password_confirmation : '',
            }, 'password'),
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