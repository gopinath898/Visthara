@extends('layout.mainlayout',['active_page' => 'blog'])

@section('title',__('Blog'))

@section('css')
<style>
 img {
	 width: 100%;
	 vertical-align: top;
}
 .card {
	 text-align: center;
}
 .card__img {
	 margin-bottom: 5px;
}
 .card__title {
	 text-transform: capitalize;
	 color: var(--site_color);
	 line-height: 20px;
	 font-size: 13px;
	 margin-top: 10px;
}
 .card__text {
	 color: var(--grey);
	 font-size: 16px;
	 line-height: 26px;
	 margin-bottom: 20px;
}
 .card__readbtn {
	 font-size: 14px;
	 text-transform: uppercase;
	 color: var(--site_color_hover);
	 text-decoration: none;
	 line-height: 26px;
	 transition: all ease 0.3s;
	 position: relative;
}
 .card__readbtn::after {
	 content: "";
	 position: absolute;
	 left: 0;
	 bottom: 0;
	 width: 0;
	 height: 2px;
	 background-color: var(--site_color);
	 transition: all ease 0.3s;
}
 .card__readbtn:hover {
	 color: var(--site_color);
}
 .card__readbtn:hover::after {
	 width: 100%;
}
 .divider {
	 background-color: var(--site_color_hover);
	 height: 2px;
	 max-width: 30px;
	 margin: 15px auto 20px;
}
 .grid {
	 /* display: grid;
	 grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
	 gap: 35px;
	 max-width: 1300px;
	 margin: 50px auto;
	 padding: 0 10px; */
}

.card__contenido .content_div
{
    margin-left: 5px;
    margin-right: 5px;
}

.pagination{
    justify-content: center;
}
</style>
 
@endsection

@section('content')
<div class="grid">
	<div class="item-bg3 pt-50">
        <div class="container">
            <div class="page-banner-content-two">
                <h2 style="color: black">Resource - Blog</h2>
                <!-- <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>Blog</li>
                </ul> -->
            </div>
        </div>
    </div>
</div>
    <!-- End Page Banner Area -->

    <!-- Start Blog Area -->
    <section class="blog-area pt-100 pb-100">
        <div class="container">
            <div class="d-flex align-content-center mb-3">
                <h6 class="p-2" style="white-space:nowrap;"><b>{{ __('Filter By') }}</b></h6>        
                <div class="filter-options">
                    <form action="{{url('/resources')}}" method="GET" class="row">
                        <div class="col-6" id="specialization">
                            <select name="category_id" class="form-control" style="width:100%" required>
                                <option value="">Select specialisation</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>  
                        <button class="col-1 btn btn-outline-primary filter-search-button" type="submit">Filter</button>
                    </form>
                </div>
            </div> 
        </div>
        <div class="container">
            <div class="row align-items-center">
                @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 px-3">
                    <div class="single-coaches">
                        <div class="blog-image">
                            <a href="{{ url('blogs/'.$blog->id.'/'.Str::slug($blog->title)) }}"><img src="{{ url($blog->full_image) }}" alt="image"></a>
                            <div class="tag">{{Carbon\Carbon::parse($blog['created_at'])->format('M d')}}</div>   
                        </div>
                        <div class="blog-content">
                            <div class="meta">
                                {{ $blog->blog_ref }}
                            </div>
                            <div class="row">
                                <b>
                                @if (strlen($blog->title) > 50)
                                {!! substr(clean($blog->title),0,50) !!}....
                                @else
                                {!! clean($blog->title) !!}
                                @endif
                                </b>
                            </div>
                            <h3>
                                <a href="blog-details.html">{!! substr(clean($blog->desc),0,50) !!}....</a>
                            </h3>
                            <div class="blog-btn">
                                <a href="{{ url('blogs/'.$blog->id.'/'.Str::slug($blog->title)) }}" class="default-btn">Read More <i class="flaticon-plus"></i></a>
                            </div>
                        </div>
                    </div>

                @if(isset($request->page) && $request->page==2)
                </div>

                @endif 
                @endforeach
                
            </div>
        </div>
    </section>
 <div class="row"> 
    {{ $blogs->links() }}
 </div>
@endsection