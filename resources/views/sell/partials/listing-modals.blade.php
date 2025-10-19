<div x-data="{
    // State management
    open: false,
    step: 'form',
    flow: 'game',
    verifyMode: 'code',
    showPassword: false,
    legalAccepted: false,
    form: {
        delivery_email: '',
        delivery_password: '',
        delivery_instructions: '',
        verification_code: '',
        extras: [{key:'', value:''}],
    },
    
    // Lifecycle
    init() {
        if (!this.form.verification_code) {
            this.form.verification_code = Math.random().toString(36).slice(2, 8).toUpperCase();
        }
    },
    
    // API methods
    openModal(flow) {
        this.flow = flow || 'game';
        this.step = 'delivery';
        this.open = true;
    },
    close() {
        this.open = false;
    },
    closeModal() {
        this.open = false;
    },
    continueToVerify() {
        this.step = 'verify';
    },
    backToDelivery() {
        this.step = 'delivery';
    },
    continueToLegal() {
        this.step = 'legal';
    },
    backToVerify() {
        this.step = 'verify';
    },
    togglePassword() {
        this.showPassword = !this.showPassword;
    },
    addExtra() {
        this.form.extras.push({key:'', value:''});
    },
    removeExtra(index) {
        this.form.extras.splice(index, 1);
    },
    copyCode() {
        navigator.clipboard?.writeText(this.form.verification_code);
    },
    buildHiddenInputs(formEl) {
        formEl.querySelectorAll('.js-flow-hidden').forEach(e => e.remove());
        const addInput = (name, value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            input.className = 'js-flow-hidden';
            formEl.appendChild(input);
        };
        addInput('delivery_email', this.form.delivery_email);
        addInput('delivery_password', this.form.delivery_password);
        addInput('delivery_instructions', this.form.delivery_instructions);
        this.form.extras.forEach((row) => {
            if (row.key && row.value) {
                addInput('delivery_extras_key[]', row.key);
                addInput('delivery_extras_value[]', row.value);
            }
        });
        addInput('verification_code', this.form.verification_code);
        addInput('verification_status', this.verifyMode === 'skip' ? 'skipped_draft' : 'pending');
    },
    saveDraft() {
        const formEl = document.getElementById(this.flow === 'game' ? 'game-form' : 'social-form');
        if (!formEl) {
            console.error('Form element not found');
            return;
        }
        this.buildHiddenInputs(formEl);
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'draft';
        actionInput.className = 'js-flow-hidden';
        formEl.appendChild(actionInput);
        if (this.$refs.proof && this.$refs.proof.files && this.$refs.proof.files[0]) {
            this.$refs.proof.name = 'verification_proof';
            formEl.appendChild(this.$refs.proof);
        }
        formEl.submit();
    },
    verifyAndSubmit() {
        const formEl = document.getElementById(this.flow === 'game' ? 'game-form' : 'social-form');
        if (!formEl) {
            console.error('Form element not found');
            return;
        }
        this.buildHiddenInputs(formEl);
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'publish';
        actionInput.className = 'js-flow-hidden';
        formEl.appendChild(actionInput);
        if (this.verifyMode === 'proof' && this.$refs.proof && this.$refs.proof.files && this.$refs.proof.files[0]) {
            this.$refs.proof.name = 'verification_proof';
            formEl.appendChild(this.$refs.proof);
        }
        formEl.submit();
    }
}" x-init="window.NetroSellFlow = { open: (flow) => { this.openModal(flow) } }">
    <!-- Step A: Delivery Information -->
    <template x-if="open && step === 'delivery'">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
            <div class="relative max-w-2xl mx-auto mt-4 sm:mt-16 mb-4 sm:mb-16 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl overflow-hidden">
                <!-- Progress Indicator -->
                <div class="px-6 py-3 border-b border-gaming">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-slate-400">Step 1 of 3</span>
                        <span class="text-sm text-slate-400">Delivery Information</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full" style="width: 33%"></div>
                    </div>
                </div>
                <div class="px-6 py-4 border-b border-gaming flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Delivery Information</h3>
                    <button class="text-muted-400 hover:text-white" @click="closeModal()">✕</button>
                </div>
                <div class="p-6 space-y-6">
                    <p class="text-sm text-muted-300">Use a unique password. We store these encrypted and reveal them only to the buyer after purchase.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Account Email</label>
                            <input type="email" x-model="form.delivery_email" class="w-full px-4 py-3 bg-dark-900 border border-gaming rounded-xl text-white" placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Account Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" x-model="form.delivery_password" class="w-full px-4 py-3 bg-dark-900 border border-gaming rounded-xl text-white pr-10" placeholder="••••••••">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-muted-300" @click="showPassword = !showPassword">Show</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Additional Data</label>
                        <template x-for="(row, idx) in form.extras" :key="idx">
                            <div class="grid grid-cols-2 gap-3 mb-2">
                                <input x-model="row.key" class="px-3 py-2 bg-dark-900 border border-gaming rounded-xl text-white" placeholder="Key (e.g., 2FA recovery)">
                                <input x-model="row.value" class="px-3 py-2 bg-dark-900 border border-gaming rounded-xl text-white" placeholder="Value">
                            </div>
                        </template>
                        <button type="button" class="mt-2 text-primary-400 font-semibold" @click="addExtra()">+ Add Extra Data</button>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Delivery Instructions for Buyer</label>
                        <textarea x-model="form.delivery_instructions" rows="4" class="w-full px-4 py-3 bg-dark-900 border border-gaming rounded-xl text-white" placeholder="Any steps the buyer should follow after purchase"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gaming flex items-center justify-between gap-3 sticky bottom-0 bg-dark-800/90 backdrop-blur-sm">
                    <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming hover:bg-dark-700 transition-colors" @click="closeModal()">Cancel</button>
                    <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-blue-500 text-white font-bold hover:from-purple-600 hover:to-blue-600 transition-all shadow-lg" @click="continueToVerify()">Continue to Verification</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Step B: Ownership Confirmation -->
    <template x-if="open && step === 'verify'">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
            <div class="relative max-w-2xl mx-auto mt-4 sm:mt-16 mb-4 sm:mb-16 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl overflow-hidden">
                <!-- Progress Indicator -->
                <div class="px-6 py-3 border-b border-gaming">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-slate-400">Step 2 of 3</span>
                        <span class="text-sm text-slate-400">Ownership Verification</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full" style="width: 66%"></div>
                    </div>
                </div>
                <div class="px-6 py-4 border-b border-gaming flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Confirm Ownership & Delivery Info</h3>
                    <button class="text-muted-400 hover:text-white" @click="closeModal()">✕</button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-3">
                        <input type="text" x-model="form.verification_code" readonly class="px-4 py-3 bg-dark-900 border border-gaming rounded-xl text-white w-40">
                        <button type="button" class="px-4 py-2 rounded-xl bg-dark-900 text-primary-400 border border-gaming" @click="copyCode()">Copy</button>
                    </div>
                    <p class="text-sm text-muted-300">Place this code in the profile bio or a pinned area, then click Verify Ownership.</p>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2">
                            <input type="radio" value="code" x-model="verifyMode" class="accent-primary-500">
                            <span class="text-white">I added the code</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" value="proof" x-model="verifyMode" class="accent-primary-500">
                            <span class="text-white">Upload proof (screenshot)</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" value="skip" x-model="verifyMode" class="accent-primary-500">
                            <span class="text-white">Skip for now (Draft)</span>
                        </label>
                    </div>

                    <div x-show="verifyMode === 'proof'">
                        <input type="file" x-ref="proof" accept="image/*" class="block w-full text-sm text-muted-300">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gaming flex items-center justify-between gap-3 sticky bottom-0 bg-dark-800/90 backdrop-blur-sm">
                    <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming hover:bg-dark-700 transition-colors" @click="backToDelivery()">Back</button>
                    <div class="flex gap-3">
                        <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming hover:bg-dark-700 transition-colors" @click="saveDraft()">Save as Draft</button>
                        <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-blue-500 text-white font-bold hover:from-purple-600 hover:to-blue-600 transition-all shadow-lg" @click="continueToLegal()">Continue to Legal</button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Step C: Legal Confirmation -->
    <template x-if="open && step === 'legal'">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
            <div class="relative max-w-2xl mx-auto mt-4 sm:mt-16 mb-4 sm:mb-16 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl overflow-hidden">
                <!-- Progress Indicator -->
                <div class="px-6 py-3 border-b border-gaming">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-slate-400">Step 3 of 3</span>
                        <span class="text-sm text-slate-400">Legal Confirmation</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div class="px-6 py-4 border-b border-gaming flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Legal Confirmation</h3>
                    <button class="text-muted-400 hover:text-white" @click="closeModal()">✕</button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h4 class="text-lg font-bold text-white mb-3">Important Legal Notice</h4>
                        <p class="text-slate-300 text-sm leading-relaxed mb-4">
                            By proceeding, you confirm that you are the legitimate owner of this account and have the legal right to sell it. 
                            You understand that selling accounts may violate the terms of service of the platform, and you accept full legal responsibility for any consequences.
                        </p>
                        <ul class="text-slate-300 text-sm space-y-2">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>You will not include any external contact information in your listing</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>You accept full legal responsibility for the account sale</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>You understand this may violate platform terms of service</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <input type="checkbox" x-model="legalAccepted" class="mt-1 w-4 h-4 text-purple-600 bg-slate-800 border-slate-600 rounded focus:ring-purple-500 focus:ring-2">
                        <label class="text-sm text-slate-300 leading-relaxed">
                            I confirm not to include any external contact info and accept full legal responsibility for the account. 
                            I understand the risks and consequences of selling this account.
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gaming flex items-center justify-between gap-3 sticky bottom-0 bg-dark-800/90 backdrop-blur-sm">
                    <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming hover:bg-dark-700 transition-colors" @click="backToVerify()">Back</button>
                    <div class="flex gap-3">
                        <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming hover:bg-dark-700 transition-colors" @click="saveDraft()">Save as Draft</button>
                        <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-blue-500 text-white font-bold hover:from-purple-600 hover:to-blue-600 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" 
                                :disabled="!legalAccepted" 
                                @click="verifyAndSubmit()">Publish Listing</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>


