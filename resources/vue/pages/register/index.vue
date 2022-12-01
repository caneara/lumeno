<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Create a new account
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">

            <!-- Text -->
            Welcome aboard. To begin, please fill in the form below,
            and then make sure that you are happy with all of our

            <!-- Link -->
            <v-link :url="route('legal')">
                legal terms.
            </v-link>

        </p>

        <!-- Form -->
	    <form @submit.prevent="submit(form, 'register.store')">

            <!-- Name -->
            <v-textbox id="name"
                       fill="name"
                       class="mb-4"
                       label="Name"
                       icon="signature"
                       v-model="form.name"
                       :error="form.errors.name">
            </v-textbox>

            <!-- Handle -->
            <v-textbox icon="user"
                       id="handle"
                       class="mb-4"
                       label="Username"
                       v-model="form.handle"
                       :error="form.errors.handle">
            </v-textbox>

            <!-- Email Address -->
            <v-textbox id="email"
                       fill="email"
                       class="mb-4"
                       icon="envelope"
                       v-model="form.email"
                       label="Email address"
                       :error="form.errors.email">
            </v-textbox>

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

            <!-- Footer -->
            <div class="md:flex items-center justify-between">

                <!-- Accept Terms -->
                <v-checkbox id="terms"
                            label="Accept Terms"
                            v-model="form.terms"
                            :error="form.errors.terms"
                            class="w-full md:w-[180px] mb-4 md:mb-0">
                </v-checkbox>

                <!-- Create -->
                <v-button label="Create"
                          :classic="true"
                          :processing="form.processing">
                </v-button>

            </div>

        </form>

    </v-layout>
</template>

<script>
    import Layout from '@/layout/index.vue';
    import LinkComponent from '@/components/link.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';
    import PasswordComponent from '@/components/password.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-layout'   : Layout,
            'v-link'     : LinkComponent,
            'v-password' : PasswordComponent,
            'v-textbox'  : TextBoxComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                name                  : '',
                handle                : '',
                email                 : '',
                password              : '',
                password_confirmation : '',
                terms                 : false,
            }),
        }},
    }
</script>