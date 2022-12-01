export default
{
    /**
     * Define the data model.
     *
     */
    data() { return {
        reading : {},
    }},

    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Retrieve the reading metrics for the given content.
         *
         */
        readingMetrics(content)
        {
            content = content.trim();

            let words = blank(content) ? 0 : content.split(/\s+/).length;

            this.reading = {
                words      : words,
                characters : content.length,
                minutes    : Math.ceil(words / 225),
            };
        },
    }
}