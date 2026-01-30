@extends('layouts.portal')

@section('content')
    <div class="card">
        <div class="card-body p-lg-17">
            <!--begin::About-->
            <div class="mb-18">
                <!--begin::Wrapper-->
                <div class="mb-10">
                    <!--begin::Top-->
                    <div class="text-center mb-15">
                        <!--begin::Title-->
                        <h3 class="fs-2hx text-dark mb-5">Tentang Program SIYB</h3>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fs-5 text-muted fw-semibold">
                            Program Memulai dan Meningkatkan Usaha Anda (SIYB) adalah program pelatihan manajemen yang
                            dikembangkan oleh ILO.
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Top-->

                    <!--begin::Overlay-->
                    <div class="overlay text-center ">
                        <!-- Placeholder for an image if needed, or just text content -->
                    </div>
                    <!--end::Overlay-->

                </div>
                <!--end::Wrapper-->

                <!--begin::Description-->
                <div class="fs-5 fw-semibold text-gray-600">
                    <!--begin::Section-->
                    <div class="mb-10">
                        <h4 class="text-dark mb-3">Tentang Program Memulai dan Memperbaiki Usaha Anda (SIYB)</h4>
                        <p class="mb-5">
                            Program Memulai dan Meningkatkan Usaha Anda (SIYB) adalah program pelatihan manajemen yang
                            dikembangkan oleh Organisasi Perburuhan Internasional (International Labour Organization)
                            disingkat ILO, dengan fokus pada memulai dan memperbaiki usaha kecil sebagai strategi untuk
                            menciptakan lapangan kerja yang lebih baik bagi perempuan dan laki-laki, terutama di negara
                            berkembang. Dengan perkiraan telah menjangkau lebih dari 100 negara, ini adalah salah satu
                            program terbesar di dunia dalam pengembangan usaha.
                        </p>
                        <p class="mb-5">
                            Program ini memiliki empat paket yang saling terkait - Generate Your Business Idea (GYB), Start
                            Your Business (SYB), Improve Your Business (IYB) dan Expand Your Business (EYB).
                        </p>
                        <p class="mb-5">
                            ILO menerapkan program ini menggunakan struktur tiga tingkat yang terdiri dari Master Trainer,
                            Trainer/Pelatih dan penerima manfaat akhir - calon pengusaha dan pengusaha yang sudah ada.
                            Master Trainer yang mendapatkan lisensi dari ILO bertanggung jawab untuk mengembangkan kapasitas
                            pelatih untuk melakukan pelatihan SIYB secara efektif. Setelah itu, pelatih melatih pengusaha
                            dalam paket SIYB. ILO memainkan peran penting dalam mengidentifikasi dan menyebarkan praktik
                            terbaik, melaksanakan pelatihan, memantau kegiatan, melakukan kontrol kualitas dan memberikan
                            saran teknis mengenai pelaksanaan program SIYB.
                        </p>
                    </div>
                    <!--end::Section-->

                    <!--begin::Section-->
                    <div class="mb-10">
                        <h4 class="text-dark mb-3">Start Your Business (SYB)</h4>
                        <p class="mb-5">
                            Tentang Start Your Business (SYB) adalah program pelatihan bagi calon pengusaha yang memiliki
                            ide usaha yang layak untuk usaha kecil. Pelatihan ini membantu dalam mengembangkan rencana usaha
                            yang rinci dan diarahkan untuk segera benar memulai usaha. Pelatihan ini juga memberi kesempatan
                            untuk menguji keterampilan kewirausahaan yang dibutuhkan dan rencana usaha di lingkungan yang
                            disimulasikan dan aman.
                        </p>
                        <p class="mb-5">
                            Kursus pelatihan SYB biasanya disampaikan dalam lima hari dengan menggunakan buku panduan dan
                            buklet rencana SYB. Pelatihan ini menggunakan pendekatan pembelajaran aktif dan problem-centered
                            yang didasarkan pada apa yang calon pengusaha sudah tahu. Ini menantang pengusaha dengan
                            mengenalkan dinamika pasar baru. Misalnya, belajar dari studi kasus atau ilustrasi berdasarkan
                            grafis.
                        </p>
                    </div>
                    <!--end::Section-->

                    <!--begin::Section-->
                    <div class="mb-10">
                        <h4 class="text-dark mb-3">Penulis dan ucapan terima kasih</h4>
                        <p class="mb-5">
                            Manual SYB adalah hasil dari upaya kolektif dan memahami pengalaman dan pengetahuan yang
                            dikumpulkan dengan menerapkan program ini selama hampir tiga dasawara. Secara khusus, kontribusi
                            dari SIYB Master Trainer dan Trainer yang telah menguji, merancang dan menerapkan program di
                            negara-negara yang berbeda selama bertahun-tahun telah sangat berharga. Ada banyak rekan kerja
                            dari jaringan praktisi SIYB, perusahaan konsultan dan di ILO, yang pengalaman, dukungan dan
                            saran konstruktifnya membuat publikasi panduan pelatihan ini mungkin dilakukan.
                        </p>
                        <p class="mb-5">
                            Manual ini didasarkan pada materi yang awalnya dikembangkan pada tahun 1996 oleh Kantor Proyek
                            Regional ILO SIYB di Harare, Zimbabwe. Penulis dari versi aslinya adalah Geoffrey Meredith,
                            Douglas Stevenson, Hakan Jarskog, Barbara Murray dan Ulf Kallstig. Manual asli kemudian direvisi
                            oleh ILO Youth Entrepreneurship Facility (YEF), dimana ini kemudian ditulis dan ditinjau oleh
                            Milena Mileman dan Sibongile Sibanda.
                        </p>
                        <p class="mb-5">
                            Adaptasi untuk Indonesia: Edisi ini lebih lanjut diadaptasi di Indonesia pada tahun 2022 oleh
                            Tendy Gunawan (Kantor ILO Jakarta), Rini Wahyu Hariyani (Master Trainer SIYB) dan team dari
                            RIWANI Globe.
                        </p>
                    </div>
                    <!--end::Section-->

                </div>
                <!--end::Description-->
            </div>
            <!--end::About-->

            <!--begin::Action-->
            <div class="card-footer d-flex justify-content-center pt-10">
                <a href="{{ route('portal.business-plan.step', 1) }}" class="btn btn-lg btn-primary me-3">
                    Mulai Mengisi Business Plan
                    <i class="ki-duotone ki-arrow-right fs-3 ms-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
            <!--end::Action-->
        </div>
    </div>
@endsection