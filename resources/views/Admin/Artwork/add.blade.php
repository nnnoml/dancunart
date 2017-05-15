@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">拍品名称：</span>
                            <input type="text" class="textbox textbox_295" name="name" />
                        </li>

                        <li id="upload_li">
                            <span class="item_name" style="width:120px;">拍品图片：</span>
                            <input type="button" class="link_btn" id="click_btn" value="选择图片"/>

                            <input id="avatar_url" name="img" type="hidden"  value="">
                            <input id="avatar_thumb_url" name="img_thumb" type="hidden"  value="">
                            <!--隐藏file按钮-->
                            <input id="upload_btn" type="file" name="file" >
                            <!--上传后显示的img-->
                            <img  id="img_url" name="id" src="" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">视频地址：</span>
                            <input type="text" class="textbox textbox_295" name="video" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">拍品描述：</span>
                            <textarea placeholder="拍品简略描述" class="textarea" style="width:400px;height:80px;" name="desc"></textarea>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">起拍价：</span>
                            <input type="number" class="textbox" name="start_price" /> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">加价幅度：</span>
                            <input type="number" class="textbox" name="each_increase" /> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">延迟周期：</span>
                            <input type="number" class="textbox" name="delay_seconds" /> 单位：分
                        </li><li>
                            <span class="item_name" style="width:120px;">保留价：</span>
                            <input type="number" class="textbox" name="reserve_price" /> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">保证金：</span>
                            <input type="number" class="textbox" name="margin" /> 单位：元
                        </li>

                        <li class="time_handle">
                            <span class="item_name">开始时间：</span>
                            <input type="text" class="textbox" id="start_time" name="start_time"  placeholder="请输入开始销售时间..." />
                        </li>

                        <li class="time_handle">
                            <span class="item_name">结束时间：</span>
                            <input type="text" class="textbox" id="end_time" name="end_time"  placeholder="请输入结束销售时间..." />
                        </li>

                        <li id="artwork_class_id">
                            <span class="item_name" style="width:120px;">拍品分类：</span>
                                {!!$artwork_class_list!!}
                        </li>

                        <li id="artist_list_id">
                            <span class="item_name" style="width:120px;">艺术家选择：</span>
                                {!!$artist_list!!}
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否上架展示：</span>
                            <label class="single_selection"><input type="radio" name="status"  checked='true' value='1'/>上架展示</label>
                            <label class="single_selection"><input type="radio" name="status" value='0'/>不上架</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">拍品详细信息：</span>
                        </li>

                        <div style="margin:0px 5%;">
                            <script id="container" name="content" type="text/plain" style="width:100%;height:500px;"></script>
                        </div>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="button" class="link_btn" id="link_btn" value="提交"/>
                        </li>
                    </ul>
                </form>
            </section>

        </div>
    </section>
@endsection
@section('footer')
    <link href="{{asset('umeditor/themes/default/_css/umeditor.css')}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('umeditor/third-party/template.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/editor_api.js')}}"></script>
    <script type="text/javascript" src="{{asset('umeditor/lang/zh-cn/zh-cn.js')}}"></script>

    <script src="{{asset('static/js/jquery.ajaxfileupload.js')}}"></script>

    <script>
        //上传图片相关
        function applyAjaxFileUpload(element) {
            $(element).AjaxFileUpload({
                action: "{{asset('/admin/upload')}}",
                onChange: function(filename) {
                    var $span = $("<span />").attr("class", $(this).attr("id")).text("Uploading").insertAfter($(this));
                    $(this).remove();
                    interval = window.setInterval(function() {
                        var text = $span.text();
                        if (text.length < 13) {
                            $span.text(text + ".");
                        } else {
                            $span.text("Uploading");
                        }
                    }, 200);
                },
                onComplete: function(filename,result) {
                    window.clearInterval(interval);

                    var $span = $("span." + $(this).attr("id")).text("");
                    $("#avatar_url").val(result.name);
                    $("#avatar_thumb_url").val(result.name_thumb);
                    $("#img_url").attr('src',"{{asset('/')}}"+result.name_thumb);
                    $("#img_url").show();
                    $("#upload_li").append("<input id='upload_btn' type='file' name='file' >");
                }
            });
        }
        //上传图片相关
        $('#click_btn').on('click',function(){
            $('#upload_btn').trigger('click');
            applyAjaxFileUpload("#upload_btn");
        })

        //编辑器相关
        var um = UM.getEditor('container');

        $(function(){
            $('#start_time ,#end_time').datetimepicker({
                changeYear: true,
                regional:"zh-CN",
                dateFormat:"yy-mm-dd",
                timeFormat: "hh:mm:ss"
            });
        });

        $("#link_btn").click(function() {
            var name = $("input[name = 'name']").val();
            var img = $("input[name = 'img']").val();
            var img_thumb = $("input[name = 'img_thumb']").val();
            var desc = $("textarea[name = 'desc']").val();
            var start_price = $("input[name = 'start_price']").val();
            var each_increase = $("input[name = 'each_increase']").val();
            var delay_seconds = $("input[name = 'delay_seconds']").val();
            var reserve_price = $("input[name = 'reserve_price']").val();
            var margin = $("input[name = 'margin']").val();
            var content = $("textarea[name = 'content']").val();

            var start_time = $("input[name = 'start_time']").val();
            var end_time = $("input[name = 'end_time']").val();

            var artwork_class_flag=true;
            $("#artwork_class_id > input").each(function() {
                if($(this).is(':checked')) artwork_class_flag=false;
            });

            var artist_list_flag=true;
            $("#artist_list_id > input").each(function() {
                if($(this).is(':checked')) artist_list_flag=false;
            });

            if (name == '' || img == '' || img_thumb == '' || desc == '' || typeof(content) == 'undefined') {
                showAlert('请填完全', '', '');
                return false;
            }
            if (isNaN(parseInt(start_price)) || isNaN(parseInt(each_increase)) ||
                    isNaN(parseInt(delay_seconds)) || isNaN(parseInt(reserve_price)) || isNaN(parseInt(margin))) {
                showAlert('部分字段需要填写数字', '', '');
                return false;
            }

            if(artwork_class_flag || artist_list_flag){
                showAlert('拍品分类和相关艺术家没有选择', '', '');
                return false;
            }

            if (start_time == '')  showAlert('开始时间不能为空', '', '');
            else if (end_time == '')  showAlert('结束时间不能为空', '', '');
            else if (end_time < start_time)  showAlert('开始时间大于结束时间', '', '');
            else{
                $.ajax({
                    url: "{{URL::to('admin/artwork')}}",
                    type: "post",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 20000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/artwork')}}', '{{URL::to('admin/artwork')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '', '');
                        }
                    }
                })
            }
        })
    </script>

    </body>
    </html>
@endsection