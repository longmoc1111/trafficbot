@extends("userPage.layout.layout")
@section("title", "Trang chủ")
@section("main")


    <!-- Carousel Start -->

    <!-- Carousel End -->


    <!-- Features Start -->
    <!-- <div class="container-xxl py-5">
                            <div class="container">
                                <div class="row g-0 feature-row">
                                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                                        <div class="feature-item border h-100 p-5">
                                            <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                                                <img class="img-fluid" src="img/icon/icon-1.png" alt="Icon">
                                            </div>
                                            <h5 class="mb-3">Thi thử sát hạch xe máy</h5>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                                        <div class="feature-item border h-100 p-5">
                                            <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                                                <img class="img-fluid" src="img/icon/icon-2.png" alt="Icon">
                                            </div>
                                            <h5 class="mb-3">Kho Đề Thi chuẩn</h5>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                                        <div class="feature-item border h-100 p-5">
                                            <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                                                <img class="img-fluid" src="img/icon/icon-3.png" alt="Icon">
                                            </div>
                                            <h5 class="mb-3">Miễn Phí & Tiết Kiệm Thời Gian</h5>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                                        <div class="feature-item border h-100 p-5">
                                            <div class="btn-square bg-light rounded-circle mb-4" style="width: 64px; height: 64px;">
                                                <img class="img-fluid" src="img/icon/icon-4.png" alt="Icon">
                                            </div>
                                            <h5 class="mb-3">Chatbot Hỗ Trợ 24/7</h5>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
    <!-- Features End -->






    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h2 class=" mb-5 underline-heading">Ôn tập</h2>

            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Thi thử lý thuyết</h4>
                            </div>
                            <p class="mb-0 title-content">Thi thử lý thuyết Hạng A1, A, B1, B, C1, C2, C, D1, D2, D.....</p>
                            <hr>
                            <div class="btn-container">
                                <a href="{{ route("userpage.practice.test") }}"
                                    class="btn-continue text-center">
                                    Tiếp tục <i class="fa fa-arrow-right"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Ôn tập theo chương</h4>
                            </div>
                            <p class="mb-0 title-content">Phân chia hệ thống câu hỏi theo từng chương</p>
                            <hr>
                            <div class="btn-container">
                                @if(!empty($chapter->CategoryID))
                                    <a href="{{ route("userpage.chapters", ["ID" => $chapter->CategoryID]) }}"
                                        class="btn-continue text-center">
                                        Tiếp tục <i class="fa fa-arrow-right"></i>
                                    </a>

                                @else
                                    <a href="" class="btn-continue text-center">
                                        Tiếp tục <i class="fa fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Nhận biết biển báo</h4>
                            </div>
                            <p class="mb-0 title-content">Tìm hiểu và nhận biết nhanh các biển báo thông qua hình ảnh</p>
                            <hr>
                            <div class="btn-container">
                                @if(!empty($signage->SignageTypeID))
                                    <a href="{{ route("userpage.signages", $signage->SignageTypeID) }}"
                                        class="btn-continue text-center">
                                        Tiếp tục <i class="fa fa-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="" class="btn-continue text-center">
                                        Tiếp tục <i class="fa fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Ôn tập nhanh</h4>
                            </div>
                            <p class="mb-0 title-content">Ôn tập nhanh với 600 câu hỏi trắc nghiệm</p>
                            <hr>
                            <div class="btn-container">
                                <a href="{{ route("userpage.collection") }}" class="btn-continue  text-center">
                                    Tiếp tục <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
    <!-- Service End -->

@endsection