@extends('layouts.app')

@section('title', 'About - Portfolio')

@section('content')
<!-- About Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">About Me</h1>
                <p class="lead">Get to know more about my journey and passion in web development</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://via.placeholder.com/400x400/667eea/ffffff?text=About+Me" alt="About" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">My Story</h2>
                        <p class="lead mb-4">
                            Hello! I'm a passionate web developer with a love for creating digital experiences that make a difference.
                        </p>
                        <p class="mb-4">
                            Saya memulai perjalanan programming sejak [tahun], dan sejak itu saya telah mengembangkan berbagai aplikasi web 
                            menggunakan teknologi modern seperti Laravel, React, dan Vue.js. Saya percaya bahwa teknologi dapat membantu 
                            memecahkan masalah sehari-hari dan membuat hidup lebih mudah.
                        </p>
                        <p class="mb-4">
                            Ketika tidak sedang coding, saya suka [hobi/aktivitas], membaca tentang teknologi terbaru, dan berkontribusi 
                            pada proyek open source. Saya juga aktif dalam komunitas developer lokal dan senang berbagi pengetahuan 
                            dengan sesama developer.
                        </p>
                        <p class="mb-0">
                            Saya selalu terbuka untuk peluang baru dan kolaborasi menarik. Jika Anda memiliki proyek yang ingin didiskusikan, 
                            jangan ragu untuk menghubungi saya!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Education & Experience -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <h3 class="fw-bold mb-4">Education</h3>
                <div class="timeline">
                    <div class="card mb-3 border-start border-primary border-4">
                        <div class="card-body">
                            <h5 class="card-title">Sarjana Teknik Informatika</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Universitas [Nama] • 2020-2024</h6>
                            <p class="card-text">
                                Fokus pada pengembangan web dan mobile application. 
                                IPK: 3.8/4.0
                            </p>
                        </div>
                    </div>
                    <div class="card mb-3 border-start border-success border-4">
                        <div class="card-body">
                            <h5 class="card-title">SMA Negeri [Nomor]</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Jurusan IPA • 2017-2020</h6>
                            <p class="card-text">
                                Fokus pada matematika dan sains, mulai belajar programming dasar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <h3 class="fw-bold mb-4">Experience</h3>
                <div class="timeline">
                    <div class="card mb-3 border-start border-warning border-4">
                        <div class="card-body">
                            <h5 class="card-title">Freelance Web Developer</h5>
                            <h6 class="card-subtitle mb-2 text-muted">2023 - Present</h6>
                            <p class="card-text">
                                Mengembangkan berbagai website untuk klien menggunakan Laravel, 
                                WordPress, dan teknologi web modern lainnya.
                            </p>
                        </div>
                    </div>
                    <div class="card mb-3 border-start border-info border-4">
                        <div class="card-body">
                            <h5 class="card-title">Intern Backend Developer</h5>
                            <h6 class="card-subtitle mb-2 text-muted">PT. [Nama Perusahaan] • 2023</h6>
                            <p class="card-text">
                                Membantu pengembangan API menggunakan Laravel dan optimasi database MySQL.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Skills Progress -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold">Technical Skills</h3>
                <p class="text-muted">My proficiency in various technologies</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Laravel/PHP</span>
                        <span>90%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 90%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">JavaScript</span>
                        <span>85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 85%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">HTML/CSS</span>
                        <span>95%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 95%"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">MySQL</span>
                        <span>80%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 80%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">React</span>
                        <span>75%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Git</span>
                        <span>85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Download CV Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h3 class="fw-bold mb-4">Interested in my work?</h3>
                <p class="lead mb-4">Download my CV or get in touch to discuss opportunities</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" class="btn btn-light btn-lg">
                        <i class="fas fa-download"></i> Download CV
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-envelope"></i> Contact Me
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection