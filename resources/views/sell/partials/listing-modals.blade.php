<div x-data="{
    // State management
    open: false,
    step: 'form',
    flow: 'game',
    verifyMode: 'code',
    showPassword: false,
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
}" x-init="window.NetroSellFlow = { open: (flow) => { openModal(flow) } }">
    <!-- Step A: Delivery Information -->
    <template x-if="open && step === 'delivery'">
        <div class="fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
            <div class="relative max-w-2xl mx-auto mt-16 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl overflow-hidden">
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
                <div class="px-6 py-4 border-t border-gaming flex items-center justify-end gap-3">
                    <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming" @click="closeModal()">Cancel</button>
                    <button class="px-5 py-2 rounded-xl bg-gaming-gradient text-white font-bold" @click="continueToVerify()">Continue</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Step B: Ownership Confirmation -->
    <template x-if="open && step === 'verify'">
        <div class="fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
            <div class="relative max-w-2xl mx-auto mt-16 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl overflow-hidden">
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
                <div class="px-6 py-4 border-t border-gaming flex items-center justify-end gap-3">
                    <button class="px-5 py-2 rounded-xl bg-dark-900 text-muted-300 border border-gaming" @click="saveDraft()">Skip for Draft</button>
                    <button class="px-5 py-2 rounded-xl bg-gaming-gradient text-white font-bold" @click="verifyAndSubmit()">Verify Ownership</button>
                </div>
            </div>
        </div>
    </template>
</div>


