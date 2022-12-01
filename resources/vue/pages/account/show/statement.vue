<template>
    <v-panel :stack="true"
             :border="false">

        <!-- Statement -->
        <p class="whitespace-pre-wrap mb-0">
            {{
                prop('account.statement')
                ? prop('account.statement')
                : `${prop('account.name')} has not added a statement.`
            }}
        </p>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-panel' : PanelComponent,
        },
    }
</script>