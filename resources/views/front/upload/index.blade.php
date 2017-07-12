@extends('layouts.base')
@section('title', 'Upload')
@section('metadata')
    <script src="{!! url('js/bootstrap-tab.min.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.ui.widget.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/tmpl.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/load-image.min.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/canvas-to-blob.min.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.iframe-transport.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.fileupload.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.fileupload-process.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.fileupload-resize.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.fileupload-validate.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/jquery.fileupload-ui.js') !!}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{!! url('css/jquery.fileupload.css') !!}">
@stop

@section('content')
    <?php $folder = json_decode(json_encode($folder), false);

    ?>

    <div class="transparent-content">
        <div class='page-title'>
        <span class='upload-page-title'>
            File Uploader
            @if( Auth::check() )
                {{ is_null( $folder ) ? 'root' : 'folder: ' . $folder->folder_name }}
            @endif
        </span>
        </div>
        <div class="upload-tabs-holder">
            <ul class="upload-tabs">
                <li class="{{ in_array( Request::segment(1), array('', 'local-upload') ) ? 'active' : '' }}"><a
                            href="{{ URL::to('/') }}" class="local-upload">LOCAL UPLOAD</a></li>
                <li class="{{ in_array( Request::segment(1), array('remote-upload') ) ? 'active' : '' }}"><a
                            href="{{ URL::to('/remote-upload')}}" class="remote-upload">REMOTE UPLOAD</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="upload-tab-body" style="padding-bottom:20px;">
            @if ( ! $server_off  )
                @if ( in_array( Request::segment(1), array( 'remote-upload' ) ) )
                    <div class="upload-tab-body" style="padding-bottom:0;">

                        <form id="remote_upload_form" method="POST" action="{!! url('upload/do-remote-upload') !!}">

                            @if ( ! is_null( $folder ) )
                                <input type="hidden" name="server[upload_to]" value="{{ $folder->id }}"/>
                            @endif

                        <!-- Get ID of filenas server -->
                            <input type="hidden" name="server[filenas_id]" value="{{ $random_server->id }}">

                            <input type="hidden" name="server[user_id]"
                                   value="{{ Auth::check() ? Auth::user()->id : 0 }}">

                            <!-- Get filenas id / space used / files of server -->
                            <input type="hidden" name="server[stats]"
                                   value="{{ $random_server->id . '@@' . $random_server->space_used . '@@' . $random_server->files }}">
                            <input type="hidden" value="{{ $server->id }}" name="server[server_id]">
                            <input type="hidden" name="server[country_code]" value="{{ get_country_code( Request::getClientIp(), 'Country Code' )  }}">
                            <input type="hidden" value="{!! str_finish(url('/'), '/') !!}" name="server[server_ip]">
                                <input type="hidden" value="{!! Request::getClientIp() !!}" name="server[ip]">


                            <div class="remote-upload-holder">

                                <textarea id="remote_url_files" placeholder="Enter up to 10 urls" class="form-control" cols="40"
                                          rows="10"></textarea>
                            </div>
                            <!--<div class="remote-upload-and">
                                AND
                            </div>-->
                            <div class="upload-files-btn-holder" id="btn_transfer_files_box">
                                <div class="upload-tos"><span id="tos_text">I have read and agree to the TOS</span>
                                    <input type="checkbox" class="upload-tos_cb" id="tos_cb_remote" data-onetime-check>
                                </div>
                            </div>
                            <br/>
                            <div class="text-center">
                                <input type="button" value="Transfer Files" class="btn btn-upload disabled"
                                       id="btn_transfer_files"/>
                                <div id="remote-progress-text"></div>
                            </div>
                            <table id="remote-upload-result" class="table table-striped"></table>
                        </form>
                    </div>
                @else
                    <div id="fileuploader">
                        <form method="POST" action="{!! url('upload/do-upload') !!}" id="file_uploader_form"
                              enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            @if ( ! is_null( $folder ) )
                                <input type="hidden" name="server[upload_to]" value="{{ $folder->id }}"/>
                        @endif

                        <!-- Get ID of filenas server -->
                            <input type="hidden" name="server[filenas_id]" value="{{ $random_server->id }}">

                            <input type="hidden" name="server[user_id]"
                                   value="{{ Auth::check() ? Auth::user()->id : 0 }}">

                            <!-- Get filenas id / space used / files of server -->
                            <input type="hidden" name="server[stats]"
                                   value="{{ $random_server->id . '@@' . $random_server->space_used . '@@' . $random_server->files }}">
                            <input type="hidden" value="{{ $server->id }}" name="server[server_id]">
                            <input type="hidden" name="server[country_code]"
                                   value="{{ get_country_code( Request::getClientIp(), 'Country Code' )  }}">
                            <input type="hidden" value="{!! Request::getClientIp() !!}" name="server[server_ip]">
                            <div class="upload-drop-files">
                                <div class="upload-drop-files-inner">
                                    <div><span class="drag-files-title">Drag your files here</span></div>
                                    <div class="upload-or">OR</div>
                                    <div class="select-files-btn-holder fileinput-button">
                                        <input type="file" multiple name="file" id="fileuploads" style="display: none">
                                        <button type="button" class="btn btn-select-files" id="select-files">
                                            Select the files
                                        </button>
                                    </div>
                                    <div class="upload-filename" id="nfs123">No file selected</div>

                                    <div class="upload-tos ut1"><span
                                                id="tos_text">I have read and agree to the TOS</span> <input
                                                type="checkbox" style="margin-left:5px;" class="upload-tos_cb"
                                                id="tos_cb_form"></div>
                                </div>
                            </div>
                            <br/>

                            <!-- The container for the uploaded files -->
                            <div id="files" class="files upload-progress"></div>

                            <div id="fileupload-progresstextRight"></div>

                            <div class="upload-files-btn-holder">
                                <div class="fileupload-buttonbar" id="upload_all_box" style="display:block">
                                    <div class="upload-tos ut2"></div>
                                    <p></p>
                                    <button type="submit" id="upload_all" class="btn btn-upload start disabled">Upload
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>No Available File Servers or local file server is turned off</h1>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog small-modal">
            <div class="modal-content">

                <div class="modal-body">
                    <div class='page-title'>
                        Terms and Conditions
                    </div>
                    <div class="terms-popup-text">
                        Sorry but in order to upload<br/>
                        you must agree with the<br/>
                        Terms and Conditions of the website
                    </div>

                    <div class="terms-popup-button">
                        <button class="btn btn-default" data-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <iframe id="remote-upload-progresser" style="display:none"></iframe>
    <script>
        $(function () {
            $('#select-files').on('click', function (evt) {
                evt.preventDefault();

                $('#fileuploads').trigger('click');

                return false;
            });

            $('[data-onetime-check]').on('click', function () {
                var self = $(this);

                if (self.prop('checked')) {
                    self.attr('disabled', 'disabled');
                }
            });
        });
    </script>
    <style type="text/css">
        .upload-rpogress-text {
            width: 600px;
        }

        .upload-progress-bar {
            float: left;
        }
    </style>
    <script id="template-upload" type="text/x-tmpl">
{% if ( $( "#tos_cb_form" ).prop( 'checked' ) == true && o.files.length > 0) $( '#upload_all' ).removeClass( 'disabled' ); %}
{% if (o.files.length > 0) { $('.ut2').append($('.ut1').children()); } %}
{% for (var i=0, file; file=o.files[i]; i++) { %}

    <div class="template-upload upload-progress-box">
        <div class="upload-progress-image">
            <span class="preview"></span>
        </div>
        <div class="upload-rpogress-text">
            <div class="upload-progress-title">
                <p class="name" style="word-break:break-all;">{%=file.name%} ( <span class="size">Processing...</span> )</p> 

                <div class="upload-progress-bar">
                    <div class="progressbar-text">
                        
                    </div>
                    <div class="progress progress-striped active" aria-valuenow="0">
                        <div class="progress-bar bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
             
            </div>
            
            <div class="upload-progress-btn-holder" style="margin-left: 15px; margin-top: 0px; float:right;">
                <button class="btn btn-cancel cancel" style="float:right;" onclick="if ($('.cancel').length == 1) { $('.ut1').append($('.ut2').children()); $( '#upload_all' ).addClass( 'disabled' );} cancelFile({%=file.size%});">
                    <span>Cancel</span>
                </button><div style="clear:both"></div>
                <div class="upload-progress-desc speed"></div>

            </div>
            <input type="hidden" class="filesize" style="word-break:break-all;" value="{%=file.size%}">
        <div class="clearfix"></div>
    </div>

{% } %}

    </script>
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">

    </tr>
    <tr style="display:none; position:absolute" id="upload-{%=file.file_id%}">
        <td colspan="4">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Download URL</td>
                        <td>
                            <a href="{{ url('file') }}{%=file.krypt_id%}">
                                {{ url('file') }}{%=file.krypt_id%}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Delete URL</td>
                        <td>
                            <a href="{!! url('file/delete') !!}{%=file.krypt_id%}/{%=file.delete_hash%}">
                                {{ url('file/delete') }}{%=file.krypt_id%}/{%=file.delete_hash%}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>HTML Code</td>
                        <td>
                            <textarea><a href="{{ url('file') }}{%=file.krypt_id%}" target="_blank" title="Download From File Upload Script">download {%=file.name%} from File Upload Script</a></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Forum Code</td>
                        <td>
                            <input type="text" value="{!! url('file') !!}{%=file.krypt_id%}" />
                        </td>
                    </tr>
                    <tr>
                        <td>Full Info</td>
                        <td>
                            <a href="{!! url('files/info') !!}{%=file.krypt_id%}">
                                [click here]
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
{% } %}

    </script>

    <script type="text/javascript">
        var startTime = null;
        function bytesToSize(bytes, precision) {
            var kilobyte = 1024;
            var megabyte = kilobyte * 1024;
            var gigabyte = megabyte * 1024;
            var terabyte = gigabyte * 1024;

            if ((bytes >= 0) && (bytes < kilobyte)) {
                return (bytes).toFixed(precision) + ' B';

            } else if ((bytes >= kilobyte) && (bytes < megabyte)) {
                return (bytes / kilobyte).toFixed(precision) + ' KB';

            } else if ((bytes >= megabyte) && (bytes < gigabyte)) {
                return (bytes / megabyte).toFixed(precision) + ' MB';

            } else if ((bytes >= gigabyte) && (bytes < terabyte)) {
                return (bytes / gigabyte).toFixed(precision) + ' GB';

            } else if (bytes >= terabyte) {
                return (bytes / terabyte).toFixed(precision) + ' TB';

            } else {
                return bytes + ' B';
            }
        }

        function humanReadableTime(seconds) {
            var numhours = Math.floor(( ( seconds % 31536000 ) % 86400 ) / 3600);
            var numminutes = Math.floor(( ( ( seconds % 31536000 ) % 86400 ) % 3600 ) / 60);
            var numseconds = Math.floor(( ( ( seconds % 31536000 ) % 86400 ) % 3600 ) % 60);

            rs = '';
            if (numhours > 0) {
                rs += numhours + " hour";
                if (numhours != 1) {
                    rs += "s";
                }
                rs += " ";
            }
            if (numminutes > 0) {
                rs += numminutes + "min";
                if (numminutes != 1) {
                    rs += "";
                }
                rs += " ";
            }
            rs += numseconds + "sec";
            if (numseconds != 1) {
                rs += "";
            }

            return rs;
        }

        function updateTitleWithProgress(progress) {
            if (typeof( progress ) == "undefined") {
                var progress = 0;
            }

            if (progress == 0) {
                $(document).attr("title", "Upload Files - File Upload Script");
            }
            else {
                $(document).attr("title", progress + "% Uploaded - Upload Files - File Upload Script");
            }
        }

        function updateProgessText(el, progress, uploadedBytes, totalBytes) {
            // calculate speed & time left
            nowTime = ( new Date() ).getTime();
            loadTime = ( nowTime - startTime );
            if (loadTime == 0) {
                loadTime = 1;
            }
            loadTimeInSec = loadTime / 1000;
            bytesPerSec = uploadedBytes / loadTimeInSec;

            textContent = '';
            textContent += 'Progress: ' + progress + '%';
            textContent += ' ';
            textContent += '(' + bytesToSize(uploadedBytes, 2) + ' / ' + bytesToSize(totalBytes, 2) + ')';

            // $( "#fileupload-progresstextLeft" ).html(textContent);

            rightTextContent = '';
            rightTextContent += 'Speed: ' + bytesToSize(bytesPerSec, 2) + '/s. ';
            rightTextContent += 'Remaining: ' + humanReadableTime(( totalBytes / bytesPerSec ) - ( uploadedBytes / bytesPerSec ));

            $(el).css('display', 'inline-block').html(rightTextContent);
        }
        var rstartTime = null;

        window.addEventListener("message",
            function (e) {
                if (e.origin !== '{{ $randServer }}') {
                    return;
                }

            }, false);

        function remoteProgress(value) {
            var percentageDone = parseInt(value.loaded / value.total * 100, 10);
            nowTime = ( new Date() ).getTime();
            loadTime = ( nowTime - rstartTime );

            if (loadTime == 0) {
                loadTime = 1;
            }

            loadTimeInSec = loadTime / 1000
            bytesPerSec = value.loaded / loadTimeInSec;

            var textContent = '';
            textContent += 'Progress: ' + percentageDone + '%';
            textContent += ' ';
            textContent += '(' + bytesToSize(value.loaded, 2) + ' / ' + bytesToSize(value.total, 2) + ')';
            textContent += '<br />Speed: ' + bytesToSize(bytesPerSec, 2) + '/s. ';

            progressText = textContent;
            $('#remote-progress-bar').css('display', 'inline-block');
            $('#remote-progress-bar .bar').css(
                'width',
                percentageDone + '%'
            );

            $('#remote-progress-text').html(progressText);
        }
        function remoteDisplayResult(data) {
            if (data.success) {
                var html = '', file_ids = [];
                for (var i in data.files) {
                    var file = data.files[i];

                    html +=
                        '<tr>' +
                        '<td>' + file.name + '</td>' +
                        '<td>' +
                        '</td>' +
                        ( file.success ? '' : '<td><span class="label label-important">FAILED</span></td>' ) +
                        '</tr>';

                    file_ids.push(file);
                }

                html +=
                    '<tr>' +
                    '<td colspan="3">' +
                    'File transfers completed. <a href="{{ url( '/' ) }}?active=remote">Click here</a> to upload more files.' +
                    '</td>' +
                    '</tr>';

                $('#remote-upload-result').html(html);
            }

            $('#remote_url_files').val('');
            $('#remote_upload_form').hide();

            top.location.href = '{{ url( 'upload/upload-success' ) }}?raw=' + encodeURIComponent(JSON.stringify(file_ids));
        }

        function isValidURL(value) {
            return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
        }

        $(function () {

            $('#upload_all').on('click', function (evt) {
                if (!$('#tos_cb_form').prop('checked')) {
                    alert('You need to agree to the Terms and Service of our website.');
                }
            });
            $('#tos_cb_form').on('change', function () {
                var self = $(this);

                if ($("#tos_cb_form").prop('checked') == true && $('.upload-progress-box').length > 0 @if( Auth::check() ) && parseInt($('#disksize').val()) > parseInt($('#s').val()) @endif )
                {
                    // self.attr( 'disabled', 'disabled' );
                    //$( '#tos_text' ).html( '<span class="text-success"><strong>You have agreed to the Terms and Service of our website.</strong></span>' );
                    $('#upload_all').removeClass('disabled');
                } else {

                    @if( Auth::check() )
                    if (parseInt($('#disksize').val()) < parseInt($('#s').val())) {
                        alert('File is greater than the available disk storage');
                    }
                    @endif

$('#upload_all').addClass('disabled');
                }
            });

            $('#remote_url_files').keyup(function (e) {
                if (e.keyCode == 13) {
                    var remote_url_files = $('#remote_url_files');
                    var raw_remote_files = ( remote_url_files.val() ).split("\n");

                    for (var i = 0, rrf_len = raw_remote_files.length; i < rrf_len; i++) {

                        if (raw_remote_files[i]) {
                            if (!isValidURL(raw_remote_files[i])) {
                                $('#btn_transfer_files').addClass('disabled');
                                return false;
                            }
                        } else {
                            if (rrf_len <= 1) {
                                $('#btn_transfer_files').addClass('disabled');
                                return false;
                            }
                        }
                    }

                    if (!$('#tos_cb_remote').prop('checked')) {
                        $('#btn_transfer_files').addClass('disabled');
                        /*$( '#remote-upload-progresser' ).removeAttr( 'src' );
                         $( '#remote-progress-text' ).html( '' );*/
                    } else {
                        $('#btn_transfer_files').removeClass('disabled');
                    }
                }
            });

            $('#tos_cb_remote').on('click', function () {
                var self = $(this);
                var remote_url_files = $('#remote_url_files');
                var raw_remote_files = ( remote_url_files.val() ).split("\n");

                for (var i = 0, rrf_len = raw_remote_files.length; i < rrf_len; i++) {
                    if (raw_remote_files[i]) {
                        if (!isValidURL(raw_remote_files[i])) {
                            $('#btn_transfer_files').addClass('disabled');
                            // return false;
                        }
                    } else {
                        if (rrf_len <= 1) {
                            $('#btn_transfer_files').addClass('disabled');
                            // return false;
                        }
                        else {
                            $('#btn_transfer_files').removeClass('disabled');
                        }
                    }
                }

                if (!self.prop('checked') || raw_remote_files.length < 1) {
                    $('#btn_transfer_files').addClass('disabled');
                    /*$( '#remote-upload-progresser' ).removeAttr( 'src' );
                     $( '#remote-progress-text' ).html( '' );*/
                } else {
                    $('#btn_transfer_files').removeClass('disabled');
                }
            });

            file_datum = [], file_ids = [], file_el_c = 0;
            $('#fileuploader').fileupload({
                formData: {
                    _token: '{!! csrf_token() !!}',
                    ip: '{!! Request::getClientIp() !!}',
                    data: $('#file_uploader_form').serialize()
                },
                sequentialUploads: true,
                maxChunkSize: 140000000,
                type: 'POST',
                url: '{{ $randServer }}',
                dropZone: $('#fileuploader')

            })
                .on('fileuploadadd', function (e, data) {
                    $('#nfs123').hide();
                    $('#upload_all_box').css('display', 'inline-block');
                    changeSize();
                    if ($("#tos_cb_form").prop('checked') == true && $('.upload-progress-box').length > 0 @if( Auth::check() ) && parseInt($('#disksize').val()) > parseInt($('#s').val()) @endif )
                    {
                        $('#upload_all').removeClass('disabled');

                    } else {
                        $('#upload_all').addClass('disabled');
                    }

                    file_datum.push(data);
                    $('#upload_all').bind('click.uploadsubmit', function (evt) {
                        if ($('#tos_cb_form').prop('checked')) {
                            if (data.context.is(':visible')) {
                                data.submit();
                            }
                        }

                    });
                })
                .on('fileuploadsend', function (e, data) {
                    @if( Auth::check() )
                    if (data.files.size > $('#disksize').val()) {
                        return false;
                    }
                    @endif
                })
                .on('fileuploadstop', function (e, data) {
                    updateTitleWithProgress(100);
                    updateProgessText(100, data.total, data.total);
                    $("#fileupload-progresstextRight").hide();

                    $('#upload_all').bind('click.uploadsubmit');
                    $('.speed').eq(file_el_c).html('');
                    file_el_c++;
                    if (file_ids.length > 0) {
                        if (file_ids == 'eg') {
                            alert('Your storage is full');
                        }
                        else {
                            top.location.href = '{!! url('upload/upload-success') !!}?raw=' + encodeURIComponent(JSON.stringify(file_ids));
                        }

                    }
                })
                .on('fileuploadstart', function () {
                    startTime = (new Date()).getTime();

                    $('#upload_all').unbind('click.uploadsubmit');

                })
                .on('fileuploadprogressall', function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    updateTitleWithProgress(progress);
                    updateProgessText($('.speed').eq(file_el_c), progress, data.loaded, data.total);
                })
                .on('fileuploaddone', function (e, data) {
                    file_ids.push(data.result.files[0]);
                    $('#progress').hide();

                });

            $('#fileuploader .files').on('click', 'a:not([target^=_blank])', function (e) {
                e.preventDefault();
                $('<iframe style="display:none;"></iframe>')
                    .prop('src', this.href)
                    .appendTo('body');
            });


            $('#show_remote_options').on('click', function (evt) {
                evt.preventDefault();

                $('#remote_options_box').slideToggle();
            });

            $('body').on('click', '[data-show-upload-detail]', function (e) {
                e.preventDefault();

                var $self = $(this), file_id = $self.data('show-upload-detail');

                $('#upload-' + file_id).slideToggle();

                return false;
            });

            var remote_url_files = $('#remote_url_files'), remote_upload_result = $('#remote-upload-result'),
                remote_upload_form = $('#remote_upload_form');
            $('#btn_transfer_files').on('click', function (evt) {
                evt.preventDefault();

                var raw_remote_files = ( remote_url_files.val() ).split("\n"), remote_files = [];

                for (var i = 0, rrf_len = raw_remote_files.length; i < rrf_len; i++) {
                    if (!isValidURL(raw_remote_files[i])) return false;

                    var file_uri = raw_remote_files[i];
                    if (file_uri.length > 0) {
                        remote_files.push(file_uri);
                    }
                }

                if (remote_files.length <= 0) {
                    return false;
                }

                if (remote_files.length > 10) {
                    alert('Can only input 10 URLs');
                    return false;
                }

                if (!$('#tos_cb_remote').prop('checked')) {
                    alert('You need to agree to the Terms and Service of our website.');
                    return false;
                }
                //$( '#remote-upload-progresser' ).attr( 'src', 'http://fs1.filespace.io/test/fileshare/file/do-remote-upload/?remote[url_files]='+ encodeURIComponent( remote_files.join( "@@BREAK@@@" ) )  );

                $('#remote-upload-progresser').attr('src', '{{ $randServer }}?remote[url_files]=' + encodeURIComponent(remote_files.join("{!! '@@@BREAK@@@' !!}")) + '&' + $('#remote_upload_form').serialize());
                return false;
            });

            $('#upload_all').click(function () {

                if ($("#tos_cb_form").prop('checked') != true) {
                    $('#myModal').modal({
                        keyboard: false
                    });
                }

            });

            // $( '#tos_cb_form' ).click( function() {

            // })
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#fileuploads').on('change', function () {
                changeSize();
                if ($("#tos_cb_form").prop('checked') == true && $('.upload-progress-box').length > 0 @if( Auth::check() ) && parseInt($('#disksize').val()) > parseInt($('#s').val()) @endif )
                {
                    $('#upload_all').removeClass('disabled');

                } else {
                    $('#upload_all').addClass('disabled');
                }
            });

        })

        function changeSize() {
            var total = 0;
            $('.filesize').each(function () {
                total += parseInt($(this).val());
            });
        }

        function cancelFile(size) {
            $('#s').val($('#s').val() - parseInt(size));
        }
    </script>
    <input type="hidden" id="disksize" value="{{ $disksize }}">
    <input type="hidden" id="s" value="">
@stop
