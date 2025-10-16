<x-layouts.stellar>
    <x-slot name="title">{{ __('سياسة الخصوصية') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-16 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('سياسة الخصوصية') }}
                </h1>
                <p class="text-slate-400" data-aos="fade-down" data-aos-delay="200">
                {{ __('آخر تحديث: :date', ['date' => now()->locale('ar')->translatedFormat('d F Y')]) }}

                </p>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-8 lg:p-12 border border-slate-700/50 space-y-8" data-aos="fade-up">

                <!-- قسم التحقق من الهوية (KYC) -->
                <section class="bg-slate-700/30 rounded-xl p-6 border border-slate-600/50">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 text-primary-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        التحقق من الهوية وجمع بيانات KYC
                    </h2>
                    <div class="space-y-4">
                        <p class="text-slate-300">
                            <strong class="text-white">الغرض:</strong> نقوم بجمع مستندات التحقق من الهوية (KYC - اعرف عميلك) للامتثال للوائح المالية، ومنع الاحتيال، وضمان أمان منصتنا.
                        </p>
                        <p class="text-slate-300">
                            <strong class="text-white">الأساس القانوني:</strong> هذا الجمع مطلوب للبائعين لاستخدام منصتنا ويتم وفقًا لقانون حماية البيانات الشخصية السعودي (PDPL) ولوائح مكافحة غسل الأموال الدولية.
                        </p>
                        <p class="text-slate-300"><strong class="text-white">البيانات التي يتم جمعها:</strong></p>
                        <ul class="list-disc list-inside text-slate-300 space-y-2 ml-4">
                            <li>الاسم الكامل وتاريخ الميلاد</li>
                            <li>دولة الإقامة</li>
                            <li>وثائق الهوية الحكومية (جواز السفر، الهوية الوطنية، رخصة القيادة)</li>
                            <li>رقم ونوع الهوية</li>
                            <li>صور المستندات (الوجه الأمامي والخلفي إن وُجد)</li>
                        </ul>
                        <p class="text-slate-300">
                            <strong class="text-white">الأمان:</strong> يتم تشفير جميع مستندات الهوية وتخزينها بشكل آمن باستخدام تقنيات التشفير القياسية، ولا يتم الوصول إليها إلا من قبل موظفين مخوّلين وتحت رقابة صارمة.
                        </p>
                        <p class="text-slate-300">
                            <strong class="text-white">الاحتفاظ:</strong> نحتفظ ببيانات التحقق طوال مدة حسابك ولفترة 7 سنوات بعد إغلاقه وفقًا للمتطلبات المالية. يمكنك طلب حذفها بعد إغلاق الحساب إذا سمحت القوانين.
                        </p>
                        <p class="text-slate-300">
                            <strong class="text-white">المشاركة:</strong> لا نقوم ببيع أو مشاركة بيانات التحقق الخاصة بك مع أي طرف ثالث إلا إذا طُلب ذلك قانونيًا أو بموافقتك الصريحة.
                        </p>
                    </div>
                </section>

                <!-- 1: المقدمة -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        المقدمة
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>في NetroHub، نُقدّر خصوصيتك وملتزمون بحماية بياناتك الشخصية. توضح هذه السياسة كيفية جمعنا واستخدامنا وتخزيننا وحماية معلوماتك عند استخدامك لمنصتنا.</p>
                    </div>
                </section>

                <!-- 2: المعلومات التي نجمعها -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        المعلومات التي نجمعها
                    </h2>
                    <div class="text-slate-300 leading-relaxed space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">المعلومات الشخصية:</h3>
                            <p>الاسم، البريد الإلكتروني، رقم الهاتف، والهوية الحكومية (عند الحاجة للتحقق).</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">معلومات الحساب:</h3>
                            <p>بيانات تسجيل الدخول، بيانات الملف الشخصي، وتفاصيل الدفع.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">معلومات المعاملات:</h3>
                            <p>تفاصيل المشتريات والمبيعات وطلبات السحب.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">بيانات الجهاز والاستخدام:</h3>
                            <p>عنوان IP، نوع المتصفح، وإحصاءات الاستخدام.</p>
                        </div>
                    </div>
                </section>

                <!-- 3: كيفية استخدام المعلومات -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        كيفية استخدام المعلومات
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p class="mb-3">نستخدم البيانات التي نجمعها من أجل:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• تقديم خدماتنا وتحسينها.</li>
                            <li>• تأمين الحسابات ومنع الاحتيال.</li>
                            <li>• معالجة المدفوعات وعمليات السحب.</li>
                            <li>• إرسال التحديثات والإشعارات المهمة.</li>
                            <li>• الامتثال للمتطلبات القانونية والتنظيمية.</li>
                        </ul>
                    </div>
                </section>

                <!-- 4: أمان البيانات -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                        أمان البيانات
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>نستخدم تقنيات التشفير القياسية وخوادم آمنة وضوابط وصول صارمة لحماية بياناتك. وعلى الرغم من حرصنا على أعلى درجات الأمان، لا توجد وسيلة نقل عبر الإنترنت آمنة بنسبة 100٪. نوصيك بالحفاظ على سرية بيانات الدخول الخاصة بك.</p>
                    </div>
                </section>

                <!-- 5: مشاركة البيانات -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                        مشاركة البيانات
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p class="mb-3">قد نشارك بياناتك في الحالات التالية:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• مع مزودي خدمات الدفع لإتمام المعاملات.</li>
                            <li>• مع الجهات القانونية عند الطلب وفقًا للقانون.</li>
                            <li>• مع مزودي خدمات طرف ثالث لأغراض تشغيلية بحتة (مثل إرسال البريد الإلكتروني، التحليلات).</li>
                        </ul>

                        <!-- فقرة أدوات التحليل وملفات الطرف الثالث -->
                        <p class="text-slate-300 mt-4">
                            <strong class="text-white">أدوات التحليل وملفات الطرف الثالث:</strong>
                            قد نستخدم خدمات تحليلية تابعة لجهات خارجية مثل <em>Google Analytics</em> لتحسين أداء منصتنا وفهم كيفية استخدام المستخدمين لخدماتنا. قد تجمع هذه الأدوات بيانات غير شخصية مثل نوع الجهاز ونظام التشغيل وسلوك التصفح، ويتم التعامل مع هذه المعلومات وفقًا لسياسات الخصوصية الخاصة بمزودي تلك الخدمات.
                        </p>
                    </div>
                </section>

                <!-- 6: حقوقك -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">6</span>
                        حقوقك
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p class="mb-3">يحق لك:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• طلب الوصول إلى بياناتك والحصول على نسخة منها.</li>
                            <li>• تصحيح المعلومات غير الدقيقة أو القديمة.</li>
                            <li>• طلب حذف بياناتك حيثما كان ذلك مسموحًا قانونيًا.</li>
                            <li>• سحب الموافقة على معالجة البيانات في أي وقت.</li>
                        </ul>
                    </div>
                </section>

                <!-- 7: ملفات تعريف الارتباط (الكوكيز) -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">7</span>
                        ملفات تعريف الارتباط (الكوكيز)
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>نستخدم ملفات تعريف الارتباط لتحسين تجربتك، وتذكر تفضيلاتك، وتعزيز وظائف المنصة. يمكنك تعطيل الكوكيز من إعدادات المتصفح، لكن قد لا تعمل بعض الخصائص بالشكل المتوقع.</p>
                    </div>
                </section>

                <!-- 8: تحديثات السياسة -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">8</span>
                        تحديثات السياسة
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>قد نقوم بتحديث هذه السياسة من حين لآخر. يعني استمرارك في استخدام المنصة بعد أي تغييرات قبولك للشروط المحدّثة.</p>
                    </div>
                </section>

                <!-- 9: تواصل معنا -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">9</span>
                        تواصل معنا
                    </h2>
                    <div class="text-slate-300 leading-relaxed">
                        <p>لأي استفسارات بخصوص هذه السياسة أو كيفية تعاملنا مع بياناتك، يُرجى التواصل مع فريق الدعم عبر قسم "المساعدة" في المنصة.</p>
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
