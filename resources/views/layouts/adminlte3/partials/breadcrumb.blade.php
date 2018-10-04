<!-- <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol> -->

<ol class="breadcrumb float-sm-right">
    <li><a href="{{route('home')}}">Home</a></li>
    @for($i = 0; $i <= count(Request::segments()); $i++)
    <li class="breadcrumb-item">
        <a href="">{{Request::segment($i)}}</a>
    </li>
    @endfor
</ol>