export default
{
    /**
     * Define the supporting methods.
     *
     */
    methods :
    {
        /**
         * Process the given date into its correct display format.
         *
         */
        date(value)
        {
            let options = {
                day   : 'numeric',
                month : 'short',
                year  : 'numeric',
            };

            value = typeof value === 'string' ? new Date(value.split('.')[0]) : value;

            return new Intl.DateTimeFormat('en-US', options).format(value);
        },

        /**
         * Process the given date and time into its correct display format.
         *
         */
        dateTime(value)
        {
            return `${this.date(value)} - ${this.time(value)}`;
        },

        /**
         * Restrict the given value to a maximum number of characters.
         *
         */
        limit(value, length, suffix = '...')
        {
            if (value.length <= (length + suffix.length)) {
                return value;
            }

            return `${value.substring(0, length)}${suffix}`;
        },

        /**
         * Generate a metric using the given value and noun.
         *
         */
        metric(value = '', noun = '', suffix = 's')
        {
            return `${this.round(value, 0)} ${this.singularOrPlural(value, noun, suffix)}`;
        },

        /**
         * Process the given financial value into its correct display format.
         *
         */
        money(value, currency = 'USD')
        {
            let options = {
                style                 : 'currency',
                currency              : currency,
                minimumFractionDigits : 20,
            };

            return this.number(value, 2, options);
        },

        /**
         * Process the given numerical value into its correct display format.
         *
         */
        number(value, fraction = 2, options = { style : 'decimal', minimumFractionDigits : 20 })
        {
            let parts = new Intl.NumberFormat([], options).formatToParts(value);

            let trailing = Array.from(Array(20).keys()).map(item => new Array(item + 2).join('0'));

            parts = parts.map(part => {
                if (part.type === 'fraction') {
                    part.value = part.value.substring(0, fraction);
                }

                return part.type === 'fraction' && trailing.includes(part.value) ? null : part;
            });

            parts = parts.filter(part => filled(part) && filled(part.value));

            if (parts.find(part => part.type === 'decimal') && parts.find(part => part.type === 'fraction') === undefined) {
                parts = parts.filter(part => part.type !== 'decimal');
            }

            return parts.map(part => part.value).join('');
        },

        /**
         * Round the given value into thousands, millions or billions.
         *
         */
        round(value, fallback = '')
        {
            if (blank(value)) {
                return filled(fallback) ? fallback : value;
            }

            if (value < 1000) {
                return this.number(value);
            }

            let fn = (value) => {
                let regex = new RegExp(`^-?\\d+(?:\\.\\d{0,1})?`);

                return parseFloat(value).toString().match(regex)[0].replace('.0', '');
            }

            if (value < 1000000) {
                return fn(value / 1000) + 'K';
            }

            if (value < 1000000000) {
                return fn(value / 1000000) + 'M';
            }

            return fn(value / 1000000000) + 'B';
        },

        /**
         * Determine whether to use the singular or plural form of the given noun.
         *
         */
        singularOrPlural(value, noun, suffix = 's')
        {
            let plural = suffix.startsWith('$') ? suffix.slice(1) : `${noun}${suffix}`;

            return parseInt(value) === 1 ? noun : plural;
        },

        /**
         * Process the given time into its correct display format.
         *
         */
        time(value)
        {
            let options = {
                hour12 : false,
                hour   : 'numeric',
                minute : '2-digit',
            };

            value = typeof value === 'string' ? new Date(value) : value;

            return new Intl.DateTimeFormat([], options).format(value);
        },

        /**
         * Determine the difference in years between the given value and the current date.
         *
         */
        yearsOld(value)
        {
            let current = new Date().getFullYear();

            if (current === value) return 1;

            return current - value > 10 ? 10 : current - value;
        },
    }
}