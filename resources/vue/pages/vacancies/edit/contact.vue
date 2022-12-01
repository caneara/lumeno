<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Contact
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Specify how candidates should get
                in touch about the vacancy.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                Lumeno automatically populates these fields
                using your organization's profile, but you
                are free to change them if you need to.
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

            <!-- Email Address -->
            <v-textbox id="email"
                       fill="email"
                       class="mb-4"
                       icon="envelope"
                       label="Email address"
                       v-model="session.form.email"
                       :error="session.form.errors.email">
            </v-textbox>

            <!-- Phone Number -->
            <v-textbox id="phone"
                       class="mb-4"
                       icon="phone"
                       label="Phone number"
                       v-model="session.form.phone"
                       :error="session.form.errors.phone">
            </v-textbox>

            <!-- Website -->
            <v-textbox class="mb-4"
                       id="website"
                       icon="globe"
                       v-model="session.form.website"
                       label="Website or social media"
                       :error="session.form.errors.website">
            </v-textbox>

            <!-- Update -->
            <v-button label="Update"
                      class="flex justify-end"
                      :processing="session.form.processing"
                      @click="submit(session.form, ['vacancies.update', prop('vacancy.id')], 'patch')">
            </v-button>

        </template>

    </v-panel>
</template>

<script>
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
            'v-button'  : ButtonComponent,
            'v-panel'   : PanelComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>