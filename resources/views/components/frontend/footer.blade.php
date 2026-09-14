{{-- resources/views/components/frontend/footer.blade.php --}}
<footer class="footer" id="contact">
    <div class="container">
        <div class="footer-grid">

            {{-- Brand --}}
            <div>
                <div class="footer-brand">
                    <div class="footer-brand-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <span>هامسان ساز بازار</span>
                </div>
                <p class="footer-description">
                    پلتفرم تخصصی تجارت B2B در حوزه ساز و آلات موسیقی. ما با تکیه بر فناوری‌های نوین،
                    تجربه‌ای امن، شفاف و کارآمد از تجارت را برای شما فراهم می‌کنیم.
                </p>
                <div class="footer-social">
                    <a href="#" title="اینستاگرام"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="تلگرام"><i class="fab fa-telegram"></i></a>
                    <a href="#" title="واتساپ"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" title="لینکدین"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="footer-title">دسترسی سریع</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">صفحه اصلی</a></li>
                    <li><a href="#services">خدمات</a></li>
                    <li><a href="#projects">پروژه‌ها</a></li>
                    <li><a href="#why-us">چرا ما</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="footer-title">خدمات</h4>
                <ul class="footer-links">
                    <li><a href="#">اتصال شرکت‌ها به فروشندگان</a></li>
                    <li><a href="#">پرداخت امن Escrow</a></li>
                    <li><a href="#">تحلیل و گزارش‌گیری</a></li>
                    <li><a href="#">مدیریت قراردادها</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="footer-title">تماس با ما</h4>
                <ul class="footer-links">
                    <li>
                        <i class="fas fa-envelope gold-text" style="color: var(--gold); margin-left: 5px;"></i>
                        info@hamsansaz.com
                    </li>
                    <li>
                        <i class="fas fa-phone" style="color: var(--gold); margin-left: 5px;"></i>
                        021-12345678
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt" style="color: var(--gold); margin-left: 5px;"></i>
                        تهران، ایران
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} هامسان ساز بازار — تمامی حقوق محفوظ است.</p>
        </div>
    </div>
</footer>
