<template>
	<div class="lookup relative">

		<!-- Control -->
		<div ref="control"
             @mouseover="hover = true"
             @mouseout="hover = false"
			 class="control relative w-full rounded transition duration-400 bg-white border border-gray-400/75">

			<!-- Field -->
			<input :id="name"
				   :name="name"
                   type="hidden"
				   :value="modelValue" />

			<!-- Input -->
			<input type="text"
                   ref="input"
				   v-model="term"
                   max-length="50"
				   @input="search()"
				   autocomplete="off"
                   @focus="focus = true"
				   :id="`${name}_display`"
				   @focusout="focus = false"
				   :name="`${name}_search_display`"
				   class="field appearance-none bg-inherit w-full px-3 text-gray-900 pb-7px pt-25px resize-none rounded" />

			<!-- Label -->
            <v-label :icon="icon"
                     :label="label"
                     :focus="focus"
                     v-if="! dusk()"
                     :optional="optional"
                     :value="filled(modelValue) || filled(term)">
            </v-label>

            <!-- Clear -->
            <v-clear v-if="! dusk()"
                     @clear="clear()"
                     :focus="focus && filled(term)"
                     :hover="hover && filled(term)"
                     :value="filled(modelValue) || filled(term)">
            </v-clear>

		</div>

		<!-- Search Results -->
		<div class="relative">
			<div class="absolute w-full z-50"
                 :class="open ? 'pointer-events-auto' : 'pointer-events-none'">

                <!-- List -->
				<ul ref="list"
					:class="open ? 'open opacity-100 z-50 scale-100' : 'opacity-0 z-minus-1 scale-90'"
                    class="selector transition duration-300 overflow-y-auto list-reset rounded-b bg-white
                           border border-gray-400/75 border-t-0 origin-top-center max-h-[294px]">

					<!-- Items -->
					<li :value="item[v]"
                        v-for="item in items"
						@click="select(item)"
						:id="`lookup-${name}-item-${item[v]}`"
                        :dusk="`lookup-${name}-item-${item[v]}`"
						:class="filled(item[sub]) ? 'py-3' : 'pt-3 pb-1'"
						class="cursor-pointer bg-white px-4 text-gray-700 text-15px relative transition duration-300 hover:bg-yellow-600/10">

                        <!-- Item (Standard) -->
                        <div v-if="! pill"
                             class="truncate"
                             :class="blank(sub) || blank(item[sub]) ? 'pb-7px' : ''">

						    <!-- Title -->
						    {{ item[k] }}

						    <!-- Subtitle -->
                            <pre v-if="sub"
                                 class="text-gray-600/80 text-13px pt-1 mb-0"
                                 :style="item[sub].split('\n').length > 1 ? '' : 'line-height: 1.09'">{{ item[sub] }}</pre>

                        </div>

                        <!-- Item (Pill) -->
                        <div v-if="pill"
                             class="truncate flex justify-between items-center">

                            <!-- Text -->
                            <div class="mr-3">

                                <!-- Title -->
                                <span class="truncate">
                                    {{ item[k] }}
                                </span>

                                <!-- Subtitle -->
                                <pre v-if="sub"
                                     class="text-gray-600/80 text-13px pt-1 mb-0"
                                     :style="item[sub].split('\n').length > 1 ? '' : 'line-height: 1.09'">{{ item[sub] }}</pre>

                            </div>

                            <!-- Pill -->
                            <v-pill color="blue"
                                    :text="item[count]"
                                    class="relative -top-1px"
                                    :title="item?.notice ?? ''">
                            </v-pill>

                        </div>

					</li>

					<!-- Feedback -->
					<li v-show="feedback"
						class="bg-green-600/5 uppercase text-gray-600/90
                               pointer-events-none text-12px relative px-4 pt-13px pb-11px">

                        <!-- Text -->
						{{ feedback }}

					</li>

				</ul>

			</div>
		</div>

        <!-- Error -->
        <v-error :message="message"></v-error>

	</div>
</template>

