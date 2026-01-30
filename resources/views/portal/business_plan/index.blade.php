@extends('layouts.portal')

@section('content')
    <!--begin::Stepper-->
    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
        id="kt_create_account_stepper">
        <!--begin::Aside-->
        <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-250px me-9">
            <!--begin::Wrapper-->
            <div class="card-body px-6 px-lg-10 py-10">
                <!--begin::Nav-->
                <div class="stepper-nav">
                    <!--begin::Step 1-->
                    <div class="stepper-item {{ $step == 1 ? 'current' : ($step > 1 ? 'completed' : '') }}"
                        data-kt-stepper-element="nav">
                        <a href="{{ route('portal.business-plan.step', 1) }}"
                            class="stepper-wrapper text-reset text-hover-primary cursor-pointer display-block">
                            <div class="stepper-icon w-40px h-40px">
                                <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                <span class="stepper-number">1</span>
                            </div>
                            <div class="stepper-label">
                                <h3 class="stepper-title">Ide Usaha</h3>
                                <div class="stepper-desc">Deskripsi Dasar Usaha</div>
                            </div>
                        </a>
                        <div class="stepper-line h-40px"></div>
                    </div>
                    <!--end::Step 1-->

                    <!--begin::Step 2-->
                    <div class="stepper-item {{ $step == 2 ? 'current' : ($step > 2 ? 'completed' : '') }}"
                        data-kt-stepper-element="nav">
                        <a href="{{ route('portal.business-plan.step', 2) }}"
                            class="stepper-wrapper text-reset text-hover-primary cursor-pointer display-block">
                            <div class="stepper-icon w-40px h-40px">
                                <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                <span class="stepper-number">2</span>
                            </div>
                            <div class="stepper-label">
                                <h3 class="stepper-title">Riset Pasar</h3>
                                <div class="stepper-desc">Analisis Pasar & Pesaing</div>
                            </div>
                        </a>
                        <div class="stepper-line h-40px"></div>
                    </div>
                    <!--end::Step 2-->

                    <!--begin::Step 3-->
                    <div class="stepper-item {{ $step == 3 ? 'current' : ($step > 3 ? 'completed' : '') }}"
                        data-kt-stepper-element="nav">
                        <a href="{{ route('portal.business-plan.step', 3) }}"
                            class="stepper-wrapper text-reset text-hover-primary cursor-pointer display-block">
                            <div class="stepper-icon w-40px h-40px">
                                <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                <span class="stepper-number">3</span>
                            </div>
                            <div class="stepper-label">
                                <h3 class="stepper-title">Pemasaran (7P)</h3>
                                <div class="stepper-desc">Strategi Marketing Mix</div>
                            </div>
                        </a>
                        <div class="stepper-line h-40px"></div>
                    </div>
                    <!--end::Step 3-->

                    <!-- Placeholder for Steps 4-10 (Simplified for UI Demo) -->
                    @for ($i = 4; $i <= 10; $i++)
                        <div class="stepper-item {{ $step == $i ? 'current' : ($step > $i ? 'completed' : '') }}"
                            data-kt-stepper-element="nav">
                            <a href="{{ route('portal.business-plan.step', $i) }}"
                                class="stepper-wrapper text-reset text-hover-primary cursor-pointer display-block">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                    <span class="stepper-number">{{ $i }}</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Tahap {{ $i }}</h3>
                                    <div class="stepper-desc">Deskripsi Tahap {{ $i }}</div>
                                </div>
                            </a>
                            @if($i < 10)
                            <div class="stepper-line h-40px"></div> @endif
                        </div>
                    @endfor

                </div>
                <!--end::Nav-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Aside-->

        <!--begin::Content-->
        <div class="card flex-row-fluid">
            <!--begin::Form-->
            <form class="card-body py-20 w-100 px-9" action="{{ route('portal.business-plan.store', $step) }}"
                method="POST">
                @csrf
                <!--begin::Step Content-->
                <div class="current" data-kt-stepper-element="content">
                    @if(view()->exists('portal.business_plan.partials.step_' . $step))
                        @include('portal.business_plan.partials.step_' . $step)
                    @else
                        <div class="alert alert-warning">Form untuk Tahap {{ $step }} belum tersedia.</div>
                    @endif
                </div>
                <!--end::Step Content-->

                <!--begin::Actions-->
                <div class="d-flex flex-stack pt-10">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        @if($step > 1)
                            <a href="{{ route('portal.business-plan.step', $step - 1) }}"
                                class="btn btn-lg btn-light-primary me-3">
                                <i class="ki-duotone ki-arrow-left fs-3 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Kembali
                            </a>
                        @endif
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div>
                        <button type="submit" class="btn btn-lg btn-primary">
                            <span class="indicator-label">
                                {{ $step < 10 ? 'Simpan & Lanjut' : 'Simpan & Selesai' }}
                                <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </button>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Stepper-->
    <!--end::Stepper-->
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/portal/business_plan.js') }}"></script>
@endsection