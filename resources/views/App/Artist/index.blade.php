@extends('App.common')
@section('content')
    <template>
        <el-carousel  trigger="click"  :interval="8000" arrow="always">

            @foreach ($banner as $key=>$rs)
                <el-carousel-item>
                    <img src="{{asset('/')}}{{$rs->img}}"/>
                </el-carousel-item>
            @endforeach

        </el-carousel>
    </template>
    {!! $position !!}
        <ul>
    @foreach($data as $key=>$vo)
        <li>
            <a href="{{url('/')}}/Artist/{{$vo->id}}">
                <img src="{{asset('/')}}{{$vo->avatar_thumb}}"/>{{$vo->name}}
            </a>
        </li>
    @endforeach
        </ul>

@endsection
@section('footer')

    <script>

        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    activeIndex: '1',
                    login_name:'{{$user_name}}',
                    search:'',
                    select: '',
                }
            }
        })
    </script>
@endsection