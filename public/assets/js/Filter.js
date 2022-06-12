import Controller from './Controller.js';

export default class Filter extends Controller {
    recipientCount = 0;

    connect() {
        this.recipientCount = parseInt(this.el.dataset.recipientCount);
        this.listen('click', 'addFilter', this.addFilter.bind(this));
        this.listen('click', 'deleteFilter', this.deleteFilter.bind(this));
    }

    addFilter() {
        console.log(this.el);
        const list = this.role('filters');
        if (list.children.length >= 10) {
            return;
        }

        // get the template
        const template = this.role('filter-template').innerHTML;

        // create new element from template
        const element = this.createElement(template.replace(/__name__/g, String(this.recipientCount++)));

        // add to recipient list
        list.appendChild(element);
    }

    deleteFilter(element) {
        element.closest('[data-role="filter"]').remove();
    }
}