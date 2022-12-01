<template>
    <div class="border-t border-gray-300/70 pt-10 mt-10">

        <!-- Header -->
        <h5>
            Getting started
        </h5>

        <!-- Information -->
        <p class="mb-10">

            <!-- Text -->
            It looks like you haven't added any skills yet. You can

            <!-- Link -->
            <v-link :action="() => events.emit('open-create-skill-modal')">
                add them manually,
            </v-link>

            <!-- Text -->
            or you can get a head start by selecting from some of the most popular
            tools shown below. If necessary, edit the skills after they've been
            saved to add any important details e.g. familarity with certain
            versions. You can also

            <!-- Link -->
            <v-link :action="() => events.emit('open-create-tool-modal')">
                add tools
            </v-link>

            <!-- Text -->
            to the library if something is missing.

        </p>

        <!-- Matrix -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-4">

            <!-- Tool -->
            <div :title="tool.title"
                 v-for="tool in tools"
                 @click="toggle(tool)"
                 :dusk="`select-${tool.ref}`"
                 class="border h-[140px] flex flex-col justify-center items-center rounded-lg cursor-pointer p-5"
                 :class="form[tool.ref] ? 'bg-green-600/5 border-emerald-600/70' : 'border-dashed border-gray-400/80'">

                <!-- Icon -->
                <img class="h-70px"
                     :class="form[tool.ref] ? 'mb-3' : ''"
                     :src="asset(`img/tools/${tool.ref}.svg`)">

                <!-- Years -->
                <span class="text-15px text-gray-700">
                    {{ form[tool.ref] ? metric(form[tool.ref], 'year') : '' }}
                    {{ form[tool.ref] && form[tool.ref] === 10 ? '+' : '' }}
                </span>

            </div>

        </div>

        <!-- Save -->
        <v-button label="Save"
                  class="md:flex justify-end"
                  :processing="form.processing"
                  @click="submit(form, 'skills.setup')">
        </v-button>

    </div>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import ButtonComponent from '@/components/button.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-link'   : LinkComponent,
            'v-button' : ButtonComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                javascript : '',
                php        : '',
                python     : '',
                csharp     : '',
                css        : '',
                html       : '',
                java       : '',
                vue        : '',
                react      : '',
                swift      : '',
                mysql      : '',
                postgres   : '',
                figma      : '',
                sketch     : '',
                docker     : '',
                aws        : '',
            }, 'setup'),

            tools : [
                {
                    ref        : 'javascript',
                    title      : 'JavaScript',
                    originated : 2010,
                }, {
                    ref        : 'php',
                    title      : 'PHP',
                    originated : 2010,
                }, {
                    ref        : 'python',
                    title      : 'Python',
                    originated : 2010,
                }, {
                    ref        : 'csharp',
                    title      : 'C#',
                    originated : 2010,
                }, {
                    ref        : 'html',
                    title      : 'HTML',
                    originated : 2010,
                }, {
                    ref        : 'java',
                    title      : 'Java',
                    originated : 2010,
                }, {
                    ref        : 'vue',
                    title      : 'VueJS',
                    originated : 2014,
                }, {
                    ref        : 'css',
                    title      : 'CSS',
                    originated : 2010,
                }, {
                    ref        : 'react',
                    title      : 'React',
                    originated : 2013,
                }, {
                    ref        : 'mysql',
                    title      : 'MySQL',
                    originated : 2010,
                }, {
                    ref        : 'postgres',
                    title      : 'PostgreSQL',
                    originated : 2010,
                }, {
                    ref        : 'swift',
                    title      : 'Swift',
                    originated : 2014,
                }, {
                    ref        : 'aws',
                    title      : 'AWS',
                    originated : 2010,
                }, {
                    ref        : 'figma',
                    title      : 'Figma',
                    originated : 2016,
                }, {
                    ref        : 'sketch',
                    title      : 'Sketch',
                    originated : 2010,
                }, {
                    ref        : 'docker',
                    title      : 'Docker',
                    originated : 2013,
                },
            ],
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Toggle whether to include the tool as a skill.
             *
             */
            toggle(tool)
            {
                if (this.form[tool.ref]) {
                    return this.form[tool.ref] = '';
                }

                let years = prompt('How many years experience do you have?')?.trim();

                if (/^[1-9]\d*$/g.exec(years) === null) return;

                let experience = Math.min(Math.max(parseInt(years), 1), 10);

                if (this.yearsOld(tool.originated) < experience) {
                    alert("The tool hasn't existed for that long");

                    return this.form[tool.ref] = '';
                }

                this.form[tool.ref] = Math.min(Math.max(parseInt(years), 1), 10);
            },
        }
    }
</script>