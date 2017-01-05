
({
    extendsFrom: 'DashletToolbarView',

    render: function() {
        var metadata = this.layout.model.get('metadata');
        if (!metadata.allow_edit) {
            _.each(this.meta.buttons[1].dropdown_buttons, function(el, i) {
                if (el.action == "editClicked" || el.action == "removeClicked") {
                    this.meta.buttons[1].dropdown_buttons.splice(i,1);
                }
            }, this);
        }
        this._super("render");
    }
})