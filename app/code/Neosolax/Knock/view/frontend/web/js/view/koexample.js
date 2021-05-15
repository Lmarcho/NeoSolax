define(['uiComponent'], function(Component) {

    return Component.extend({
        initialize: function () {
            this._super();
            this.time = Date();
            //time is defined as observable
            this.observe(['time']);
            //periodically updater every second
            setInterval(this.flush.bind(this), 1000);
        },
        flush: function(){
            this.time(Date());
        }
    });
});
