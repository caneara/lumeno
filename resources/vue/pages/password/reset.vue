<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Reset your password
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Please provide a new password for your account. You may also
            use a randomly-generated password if you prefer.
        </p>

        <!-- Form -->
	    <form @submit.prevent="submit(form, 'password.reset.store')">

            <!-- Passwords -->
            <div class="flex flex-col md:flex-row">

                <!-- Password -->
                <v-password icon="key"
                            id="password"
                            label="Password"
                            fill="new-password"
                            v-model="form.password"
                            :error="form.errors.password"
                            class="w-full md:w-1/2 mb-4 md:mr-2"
                            @random="($event) => { form.password_confirmation = $event; form.errors.password_confirmation = '' }">
                </v-password>

                <!-- Confirm Password -->
                <v-password icon="key"
                            label="Confirm"
                            fill="new-password"
                            id="password_confirmation"
                            class="w-full md:w-1/2 mb-4 md:ml-2"
                            v-model="form.password_confirmation"
                            :error="form.errors.password_confirmation"
                            @random="($event) => { form.password = $event; form.errors.password = '' }">
                </v-password>

            </div>

            <!-- Button -->
            <v-button label="Update"
                      :classic="true"
                      class="md:flex justify-end"
                      :processing="form.processing">
            </v-button>

        </form>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
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
            'v-layout'   : Layout,
            'v-password' : PasswordComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                email                 : prop('email'),
                token                 : prop('token'),
                password              : '',
                password_confirmation : '',
            }),
        }},
    }
</script>