@extends('layout.mainlayout',['active_page' => 'pharmacy'])

@section('title',__('Pharmacy'))

@section('content')

<style type="text/css">
  body{margin-top:20px;}

.section {
    padding: 100px 0;
    position: relative;
}
.gray-bg {
    background-color: #ebf4fa;
}
/* Blog 
---------------------*/
.blog-grid {
  margin-top: 15px;
  margin-bottom: 15px;
}
.blog-grid .blog-img {
  position: relative;
  border-radius: 5px;
  overflow: hidden;
}
.blog-grid .blog-img .date {
  position: absolute;
  background: #3a3973;
  color: #ffffff;
  padding: 8px 15px;
  left: 0;
  top: 10px;
  font-size: 14px;
}
.blog-grid .blog-info {
  box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
  border-radius: 5px;
  background: #ffffff;
  padding: 20px;
  margin: -30px 20px 0;
  position: relative;
  min-height: 140px;
}
.blog-grid .blog-info h5 {
  font-size: 22px;
  font-weight: 500;
  margin: 0 0 10px;
}
.blog-grid .blog-info h5 a {
  color: #3a3973;
}
.blog-grid .blog-info p {
  margin: 0;
}
.blog-grid .blog-info .btn-bar {
  margin-top: 20px;
}

.px-btn-arrow {
    padding: 0 50px 0 0;
    line-height: 20px;
    position: relative;
    display: inline-block;
    color: #fe4f6c;
    -moz-transition: ease all 0.3s;
    -o-transition: ease all 0.3s;
    -webkit-transition: ease all 0.3s;
    transition: ease all 0.3s;
}


.px-btn-arrow .arrow {
    width: 13px;
    height: 2px;
    background: currentColor;
    display: inline-block;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    right: 25px;
    -moz-transition: ease right 0.3s;
    -o-transition: ease right 0.3s;
    -webkit-transition: ease right 0.3s;
    transition: ease right 0.3s;
}

.px-btn-arrow .arrow:after {
    width: 8px;
    height: 8px;
    border-right: 2px solid currentColor;
    border-top: 2px solid currentColor;
    content: "";
    position: absolute;
    top: -3px;
    right: 0;
    display: inline-block;
    -moz-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>

<!-- filter Over -->
<div class="full-content" style="background: #fbfbfbcc;">
    <div class="content px-lg-0 px-2 py-3 mx-auto">
       <div class="section-title" style="padding-top: 40px;">
                <h2>Free Mental Health Assessments</h2>
                 <p> Take a Free test and get Your Report.</p>
    </div>


        <div class="row row-cols-1  row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-0 display_medicine">
           


@forelse ($pharmacy as $list)   


<div class="col-lg-4">
                        <div class="blog-grid">
                            <div class="blog-img">
                                <div class="date">Free Report</div>
                                <a href="#">
                                    <img src="{{ $list->fullImage }}" title="" alt="" style="max-height: 340px;min-width: 300px;min-height: 340px;">
                                </a>
                            </div>
                            <div class="blog-info">
                                <h5 style="min-height: 55px;"><a href="#">{{ $list->name }}</a></h5>
                               <!--  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p> -->
                                <div class="btn-bar">
                                    <a href="{{ url('assesment/'.$list->id.'/'.Str::slug($list->name)) }}" class="default-btn">
                                        <span>Take Assessment</span>
                                       <!--  <i class="arrow"></i> -->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



    


    
    
@empty
    <div class="w-100 text-center">
        <i class='bx bxs-user-plus noData'></i>
        <br>
        <h6 class="mt-3">{{__(' Not Available.')}}</h6>
    </div>
@endforelse

        </div>
    </div>

</div>
@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places"></script>
    <script src="{{ url('assets/js/medicine_list.js') }}"></script>
@endsection