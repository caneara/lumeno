<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Create an organization
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Organizations allow you to add team members,
            create new vacancies, find candidates and
            send application invitations.
        </p>

        <!-- Name -->
        <v-textbox id="name"
                   class="mb-4"
                   label="Name"
                   icon="building"
                   v-model="form.name"
                   :error="form.errors.name">
        </v-textbox>

        <!-- Email Address -->
        <v-textbox id="email"
                   class="mb-4"
                   icon="envelope"
                   v-model="form.email"
                   label="Email address"
                   :error="form.errors.email">
        </v-textbox>

        <!-- Phone Number -->
        <v-textbox id="phone"
                   class="mb-4"
                   icon="phone"
                   label="Phone number"
                   v-model="form.phone"
                   :error="form.errors.phone">
        </v-textbox>

        <!-- Website -->
        <v-textbox class="mb-4"
                   id="website"
                   icon="globe"
                   v-model="form.website"
                   :error="form.errors.website"
                   label="Website or social media">
        </v-textbox>

        <!-- Notice -->
        <v-alert>
            Our payment provider does not offer an automated way
            to change your email address. Therefore, using an email
            that is unlikely to change is recommended.
        </v-alert>

        <!-- Create -->
        <v-button label="Create"
                  class="md:flex justify-end"
                  :processing="form.processing"
                  @click="submit(form, 'organization.store')">
        </v-button>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import AlertComponent from '@/components/alert.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'   : AlertComponent,
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
                name    : '',
                email   : '',
                phone   : '',
                website : '',
            }),
        }},
    }
</script>