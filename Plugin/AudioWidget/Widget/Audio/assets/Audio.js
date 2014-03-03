/**
 * @package ImpressPages
 *
 */
var IpWidget_Audio;

(function ($) {
    "use strict";

    IpWidget_Audio = function () {


        var $this = this;

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
            this.source = this.popup.find('select[name=source]');

            if (this.data.url) {
                this.url.val(this.data.url);
            } else {
                this.url.val(''); // cleanup value if it was set before
            }




            this.popup.modal(); // open modal popup

            this.confirmButton.off(); // ensure we will not bind second time
            this.confirmButton.on('click', $.proxy(save, this));

            $this.popup.find('.ipsAudioFileList').html(''); // Delete file list
//            this.popup.append(file); // TODO

            if (typeof this.data.audioFiles != 'undefined')
                $.each(this.data.audioFiles, function (key, value) {

                    var cloned = $(".ipsAudioFileTemplate").clone().show();
                    cloned.removeClass('ipsAudioFileTemplate');
                    cloned.find('source').attr('src', value);
                    cloned.appendTo('.ipsAudioFileList');

//                    context.popup.find('.ipsAudioFileList').append('<div><button class="btn btn-default ipsAudioFileMove" type="button" title="Drag"><i class="fa fa-arrows"></i></button><audio controls style="width: 300px; height: 60px;"><source src="' + value + '" type="audio/mpeg">Your browser does not support the audio element.</audio><a href="#" class="ipaButton ipsAudioFileRemove">remove</a> </div>');
                });


            this.popup.find(".ipsAudioFileList").sortable({
                handle: '.ipsAudioFileMove',
                cancel: false
            });


            this.popup.find('.ipsAudioFileRemove').off().on('click', function () {
                    alert('Remove'); // TODO remove file

                }
            );

            this.popup.find('.ipsUploadAudioFile').off().on('click', function (e) {
                e.preventDefault();
                ipBrowseFile($.proxy(addFilesToPopup, this), {preview: 'list'});
            });

            this.popup.find('select[name=source]').off().on('change', function(){
//            $('select[name=source]').change(function () {
                displaySelectedDialog(this.value);

            });

            displaySelectedDialog(this.data.source);

        };

        var save = function () {

            var entry;

            var audioFiles = [];

            var a = this.popup.find('.ipsAudioFileList source');

            for (var i = 0; i < a.length; i++) {

                entry = a[i];
                audioFiles.push($(entry).attr('src'));

            }

            var data = {
                url: this.url.val(),
                source: this.source.val(),
                audioFiles: audioFiles
            };

            this.widgetObject.save(data, 1); // save and reload widget
            this.popup.modal('hide');
        };

        function displaySelectedDialog(strDialog) {

            if (strDialog == 'file'){
                $('#ipsAudioFile').show();
                $('.ipsAudioFileList').show();
                $('#ipsAudioSoundcloud').hide();
                $('.ipsUploadAudioFile').show();
            } else {
                $('#ipsAudioFile').hide();
                $('.ipsAudioFileList').hide();
                $('#ipsAudioSoundcloud').show();
                $('.ipsUploadAudioFile').hide();
            }
        }

        function addFilesToPopup(files) {


            $.each(files, function (key, value) {

                var cloned = $(".ipsAudioFileTemplate").clone().show();
                cloned.removeClass('ipsAudioFileTemplate');
                cloned.find('source').attr('src', value.originalUrl);
                cloned.appendTo('.ipsAudioFileList');

            });

        }

    };

})(ip.jQuery);

