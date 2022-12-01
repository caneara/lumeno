/**
 * Import the dependencies.
 *
 */
import { reactive, createApp } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ShareComponent from '@/components/share.vue';
import ConfirmComponent from '@/components/confirm.vue';

/**
 * Export the module.
 *
 */
export default { register() { [window, window.app.config.globalProperties].forEach((target) =>
{
	/**
	 * Attach a new element to the page.
	 *
	 */
	target.addElement = (name) =>
	{
        if (document.getElementById(name)) return;

        let container = document.createElement('div');

        container.id = name;

        document.body.appendChild(container);
	},

    /**
     * Generate the complete url to the given application asset.
     *
     */
    target.asset = (path) =>
    {
        return `${prop('asset')}${path}`;
    }

    /**
     * Determine if the given value is empty.
     *
     */
    target.blank = (value) =>
    {
        if (Array.isArray(value)) {
            return value.length === 0;
        }

        if (value instanceof Date) {
            return false;
        }

        if (typeof value === 'object' && value !== null) {
            return Object.keys(value).length === 0 &&
                Object.getOwnPropertyNames(value).length === 0;
        }

        return ['', null, undefined].includes(value);
    }

    /**
     * Initialize the application.
     *
     */
    target.bootstrap = (module) =>
    {
        createSession();

        defineProperties();

        return module.default;
    }

    /**
     * Clear all event listeners with the given name from the global event bus.
     *
     */
    target.clearEventListener = (name) =>
    {
        events.all.delete(name);
    }

	/**
	 * Generate a confirmation request.
	 *
	 */
	target.confirmAction = (message, action) =>
	{
        addElement('vue-confirm-component');

        self.confirm_action = action;

        self.confirm_element = createApp({ template : `<v-confirm message="${message}"></v-confirm>` });

        self.confirm_element.component('v-confirm', ConfirmComponent);

        self.confirm_element.mount('#vue-confirm-component');
	}

	/**
	 * Copy the given text to the clipboard.
	 *
	 */
	target.copyToClipboard = (text) =>
	{
        let el = document.createElement('textarea');

        el.value = text;

        document.body.appendChild(el);

        el.select();

        document.execCommand('copy');

        document.body.removeChild(el);

        showNotification('Copied to the clipboard');
	}

    /**
     * Create an AJAX / XHR form.
     *
     */
    target.createAjaxForm = (data = {}) =>
    {
        return {
            ...data,
            ajax       : true,
            processing : false,
            errors     : Object.keys(data).reduce((carry, key) => { carry[key] = ''; return carry }, {}),
            clear() {
                for (const [key, value] of Object.entries(data)) {
                    this[key] = '';
                    this.errors[key] = '';
                }
            },
            submit(route, method, options) {
                this.errors = Object.keys(data).reduce((carry, key) => { carry[key] = ''; return carry }, {}),

                this.processing = true;

                let payload = {};

                Object.entries(this).map(i => ['submit', 'transform'].includes(i[0]) ? null : payload[i[0]] = i[1]);

                let configuration = {
                    url    : route,
                    method : method,
                };

                configuration[method === 'get' ? 'params' : 'data'] = payload;

                if (! (options?.handle ?? true)) return axios(configuration);

                return axios(configuration)
                .catch(error => {
                    if (error.response.status !== 422) {
                        showNotification(error.response.data.message, 'error');

                        throw new Error('The server rejected the submission');
                    }

                    let messages = error.response.data.errors;

                    Object.keys(messages).map(k => this.errors[k] = messages[k][0]);

                    throw new Error('The server rejected the submission');
                })
                .finally(() => this.processing = false);
            },
            transform(callback) {
                transform = callback;

                return this;
            },
        }
    },

    /**
     * Create an Inertia form.
     *
     */
    target.createInertiaForm = (data = {}, key = '', remember = true) =>
    {
        key = key ? key : Math.floor(Math.random() * 100000000000);

        let form = useForm(data, { key : key, remember : remember });

        form.clear = function() {
            for (const [key, value] of Object.entries(this.data())) {
                this[key] = '';
                this.errors[key] = '';
            }
        };

        return form;
    }

    /**
     * Create a new session.
     *
     */
    target.createSession = () =>
    {
        if (blank(self.session)) {
            self.session = reactive({ });
        }
    }

    /**
     * Attach custom properties to the Window and Vue instance.
     *
     */
    target.defineProperties = () =>
    {
        Object.defineProperty(self, 'vue', {
            configurable : true, get : () => self.app.config.globalProperties,
        });

        Object.defineProperty(self.app.config.globalProperties, 'window', {
            configurable : true, get : () => self,
        });

        Object.defineProperty(self.app.config.globalProperties, 'events', {
            configurable : true, get : () => self.events,
        });

        Object.defineProperty(self.app.config.globalProperties, 'route', {
            configurable : true, get : () => self.route,
        });

        Object.defineProperty(self.app.config.globalProperties, 'session', {
            configurable : true, get : () => self.session,
        });
    }

    /**
     * Force Inertia to refresh the page when using history.
     *
     */
    target.disablePageCaching = (event) =>
    {
        event.stopImmediatePropagation();

        vue.$inertia.reload({
            preserveState  : false,
            preserveScroll : false,
            replace        : true,
            onSuccess      : (page) => vue.$inertia.setPage(page),
            onError        : () => location.href = event.state.url,
        });
    }

    /**
     * Determine if the web browser is running Laravel Dusk tests.
     *
     */
    target.dusk = () =>
    {
        return document.body.classList.contains('dusk');
    }

    /**
     * Generate a complete url to the given file.
     *
     */
    target.file = (file) =>
    {
        return prop('storage').startsWith('/')
            ? `${location.origin}${prop('storage')}${file}`
            : `${prop('storage')}${file}`;
    }

    /**
     * Determine if the given value is not empty.
     *
     */
    target.filled = (value) =>
    {
        return ! blank(value);
    }

    /**
     * Load an external JavaScript file or library.
     *
     */
    target.loadScript = (url) =>
    {
        let loaded = Array.from(document.getElementsByTagName('script'))
                          .filter(script => script.src === url)
                          .length;

        if (loaded) return;

        let script = document.createElement('script');

        script.src = url;

        document.getElementsByTagName('head')[0].appendChild(script);
    }

    /**
     * Retrieve or change the Inertia page property with the given key.
     *
     */
    target.prop = (key, fallback = '') =>
    {
        if (! Array.isArray(key)) {
            return key.split('.').reduce((p, c) => p && p[c], vue.$page.props) ?? fallback;
        }

        return key[0].split('.').reduce(function(p, c, i) {
            return (i + 1 == key[0].split('.').length) ? p[c] = key[1] : p[c] = p[c] || {};
        }, vue.$page.props);
    }

    /**
     * Retrieve the query string value for the given key.
     *
     */
    target.queryString = (key = null, fallback = '') =>
    {
        let query = new URLSearchParams(location.search.substring(1));

        if (! key) {
            return query;
        }

        let value = query.get(key) ?? fallback;

        if (blank(value) || isNaN(value)) {
            return value;
        }

        if (parseInt(value).toString() === value) {
            return parseInt(value);
        }

        return parseFloat(value);
    }

    /**
     * Send the user to the route with the given name.
     *
     */
    target.redirect = (route, preserveScroll = false) =>
    {
        if (typeof route === 'string') {
            route = [route];
        }

        vue.$inertia.get(self.route(...route), {}, { preserveScroll : preserveScroll });
    }

	/**
	 * Display a share sheet to the user.
	 *
	 */
	target.shareLink = (url = '') =>
	{
        url = url ? url : window.location.href;

        addElement('vue-share-component');

        self.notice_element = createApp({ template : `<v-share url="${url}"></v-share>` });

        self.notice_element.component('v-share', ShareComponent);

        self.notice_element.mount('#vue-share-component');
	},

    /**
     * Send a new notification to the user.
     *
     */
    target.showNotification = (message, type = 'success', fixed = false) =>
    {
        if (typeof message === 'object') {
            type    = message.type;
            fixed   = message.fixed;
            message = message.message;
        }

        events.emit('show-notification', [message, type, fixed]);
    }

    /**
     * Submit the given form to the server.
     *
     */
    target.submit = (form = null, url, method = 'post', options = {}) =>
    {
        if (! form) {
            form = createAjaxForm();
        }

        if (typeof url === 'string') {
            url = [url];
        }

        if (form.hasOwnProperty('ajax')) {
            return form.submit(route(...url), method, options);
        }

        if (['put', 'patch', 'delete'].includes(method)) {
            let revised_method = method;

            form = form.transform((data) => ({ ...data, '_method' : revised_method }));

            method = 'post';
        }

        let defaults = { preserveState : 'errors', preserveScroll : 'errors' };

        form.clearErrors();

        document.body.style.overflow = 'auto';

        return form.submit(method, route(...url), Object.assign(defaults, options));
    }

	/**
	 * Execute the given closure when the given conditional closure evaluates to true.
	 *
	 */
	target.when = (conditional, closure) =>
	{
        (async() => {
			while(! conditional()) {
				await new Promise((resolve, reject) => setTimeout(resolve, 50));
			}

			return closure();
		})();
	}
})}}