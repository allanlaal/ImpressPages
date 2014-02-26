/**
 * @package ImpressPages
 *
 */
var IpWidget_Audio;

(function($){
    "use strict";

    IpWidget_Audio = function() {

        this.widgetObject = null;
        this.confirmButton = null;
        this.popup = null;
        this.data = {};
        this.textarea = null;

        this.init = function (widgetObject, data) {

            this.widgetObject = widgetObject;
            this.data = data;

            var container = this.widgetObject.find('.ipsContainer');

            if (this.data.html) { // TODOXX check if not safe mode #129
                container.html(this.data.html);
            }

            var context = this; // set this so $.proxy would work below

            var $widgetOverlay = $('<div></div>')
                .css('position', 'absolute')
                .css('z-index', 5)
                .width(this.widgetObject.width())
                .height(this.widgetObject.height());
            this.widgetObject.prepend($widgetOverlay);
            $widgetOverlay.on('click', $.proxy(openPopup, context));

        };

        this.onAdd = function () {
            $.proxy(openPopup, this)();
        };

        var openPopup = function () {
            var context = this;
            this.popup = $('#ipWidgetAudioPopup');
            this.confirmButton = this.popup.find('.ipsConfirm');
            this.url = this.popup.find('input[name=url]');
            this.size = this.popup.find('select[name=size]');
            this.width = this.popup.find('input[name=width]');
            this.height = this.popup.find('input[name=height]');
            this.ratio = this.popup.find('select[name=ratio]');

            if (this.data.url) {
                this.url.val(this.data.url);
            } else {
                this.url.val(''); // cleanup value if it was set before
            }

            if (this.data.size) {
                this.size.val(this.data.size);
            } else {
                this.size.val('auto'); // cleanup value if it was set before
            }

            if (this.data.width) {
                this.width.val(this.data.width);
            } else {
                this.width.val('853'); // cleanup value if it was set before
            }

            if (this.data.height) {
                this.height.val(this.data.height);
            } else {
                this.height.val('480'); // cleanup value if it was set before
            }

            this.size.on('change', function () {
                $.proxy(showHide, context)();
            });

            $.proxy(showHide, context)();


            this.popup.modal(); // open modal popup

            this.confirmButton.off(); // ensure we will not bind second time
            this.confirmButton.on('click', $.proxy(save, this));
        };

        var save = function () {
            var data = {
                url: this.url.val(),
                size: this.size.val(),
                width: this.width.val(),
                height: this.height.val(),
                ratio: this.ratio.val()
            };

            this.widgetObject.save(data, 1); // save and reload widget
            this.popup.modal('hide');
        };

        var showHide = function () {
            if (this.size.val() == 'auto') {
                this.popup.find('.form-group.name-ratio').show();
                this.popup.find('.form-group.name-width').hide();
                this.popup.find('.form-group.name-height').hide();
            } else {
                this.popup.find('.form-group.name-ratio').hide();
                this.popup.find('.form-group.name-width').show();
                this.popup.find('.form-group.name-height').show();
            }
        }


    };

})(ip.jQuery);
