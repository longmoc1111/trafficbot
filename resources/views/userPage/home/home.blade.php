@extends("userPage.layout.layout")
@section("title", "Trang chủ")
@section("main")


    <!-- Carousel Start -->
    <div class="container-fluid px-0 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100"
                        src="https://www.europeanbusinessreview.com/wp-content/uploads/2024/06/iStock-1458928151-1.jpg"
                        alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7 text-start">
                                    <p class="fs-4 text-white animated slideInRight">Chào mừng bạn đến với
                                        <strong>Trafficbot</strong>
                                    </p>
                                    <h1 class="display-1 text-white mb-4 animated slideInRight">Trải nghiệm ngay với
                                        trafficbot</h1>
                                    <a href="" class="btn btn-primary rounded-pill py-3 px-5 animated slideInRight">bắt
                                        đầu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100"
                        src="https://www.europeanbusinessreview.com/wp-content/uploads/2024/06/iStock-1458928151-1.jpg"
                        alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-lg-7 text-end">
                                    <p class="fs-4 text-white animated slideInLeft">Chào mừng bạn đến với
                                        <strong>Trafficbot</strong>
                                    </p>
                                    <h1 class="display-1 text-white mb-5 animated slideInLeft">Học tập cùng
                                        trafficbot</h1>
                                    <a href="" class="btn btn-primary rounded-pill py-3 px-5 animated slideInLeft">Bắt
                                        đầu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
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
                <h5 class="display-5 mb-5 underline-heading">Ôn tập</h5>
                
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Ôn tập theo chương</h4>
                            </div>
                            <p class="mb-0 title-content">Phân chia hệ thống câu hỏi theo từng chương</p>
                            <hr>
                            <div class="btn-container">
                              <a href="{{ route("userpage.chapters", ["ID" => $chapter->CategoryID]) }}" class="btn-continue text-center">
                                    Tiếp tục <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Nhận biết biển báo</h4>
                            </div>
                            <p class="mb-0 title-content">Tìm hiểu và nhận biết nhanh các biển báo thông qua hình ảnh</p>
                            <hr>
                            <div class="btn-container">
                                <a href="{{ route("userpage.signages", $signage->SignageTypeID) }}" class="btn-continue text-center">
                                    Tiếp tục <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                    <div class="service-item-home position-relative h-100 ">
                        <div class="service-text-home rounded ">
                            <div>
                                <h5 class="title-text mb-3 text-center">Ôn tập nhanh</h4>
                            </div>
                            <p class="mb-0 title-content">Ôn tập nhanh với 600 câu hỏi trắc nghiệm</p>
                            <hr>
                            <div class="btn-container">
                                <a class="btn-continue  text-center">
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