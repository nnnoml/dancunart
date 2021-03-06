@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>

                <input type="text" name="keywords" class="textbox" placeholder="关键词..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/artist')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/artist/create')}}'">新增艺术家</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>艺术家名称</th>
                        <th>艺术家昵称</th>
                        <th>艺术家头像</th>
                        <th>艺术品数量</th>
                        <th>是否上架展示</th>
                        <th>艺术分类</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->name }}</td>
                            <td>{{ $rs->nick }}</td>
                            <td><img src="{{asset($rs->avatar_thumb)}}" /></td>
                            <td>{{ $rs->artwork_count }}</td>
                            <td>@if($rs->status)上架展示@else 不展示 @endif</td>
                            <td>{{ $rs->art_class_name }}</td>
                            <td>
                                <a href="{{URL::to('admin/artist')}}/{{ $rs->id }}/edit">修改</a>
                                <a href="javascript:;" onClick='isdelete({{ $rs->id }})'>删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                <aside class="paging">
                    {!! $data->appends($searchitem)->render() !!}
                </aside>
            </section>


        </div>
    </section>

@endsection
@section('footer')
    <script>
        $("#search").click(function(){
            var key = $("input[name = 'keywords']").val();
            window.location.href="{{URL::to('admin/artist')}}?key="+key;
        })
        function isdelete(id){
            var res=confirm("确定删除该艺术家？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/artist')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/artist')}}','{{URL::to('admin/artist')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'','');
                        }
                    }

                })

            }
        }
    </script>

    </body>
    </html>
@endsection