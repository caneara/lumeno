<template>
    <v-modal :headless="true"
             :visible="visible"
             @closed="$emit('closed')">

        <!-- Image -->
        <v-image :source="project"
                 v-if="project[image]"
                 class="md:rounded-md"
                 :type="image.replace('_', '_project_')">
        </v-image>

    </v-modal>
</template>

<script>
    import ImageComponent from '@/components/image.vue';
    import ModalComponent from '@/components/modal.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-image' : ImageComponent,
            'v-modal' : ModalComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['closed'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'image'   : { type : String,  default : '' },
            'project' : { type : Object,  default : {} },
            'visible' : { type : Boolean, default : false },
        },
    }
</script>