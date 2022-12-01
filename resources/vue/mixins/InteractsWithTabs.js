export default
{

    /**
     * Execute actions when the component is mounted to the DOM.
     *
     */
    mounted()
    {
        events.on('switch-to-tab', (tab) => this.tabs.show = tab);
    },

    /**
     * Execute actions when the component is unmounted from the DOM.
     *
     */
    unmounted()
    {
        clearEventListener('switch-to-tab');
    },
}