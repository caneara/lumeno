<template>
    <div class="hidden">

        <!-- Header -->
        <h4>
            404 - File Not Found
        </h4>

        <!-- Information -->
        <p>
            The page you were trying to access could not be found.
        </p>

    </div>
</template>

<script>
    import markdownit from 'markdown-it';
    import hljs from 'highlight.js/lib/common';
    import 'highlight.js/styles/stackoverflow-light.css';

    export default
    {
        /**
         * Define the public properties.
         *
         */
        props : {
            'file'    : { type : String,  default : '' },
            'html'    : { type : Boolean, default : false },
            'prefix'  : { type : String,  default : '' },
            'content' : { type : String,  default : '' },
            'current' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            if (this.content) {
                return this.parseFile(this.content);
            }

            window.axios
                .get(`${this.file}?${new Date().getTime()}`)
                .then(response => this.parseFile(response.data))
                .catch(error => this.showContent());
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Attach identifiers to each heading.
             *
             */
            assignHeadingIdentifiers()
            {
                this.$el.querySelectorAll('h1, h2, h3, h4, h5, h6, strong').forEach(element => {
                    element.id = `markdown-${element.innerText.replace(/\s|&amp;/g, '-').toLowerCase()}`;
                });
            },

            /**
             * Insert line numbers and render code blocks.
             *
             */
            formatCodeBlock(text, language)
            {
                if (blank(language) || blank(hljs.getLanguage(language))) {
                    return '';
                }

                try {
                    let rendered = hljs.highlight(text, { language : language }).value;

                    const rows = rendered.trim().split('\n').map((line, idx) => {
                        return `<tr>
                                <td class="line-number">${idx + 1}</td>
                                <td class="code-line">${line}</td>
                            </tr>`;
                    });

                    return `<div class="hljs"><table class="code-block"><tbody>${rows.join('')}</tbody></table></div>`;
                } catch {
                    return '';
                }
            },

            /**
             * Retrieve an instance of the Markdown parser.
             *
             */
            getParser()
            {
                let options = {
                    html        : this.html,
                    linkify     : true,
                    typographer : true,
                    quotes      : '“”‘’',
                    highlight   : (text, language) => this.formatCodeBlock(text, language),
                };

                return markdownit('commonmark', options).enable('table');
            },

            /**
             * Render the content within the given response.
             *
             */
            parseFile(text)
            {
                this.$el.innerHTML = `
                    <div class="markdown">
                        <div class="${this.prefix}">
                            ${this.getParser().render(text)}
                        </div>
                    </div>
                `;

                this.setLinkTargets();
                this.removeTrailingSpace();
                this.assignHeadingIdentifiers();
                this.showContent();
                this.scrollToActiveHeading();
            },

            /**
             * Strip the last rendered element's bottom margin and padding.
             *
             */
            removeTrailingSpace()
            {
                if (this.$el.lastElementChild.tagName === 'BLOCKQUOTE') return;

                this.$el.lastElementChild.style.marginBottom = '0px';
                this.$el.lastElementChild.style.paddingBottom = '0px';
            },

            /**
             * Scroll the page to the requested heading.
             *
             */
            scrollToActiveHeading()
            {
                let hash = window.location.hash.substr(1);

                if (filled(hash) && document.getElementById(hash)) {
                    window.scrollTo({
                        behavior : 'smooth',
                        top      : document.getElementById(hash).getBoundingClientRect().top + window.pageYOffset - 90,
                    });
                }
            },

            /**
             * Set the target to a new tab for all external links.
             *
             */
            setLinkTargets()
            {
                Array.from(this.$el.querySelectorAll('a')).forEach(link => {
                    if (this.current && link.href === `${location.origin}${location.pathname}`) {
                        link.parentElement.classList.add('active');
                    }

                    if (location.hostname !== link.hostname || ! link.hostname.length) {
                        link.target = '_blank';
                    } else if (! link.href.includes('#')) {
                        link.href = `javascript:vue.$inertia.get('${link.href.split(location.origin)[1]}')`;
                    } else if (link.href.split('#')[0] === `${location.origin}${location.pathname}`) {
                        link.href = `javascript:document.getElementById('${link.href.split('#')[1]}').scrollIntoView({ behavior : 'smooth', block : 'center' })`;
                    } else {
                        link.href = `javascript:vue.$inertia.get('${link.href.split(location.origin)[1]}')`;
                    }
                });
            },

            /**
             * Make the component's content visible.
             *
             */
            showContent()
            {
                this.$el.classList.remove('hidden');
            },
        }
    }
</script>