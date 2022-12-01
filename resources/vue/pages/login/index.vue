<template>
    <v-layout :dialog="true"
              :invert="true">

        <!-- Header -->
        <h4 class="text-center">
            Sign into your account
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">

            <!-- Text -->
            Access your account by entering your credentials
            below, or if you've forgotten your password, then

            <!-- Link -->
            <v-link :url="route('password.forgot')">
                click here to reset it.
            </v-link>

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

        <!-- Password -->
        <v-password icon="key"
                    class="mb-4"
                    id="password"
                    label="Password"
                    fill="current-password"
                    v-model="form.password"
                    :error="form.errors.password">
        </v-password>

        <!-- Footer -->
        <div class="md:flex items-center justify-between mb-10">

            <!-- Remember -->
            <v-checkbox id="remember"
                        label="Remember Me"
                        v-model="form.remember"
                        class="w-full md:w-175px mb-4 md:mb-0">
            </v-checkbox>

            <!-- Login -->
            <v-button label="Login"
                      :processing="form.processing"
                      @click="submit(form, 'login.store')">
            </v-button>

        </div>

        <!-- Divider -->
        <div class="border-b border-gray-300 mb-10"></div>

        <!-- Notice -->
        <div class="bg-white text-15px text-gray-800 text-center rounded-md">
            <div class="bg-emerald-500/5 border border-emerald-700/35 flex justify-center md:justify-start items-center rounded-md px-6 md:pl-7 pt-5 pb-21px">

                <!-- Icon -->
                <i class="fas fa-user text-30px text-teal-600/80 hidden md:inline relative top-2px"></i>

                <!-- Content -->
                <div class="flex flex-col items-center md:items-start md:ml-6">

                    <!-- Problem -->
                    <h6 class="font-medium text-16px mb-1">

                        <!-- Text -->
                        <span class="md:hidden">
                            Don't have an account?
                        </span>

                        <!-- Text -->
                        <span class="hidden md:inline">
                            Don't have a <span class="hidden md:inline">Lumeno</span> account?
                        </span>

                    </h6>

                    <!-- Solution -->
                    <span>

                        <!-- Text -->
                        No problem&hellip;

                        <!-- Link -->
                        <v-link :url="route('register')">
                            sign up for one
                        </v-link>

                        <!-- Text -->
                        <span class="hidden md:inline">
                            today.
                        </span>

                    </span>

                </div>

            </div>
        </div>

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
                email    : '',
                password : '',
                remember : false,
            }),
        }},
    }
</script>