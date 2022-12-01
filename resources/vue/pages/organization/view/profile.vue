<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Profile
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify the organization's main details,
                such as its name and website.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">

                <!-- Text -->
                Phone numbers must be in the correct and
                complete international format e.g.

                <!-- USA -->
                <span class="block mt-4 mb-2">

                    <!-- Identity -->
                    🇺🇸 US

                    <!-- Phone -->
                    <span class="ml-1">
                        +12069536978
                    </span>

                </span>

                <!-- UK -->
                <span class="block">

                    <!-- Identity -->
                    🇬🇧 UK

                    <!-- Phone -->
                    <span class="ml-1">
                        +447158656473
                    </span>

                </span>

            </p>

        </template>

        <!-- Right -->
        <template #right>

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

            <!-- Notice -->
            <v-alert class="mb-4"
                     :spacing="false"
                     v-if="form.email !== prop('organization.email')">

                <!-- Text -->
                Our payment provider does not offer an automated way
                to change your email address, which means that your
                billing correspondance will still be sent to the
                original email address. If you want to change that,
                then please contact us so that we can assist you.

            </v-alert>

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

            <!-- Update -->
            <v-button label="Update"
                      class="md:flex justify-end"
                      :processing="form.processing"
                      @click="submit(form, 'organization.update', 'patch')">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
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
            'v-panel'   : PanelComponent,
            'v-button'  : ButtonComponent,
            'v-textbox' : TextBoxComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                name    : prop('organization.name'),
                phone   : prop('organization.phone'),
                email   : prop('organization.email'),
                website : prop('organization.website'),
            }, 'update'),
        }},
    }
</script>