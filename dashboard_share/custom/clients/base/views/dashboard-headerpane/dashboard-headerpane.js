({
    extendsFrom: 'DashboardHeaderpaneView',


    initialize: function(options){
        this._super('initialize', [options]);

        var view = this;
        this.model.fetch({success: function(resp){
            var metadata = resp.get('metadata');
            if (!metadata.allow_edit) {
                _.each(view.meta.buttons[0].buttons, function(el, i) {
                    if (el.name == "edit_button" || el.name == "share_button") {
                        view.meta.buttons[0].buttons.splice(i,1);
                    }
                });
            }
            view.render();
        }});
        this.events = _.extend({}, this.events, {'click [name=share_button]': 'shareClicked'});
    },

    shareClicked: function() {
        app.drawer.open({
            layout:'dashboard-share-config',
            context:{
                create: true,
                dashboardId: this.model.get('id'),
                dashboardName: this.model.get('name')
            }
        });
    }
})