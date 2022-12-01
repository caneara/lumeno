<template>
    <v-panel :border="false">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h6>
                Identity
            </h6>

            <!-- Text -->
            <p class="mb-4 md:mb-7">
                Update your main details, such as
                your name and email address.
            </p>

            <!-- Tip -->
            <p class="text-14px text-gray-600/90 mb-0">
                Your email address will be used to send
                you any vacancy invitations. It is not
                shared with potential employers.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Handle -->
            <v-sticker id="handle"
                       class="mb-4"
                       label="User name"
                       :text="`@${prop('user.handle')}`">
            </v-sticker>

            <!-- Name -->
            <v-textbox id="name"
                       fill="name"
                       icon="user"
                       class="mb-4"
                       label="Name"
                       v-model="session.forms.account.name"
                       :error="session.forms.account.errors.name">
            </v-textbox>

            <!-- Email Address -->
            <v-textbox id="email"
                       fill="email"
                       class="mb-4"
                       icon="envelope"
                       label="Email address"
                       v-model="session.forms.account.email"
                       :error="session.forms.account.errors.email">
            </v-textbox>

            <!-- Update -->
            <v-button label="Update"
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
    import StickerComponent from '@/components/sticker.vue';
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
            'v-sticker' : StickerComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>