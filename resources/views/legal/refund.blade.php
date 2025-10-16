<x-layouts.stellar>
    <x-slot name="title">{{ __('سياسة الاسترداد') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-16 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('سياسة الاسترداد') }}
                </h1>
                <p class="text-slate-400" data-aos="fade-down" data-aos-delay="200">
                    {{ __('آخر تحديث: :date', ['date' => now()->locale('ar')->translatedFormat('d F Y')]) }}
                </p>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-8 lg:p-12 border border-slate-700/50 space-y-8" data-aos="fade-up">
                
                <!-- 1: السياسة العامة -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        السياسة العامة
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>نحن نسعى لضمان رضا العملاء. تم تصميم سياسة الاسترداد الخاصة بنا لحماية كل من المشترين والبائعين.</p>
                    </div>
                </section>

                <!-- 2: أهلية الاسترداد -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        أهلية الاسترداد
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>يمكن طلب الاسترداد خلال 7 أيام من تاريخ الشراء في الحالات التالية:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>المنتج لا يتطابق مع الوصف</li>
                            <li>لم تستلم المنتج</li>
                            <li>المنتج معطل أو غير وظيفي</li>
                        </ul>
                    </div>
                </section>

                <!-- 3: العناصر غير القابلة للاسترداد -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        العناصر غير القابلة للاسترداد
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>لا يمكن استرداد ما يلي:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>المنتجات التي تم الوصول إليها أو تحميلها</li>
                            <li>الحسابات التي تم تسجيل الدخول إليها</li>
                            <li>الخدمات التي تم تقديمها</li>
                        </ul>
                    </div>
                </section>

                <!-- 4: عملية الاسترداد -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                        عملية الاسترداد
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>لطلب الاسترداد:</p>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>تواصل مع البائع من خلال منصتنا</li>
                            <li>إذا لم يتم التوصل لحل، افتح نزاعاً في حسابك</li>
                            <li>سيراجع فريقنا الوساطة</li>
                            <li>يتم معالجة الاستردادات خلال 5-7 أيام عمل</li>
                        </ol>
                    </div>
                </section>

                <!-- 5: التزامات البائع -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                        التزامات البائع
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>يجب على البائعين وصف المنتجات بدقة والتسليم كما وعدوا. قد يؤدي عدم القيام بذلك إلى تعليق الحساب.</p>
                    </div>
                </section>

                <!-- 6: التواصل -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">6</span>
                        التواصل
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>للاستفسارات حول الاسترداد، تواصل معنا عبر قسم "المساعدة" في المنصة أو عبر البريد الإلكتروني: support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}</p>
                    </div>
                </section>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('home') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                    {{ __('الرجوع للرئيسية') }}
                </a>
            </div>
        </div>
    </section>
</x-layouts.stellar>
