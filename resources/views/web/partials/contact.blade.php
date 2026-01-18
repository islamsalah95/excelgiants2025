    <section id="contact" style="background-color: var(--section-alt-bg)">
        <div class="container">
            <div class="section-title">
                <h2>اتصل بنا</h2>
                <p>نسعد بتواصلكم معنا في أي وقت</p>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    @foreach ($contactInfos as $info)
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="{{ $info->icon ?? 'fa-solid fa-info' }}"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">{{ $info->title }}</h5>
                                <p class="mb-0">
                                    {{ $info->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-7">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="الاسم الكامل"
                                    required />
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control"
                                    placeholder="البريد الالكتروني" required />
                            </div>
                        </div>
                        <input type="text" name="subject" class="form-control" placeholder="الموضوع" required />
                        <textarea name="message" class="form-control" rows="5" placeholder="رسالتك" required></textarea>
                        <button type="submit" class="btn w-100"
                            style="background-color: var(--accent-color); color: white">
                            ارسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
