<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Verify your email address
        </h4>

        <!-- Information -->
        <p class="text-center mb-10">
            We need you to confirm that the email address you
            provided is valid. Please check your email for a
            verification link. If you did not receive one, then
            you can request that another be sent.
        </p>

        <!-- Button -->
        <v-button label="Resend"
                  class="md:flex justify-end"
                  :processing="form.processing"
                  @click="submit(form, 'email.verify.send')">
        </v-button>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import ButtonComponent from '@/components/button.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button' : ButtonComponent,
            'v-layout' : Layout,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm(),
        }},
    }
</script>