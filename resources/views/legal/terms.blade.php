<x-layouts.stellar>
    <x-slot name="title">{{ __('الشروط والأحكام') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-16 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('الشروط والأحكام') }}
                </h1>
                <p class="text-slate-400" data-aos="fade-down" data-aos-delay="200">
                    {{ __('آخر تحديث: :date', ['date' => now()->format('F d, Y')]) }}
                </p>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-8 lg:p-12 border border-slate-700/50 space-y-8" data-aos="fade-up">
                
                <!-- 1: حول NXO -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        حول NXO
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>NXO هو سوق رقمي يتيح للمستخدمين في دول الخليج بيع وشراء الحسابات المميزة للتواصل الاجتماعي وحسابات الألعاب بشكل آمن. نحن نعمل كوسيط موثوق بين البائعين والمشترين، ونوفر بيئة آمنة، ومعالجة دفع محمية، وآلية شفافة لإتمام المعاملات.</p>
                        <p class="mt-4">باستخدامك لمنصتنا، فإنك توافق على الالتزام بجميع الشروط والأحكام التالية.</p>
                    </div>
                </section>

                <!-- 2: عرض الحسابات -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        عرض الحسابات
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• يجب على البائعين عرض الحسابات التي يمتلكونها بشكل قانوني فقط. عرض حسابات تم الحصول عليها بطرق غير مشروعة ممنوع منعًا باتًا.</p>
                        <p>• لا يُسمح بعرض نفس الحساب أكثر من مرة، وسيتم حذف أي عرض مكرر.</p>
                        <p>• لا يُسمح بعرض الحسابات المحظورة أو المعطلة أو الموقوفة من قبل المنصة الأصلية.</p>
                    </div>
                </section>

                <!-- 3: الملكية والمسؤولية -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        الملكية والمسؤولية
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• البائع مسؤول بالكامل عن ملكية الحساب وصحته وقانونيته.</p>
                        <p>• محاولة استعادة الحساب بعد بيعه ممنوعة تمامًا وقد تؤدي إلى إيقاف الحساب بشكل دائم واتخاذ إجراءات قانونية ومطالبات مالية.</p>
                    </div>
                </section>

                <!-- 4: المعاملات والسحب -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                        المعاملات وعمليات السحب
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• يتم إضافة الرصيد للبائع بعد إتمام البيع وعدم وجود أي نزاع خلال 12 ساعة.</p>
                        <p>• تتم معالجة طلبات السحب خلال 1 إلى 4 أيام عمل. ويقع على المستخدم مسؤولية إدخال بيانات السحب بدقة.</p>
                        <p>• لا تتحمل NXO أي مسؤولية عن الخسائر الناتجة عن إدخال معلومات سحب غير صحيحة.</p>
                    </div>
                </section>

                <!-- 5: النزاعات وحماية المشتري -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                        النزاعات وحماية المشتري
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• يمكن للمشتري فتح نزاع خلال 12 ساعة من وقت الشراء. بعد انتهاء هذه المدة، لن تتدخل المنصة في النزاع.</p>
                        <p>• دور NXO يقتصر على حل النزاعات التي تتم داخل المنصة. وأي تواصل أو اتفاق يتم خارج المنصة يكون على مسؤولية المستخدم.</p>
                    </div>
                </section>

                <!-- 6: السلوك داخل المنصة -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">6</span>
                        السلوك داخل المنصة
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• أي استخدام لألفاظ مسيئة أو سلوك غير لائق سيؤدي إلى حظر الحساب بشكل دائم ومصادرة الرصيد.</p>
                        <p>• يمنع إدراج معلومات التواصل الخارجية أو الروابط في العروض أو الرسائل بغرض التحايل على المنصة.</p>
                        <p>• يُحظر استخدام NXO في تحويل الأموال أو تداول العملات أو أي أنشطة غير قانونية.</p>
                    </div>
                </section>

                <!-- 7: استخدام الحساب -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">7</span>
                        استخدام الحساب
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• يُسمح لكل مستخدم بامتلاك حساب واحد فقط. الحسابات المكررة سيتم حظرها بشكل دائم وقد تتم مصادرة الأرصدة.</p>
                        <p>• لا يجوز نقل الحساب أو مشاركته أو بيعه خارج منصة NXO.</p>
                    </div>
                </section>

                <!-- 8: الاسترجاع والإلغاء -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">8</span>
                        الاسترجاع والإلغاء
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• جميع المبيعات الرقمية على NXO نهائية وغير قابلة للاسترجاع.</p>
                        <p>• يمكن إلغاء الطلب فقط بموافقة البائع وقبل تأكيد التسليم.</p>
                    </div>
                </section>

                <!-- 9: الرسوم والعمولات -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">9</span>
                        الرسوم والعمولات
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• تفرض NXO رسوم خدمة تتراوح بين 3٪ و10٪ حسب نوع الحساب أو الخدمة.</p>
                        <p>• تحتفظ المنصة بحقها في تعديل الرسوم أو العمولات أو سياسات السحب في أي وقت دون إشعار مسبق.</p>
                    </div>
                </section>

                <!-- 10: حقوق المنصة -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">10</span>
                        حقوق المنصة
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <p>• تحتفظ NXO بحقها في رفض أو إزالة أي عرض دون إبداء الأسباب.</p>
                        <p>• في حال حدوث احتيال أو خرق للقوانين أو الشروط، يحق للمنصة إيقاف الحسابات بشكل دائم ومصادرة أي أرصدة.</p>
                        <p>• يحق للمنصة طلب مستندات تحقق إضافية لأسباب أمنية أو تنظيمية.</p>
                    </div>
                </section>

                <!-- 11: قبول الشروط -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">11</span>
                        قبول الشروط
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>باستمرارك في استخدام منصة NXO بعد أي تحديث للشروط والأحكام، فإنك توافق تلقائيًا على الشروط الجديدة. إذا كنت لا توافق، يجب عليك التوقف عن استخدام المنصة فورًا.</p>
                        <p class="mt-4">كما أن موافقتك على هذه الشروط تعني موافقتك على <a href="{{ route('legal.privacy') }}" class="text-primary-400 underline">سياسة الخصوصية</a> الخاصة بنا.</p>
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
