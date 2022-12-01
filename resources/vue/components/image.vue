<template>
    <div class="image">
        <img :class="$attrs?.class ?? ''"
             :alt="source[alt[type]] ?? ''"
             class="object-cover object-center"
             @error="$el.firstChild.src = getImage()"
             :src="getImage(source[reference[type]] ?? '')">
    </div>
</template>

<script>
    import InteractsWithImages from '@/mixins/InteractsWithImages';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithImages,
        ],

        /**
         * Define the data model.
         *
         */
        data() { return {
            alt : {
                user                 : 'name',
                project              : 'title',
                first_project_image  : 'title',
                second_project_image : 'title',
                third_project_image  : 'title',
                organization         : 'name',
            },

            reference : {
                user                 : 'avatar',
                project              : 'logo',
                first_project_image  : 'first_image',
                second_project_image : 'second_image',
                third_project_image  : 'third_image',
                organization         : 'avatar',
            },

            method : {
                user                 : 'userAvatar',
                project              : 'projectLogo',
                first_project_image  : 'projectGalleryImage',
                second_project_image : 'projectGalleryImage',
                third_project_image  : 'projectGalleryImage',
                organization         : 'organizationAvatar',
            }
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'type'   : { type : String, default : '' },
            'source' : { type : Object, default : {} },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the desired image.
             *
             */
            getImage(file)
            {
                return this[this.method[this.type]](file);
            }
        }
    }
</script>
