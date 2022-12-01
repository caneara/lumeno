<template>
    <div class="tags">

        <!-- Control -->
        <div :dusk="name"
             class="control flex items-start rounded relative w-full transition duration-400 bg-white border border-gray-400/75 min-h-[53px]">

            <!-- Input -->
            <input type="text"
                   ref="input"
                   placeholder="Tags"
                   @change="process($event.target.value)"
                   class="field rounded appearance-none bg-inherit text-gray-900" />

            <!-- Optional -->
            <v-optional margin="-ml-22px mt-22px"
                        v-if="optional && blank(current)"
                        padding="pl-1 pr-5px pt-1px pb-0">
            </v-optional>

        </div>

    </div>
</template>

<script>
    import Tagify from '@yaireo/tagify';
    import '@yaireo/tagify/dist/tagify.css';
    import OptionalComponent from './optional.vue';
    import InteractsWithField from '@/mixins/InteractsWithField';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithField,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-optional' : OptionalComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            tagify  : null,
            current : '',
        }},

        /**
         * Define the events.
         *
         */
        emits : ['first', 'second', 'third', 'fourth'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'first'    : { type : String,  default : '' },
            'third'    : { type : String,  default : '' },
            'fourth'   : { type : String,  default : '' },
            'second'   : { type : String,  default : '' },
            'optional' : { type : Boolean, default : false },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            this.tagify = new Tagify(this.$refs.input, {
                pattern : /^.{0,20}$/,
                maxTags : 4,
            });

            this.tagify.addTags([this.first, this.second, this.third, this.fourth].filter(i => i));
		},

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
			/**
			 * Notify the parent component of a change in the tags.
			 *
			 */
			process(tags)
			{
                this.current = tags;

                if (blank(tags)) {
                    return ['first', 'second', 'third', 'fourth'].forEach(element => this.$emit(element, ''));
                }

                tags = JSON.parse(tags);

                this.$emit('first',  tags.length >= 1 ? tags[0].value : '');
                this.$emit('second', tags.length >= 2 ? tags[1].value : '');
                this.$emit('third',  tags.length >= 3 ? tags[2].value : '');
                this.$emit('fourth', tags.length >= 4 ? tags[3].value : '');
			},
        },
    }
</script>