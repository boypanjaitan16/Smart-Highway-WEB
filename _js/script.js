/**
 * Created by Boy Panjaitan on 21/03/2017.
 */
$(document).ready(function () {

    $(document).on('click','[data-plugin="logout"]',function () {
        var href    = $(this).attr('data-href');

        $.ajax({
            url     : href,
            data    : {'action':'logout'},
            method  : 'post',
            dataType: 'json',
            beforeSend  : function () {
                defaultConfig.loadingText('Logging Out ...');
            },
            error   : function () {
                defaultConfig.error();
            },
            success : function (data) {
                if (data.status === 'success'){
                    window.location=$('base').attr('href');
                }
                else {
                    defaultConfig.gagal(data.message);
                }
            }
        });
    });

    $(document).on('click', '#changeDP', function () {
        var fdp     = $('#fileDP');
        var fodp    = $('#formDP');

        if(fdp.val() === null || fdp.val() === ''){
            fdp.click();
        }
        else{
            console.log('now submitting file');
            /*fodp.ajaxSubmit({

            });*/
        }
    });

    $(document).on('change', '#fileDP', function () {
        var cdp     = $('#changeDP');
        var fdp     = $('#fileDP');

        if (this.files && this.files[0]){
            var element = this.files[0];
            var size    = element.size;
            var img     = $('#imgDP');
            var reader  = new FileReader();

            reader.onloadstart  = function () {
                img.attr('src', '../images/icon/load.png');
            };

            reader.onload   = function (e) {
                var image   = new Image();
                var _URL    = window.URL || window.webkitURL;

                image.onload    = function () {
                    if(this.width >= 100 && this.height >= 100){
                        img.attr('src', e.target.result);

                        cdp.removeClass('btn-warning').addClass('btn-success').html('<i class="icon-upload"></i> Unggah Foto');
                        cdp.attr('data-plugin', 'submit').attr('data-target','#formDP');
                    }
                    else {
                        fdp.val(null);
                        defaultConfig.gagal('Ukuran gambar terlalu kecil');
                    }
                };

                image.src = _URL.createObjectURL(element);
            };

            reader.readAsDataURL(this.files[0]);

        }
        else{
            cdp.removeClass('btn-success').addClass('btn-warning').html('Ubah');
        }
    });

});