<script>
    import { debounce } from 'lodash-es';
    import PillComponent from './pill.vue';
    import ClearComponent from './clear.vue';
    import ErrorComponent from './error.vue';
    import LabelComponent from './label.vue';
    import InteractsWithField from '@/mixins/InteractsWithField';
    import InteractsWithOutside from '@/mixins/InteractsWithOutside';

	export default
    {
		/**
		 * Define the mixins.
		 *
		 */
		mixins : [
			InteractsWithField,
			InteractsWithOutside,
		],

        /**
         * Define the components.
         *
         */
        components : {
            'v-pill'  : PillComponent,
            'v-clear' : ClearComponent,
            'v-error' : ErrorComponent,
            'v-label' : LabelComponent,
        },

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
			end      : false,
			open     : false,
			page     : 1,
			term     : '',
			items    : [],
			suffix   : this.url.includes('?') ? '&' : '?',
            working  : false,
			feedback : '',
		}},

        /**
         * Define the events.
         *
         */
        emits : ['selected'],

		/**
		 * Define the public properties.
		 *
		 */
		props : {
			'k'        : { type : String,           default : '' },
			'v'        : { type : String,           default : '' },
			'min'      : { type : Number,           default : 2 },
			'sub'      : { type : String,           default : null },
			'url'      : { type : String,           default : '' },
			'pill'     : { type : Boolean,          default : false },
			'count'    : { type : String,           default : 'count' },
			'image'    : { type : String,           default : null },
			'query'    : { type : [String, Number], default : '' },
            'optional' : { type : Boolean,          default : false },
		},

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on(`lookup-clear-${this.name}`, () => this.clear());
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`lookup-clear-${this.name}`);
        },

		/**
		 * Define the watch methods.
		 *
		 */
		watch :
        {
			/**
			 * Watch the 'value' property.
			 *
			 */
			modelValue : function(current, previous)
			{
                if (! this.working) {
                    this.assignTerm();
                }
			}
		},

		/**
		 * Execute actions when the component is instantiated.
		 *
		 */
		created()
		{
			if (filled(this.modelValue)) {
                this.assignTerm();
            }
		},

		/**
		 * Define the supporting methods.
		 *
		 */
		methods :
        {
            /**
             * Fetch or assign the search term for the component.
             *
             */
            assignTerm()
            {
                if (filled(this.query)) {
                    return this.term = this.query;
                }

                if (blank(this.modelValue)) {
                    return this.term = '';
                }

                window.axios
                    .post(`${this.url}${this.suffix}exact=1&search=${this.modelValue}&page=${this.page}`)
                    .then(response => this.term = response.data.data[0][this.k])
                    .catch(error => console.log(error));
            },

            /**
             * Reset the component.
             *
             */
            clear()
            {
                this.working = true;

                this.change('', '');

                this.term = '';

                this.$emit('selected', {});

                this.hide();

                window.setTimeout(() => this.working = false, 150);
            },

	    	/**
	    	 * Close or hide the component.
	    	 *
	    	 */
	    	closeComponent()
	    	{
                this.hide();
	    	},

			/**
			 * Hide any currently displayed results.
			 *
			 */
			hide()
			{
				this.page     = 1;
				this.open     = false;
				this.feedback = '';
				this.term     = filled(this.modelValue) ? this.term : '';

				this.$refs.control.classList.add('rounded');
				this.$refs.control.classList.remove('rounded-t');

				setTimeout(() => this.items = [], 150);
			},

	    	/**
	    	 * Determine if the component is open or visible.
	    	 *
	    	 */
	    	isComponentOpen()
	    	{
                return this.open;
	    	},

			/**
			 * Attempt to load additional items that match the search query.
			 *
			 */
			more()
			{
				if (this.end) return;

				let position = this.$refs.list.scrollTop;
				let height   = this.$refs.list.scrollHeight - this.$refs.list.clientHeight;

				if (position / height >= 1) {
					this.$refs.list.removeEventListener('scroll', this.more);

					this.feedback = 'Loading more results, please wait...';

					this.page = this.page + 1;

					setTimeout(() => {
                        window.axios
                            .post(`${this.url}${this.suffix}exact=0&search=${this.term}&page=${this.page}`)
                            .then(response => this.parse(response.data, false))
                            .catch(error => console.log(error));
					}, 1000)
				}
			},

			/**
			 * Insert the search results into the component's item list.
			 *
			 */
			parse(results, reset)
			{
				if (! reset && ! this.open) return;

				this.end      = reset ? false : this.end;
				this.items    = reset ? [] : this.items;
				this.open     = true;
				this.feedback = '';

				if (blank(results.data) && blank(this.items)) {
					this.feedback = 'No items were found...'; this.end = true;
				} else if (blank(results.data) && filled(this.items)) {
					this.feedback = 'No more items were found...'; this.end = true;
				} else {
					this.items = this.items.concat(results.data);
				}

				this.$refs.control.classList.remove('rounded');
				this.$refs.control.classList.add('rounded-t');

				this.$refs.list.addEventListener('scroll', this.more);
			},

			/**
			 * Submit a lookup request to the server.
			 *
			 */
			search : debounce(function()
			{
				this.page = 1;
                this.working = true;
				this.change('');

                setTimeout(() => this.working = false);

				if (blank(this.term)) {
					return this.hide();
				}

                if (this.term.length < this.min) {
                    return;
                }

                window.axios
                    .post(`${this.url}${this.suffix}exact=0&search=${this.term}&page=${this.page}`)
                    .then(response => this.parse(response.data, true))
                    .catch(error => console.log(error));
			}, 300),

			/**
			 * Set the component's value using the given payload.
			 *
			 */
			select(item)
			{
				this.page     = 1;
				this.open     = false;
				this.term     = item[this.k];
				this.feedback = '';

				this.$refs.control.classList.add('rounded');
				this.$refs.control.classList.remove('rounded-t');

                this.working = true;

				this.change(item[this.v], item[this.k]);
				this.$emit('selected', item);

				setTimeout(() => this.items = [], 150);
                setTimeout(() => this.working = false, 150);
			},
		}
	}
</script>