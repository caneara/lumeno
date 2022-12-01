<template>
    <v-panel :border="false">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Presence
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Add your professional website and any social
                media accounts that you use.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-4">
                When adding your website, you should include
                the full url e.g. https://www.example.com
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">

                <!-- Text -->
                When adding third-party platform accounts,
                only provide the handle, not the url e.g.

                <!-- Facebook -->
                <span class="block mt-6 mb-3">

                    <!-- Icon -->
                    <i class="fa-fw fab fa-facebook text-12px text-sky-600/80 -ml-2 -mr-1"></i>

                    <!-- Handle -->
                    JohnDoe

                </span>

                <!-- Discord -->
                <span class="block mb-3">

                    <!-- Icon -->
                    <i class="fa-fw fab fa-discord text-12px text-purple-600/80 -ml-2 -mr-1"></i>

                    <!-- Handle -->
                    JohnDoe#0001

                </span>

                <!-- YouTube -->
                <span class="block">

                    <!-- Icon -->
                    <i class="fa-fw fab fa-youtube text-12px text-rose-600/80 -ml-2 -mr-1"></i>

                    <!-- Handle -->
                    JohnDoeTutorials

                </span>

            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Website -->
            <v-textbox id="website"
                       class="mb-4"
                       icon="globe"
                       label="Website"
                       :optional="true"
                       v-model="session.forms.account.website"
                       :error="session.forms.account.errors.website">
            </v-textbox>

            <!-- Github -->
            <v-textbox id="github"
                       class="mb-4"
                       label="Github"
                       :optional="true"
                       icon="github fab"
                       v-model="session.forms.account.github"
                       :error="session.forms.account.errors.github">
            </v-textbox>

            <!-- Twitter -->
            <v-textbox class="mb-4"
                       id="twitter"
                       label="Twitter"
                       :optional="true"
                       icon="twitter fab"
                       v-model="session.forms.account.twitter"
                       :error="session.forms.account.errors.twitter">
            </v-textbox>

            <!-- LinkedIn -->
            <v-textbox class="mb-4"
                       id="linkedin"
                       :optional="true"
                       label="LinkedIn"
                       icon="linkedin fab"
                       v-model="session.forms.account.linkedin"
                       :error="session.forms.account.errors.linkedin">
            </v-textbox>

            <!-- Discord -->
            <v-textbox id="discord"
                       class="mb-4"
                       label="Discord"
                       :optional="true"
                       icon="discord fab"
                       v-model="session.forms.account.discord"
                       :error="session.forms.account.errors.discord">
            </v-textbox>

            <!-- YouTube -->
            <v-textbox id="youtube"
                       class="mb-4"
                       label="YouTube"
                       :optional="true"
                       icon="youtube fab"
                       v-model="session.forms.account.youtube"
                       :error="session.forms.account.errors.youtube">
            </v-textbox>

            <!-- Facebook -->
            <v-textbox class="mb-4"
                       id="facebook"
                       :optional="true"
                       label="Facebook"
                       icon="facebook fab"
                       v-model="session.forms.account.facebook"
                       :error="session.forms.account.errors.facebook">
            </v-textbox>

            <!-- Instagram -->
            <v-textbox class="mb-4"
                       id="instagram"
                       :optional="true"
                       label="Instagram"
                       icon="instagram fab"
                       v-model="session.forms.account.instagram"
                       :error="session.forms.account.errors.instagram">
            </v-textbox>

            <!-- Update -->
            <v-button label="Update"
                      id="save-account"
                      class="md:flex justify-end"
                      :processing="session.forms.account.processing"
                      @click="submit(session.forms.account, 'account.update', 'patch', { preserveScroll : true })">
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