<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Forgotten your password?
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Please provide your account email address in order to be sent a
            password reset code. The code will be valid for one hour.
        </p>

        <!-- Email Address -->
        <v-textbox id="email"
                   fill="email"
                   class="mb-4"
                   icon="envelope"
                   v-model="form.email"
                   label="Email address"
                   :error="form.errors.email">
        </v-textbox>

        <!-- Footer -->
        <div class="flex flex-wrap flex-col-reverse md:flex-row md:justify-between">

            <!-- Sign In -->
            <v-button color="gray"
                      scheme="light"
                      icon="arrow-left"
                      label="Sign In"
                      @click="redirect('login')"
                      class="md:flex justify-end mt-2 md:mt-0">
            </v-button>

            <!-- Send -->
            <v-button label="Send"
                      class="md:flex justify-end"
                      :processing="form.processing"
                      @click="submit(form, 'password.forgot.store')">
            </v-button>

        </div>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'  : ButtonComponent,
            'v-layout'  : Layout,
            'v-textbox' : TextBoxComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                email : '',
            }),
        }},
    }
</script>