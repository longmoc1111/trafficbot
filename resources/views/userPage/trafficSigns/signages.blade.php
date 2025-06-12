@extends("userPage.layout.layout")
@section("title", "học biển báo ")

@section("main")
    <!-- Service Start -->
    <div class="container-lg py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp mb-5" data-wow-delay="0.1s" style="max-width: 500px;">
                <h4 class="display-7 ">Tìm hiểu và nhận biết biển báo</h4>
                <p>{{ $signagesType->SignagesTypeName }}</p>
            </div>
            <div class="row g-4">
                @foreach ($signagesType->signageType_signage as $signages)
                    <div class="col-lg-6 col-md-12 col-sm-12  wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item-signs position-relative">
                            <div class="service-text rounded p-2">
                                <div class="btn-square" style="width: 150px; height: 150px;">
                                    <img class="img-fluid" src="/assets/adminPage/SignagesImage/{{ $signages->SignageImage }}"
                                        alt="Icon">
                                </div>
                                <div>
                                    <p class="title-signages m-0 flex-grow-1  fw-semibold mb-2">{{ $signages->SignageName }}</p>
                                    <p>{{ $signages->SignagesExplanation }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Service End -->


@endsection