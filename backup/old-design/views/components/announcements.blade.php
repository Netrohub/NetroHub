@if(isset($activeAnnouncements) && $activeAnnouncements->count() > 0)
    <div class="announcements-container" x-data="announcementsHandler()">
        @foreach($activeAnnouncements as $announcement)
            <div 
                x-show="!isDismissed({{ $announcement->id }})"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="announcement-banner announcement-{{ $announcement->type }} {{ $announcement->is_dismissible ? 'dismissible' : '' }}"
                role="alert"
            >
                <div class="container mx-auto flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <!-- Icon based on type -->
                        <div class="announcement-icon flex-shrink-0">
                            @switch($announcement->type)
                                @case('success')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    @break
                                @case('warning')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    @break
                                @case('danger')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                            @endswitch
                        </div>

                        <!-- Content -->
                        <div class="announcement-content">
                            @if($announcement->title)
                                <strong class="announcement-title">{{ $announcement->title }}</strong>
                            @endif
                            <span class="announcement-message">{{ $announcement->message }}</span>
                        </div>
                    </div>

                    <!-- Dismiss button -->
                    @if($announcement->is_dismissible)
                        <button 
                            @click="dismiss({{ $announcement->id }})"
                            class="announcement-dismiss flex-shrink-0 ml-6"
                            aria-label="Dismiss announcement"
                            title="Dismiss announcement"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .announcements-container {
            position: relative;
            z-index: 40;
        }

        .announcement-banner {
            font-size: 0.95rem;
            line-height: 1.6;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .announcement-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }

        .announcement-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
        }

        /* Info (Blue) - Enhanced */
        .announcement-info {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border-left: 4px solid #60a5fa;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
        }

        /* Success (Green) - Enhanced */
        .announcement-success {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            border-left: 4px solid #34d399;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }

        /* Warning (Orange/Yellow) - Enhanced */
        .announcement-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            border-left: 4px solid #fbbf24;
            box-shadow: 0 8px 32px rgba(245, 158, 11, 0.3);
        }

        /* Danger (Red) - Enhanced */
        .announcement-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            border-left: 4px solid #f87171;
            box-shadow: 0 8px 32px rgba(239, 68, 68, 0.3);
        }

        .announcement-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: iconPulse 2s infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .announcement-content {
            flex: 1;
            padding-left: 16px;
        }

        .announcement-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin-right: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.025em;
        }

        .announcement-message {
            font-weight: 500;
            opacity: 0.95;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .announcement-dismiss {
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .announcement-dismiss:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .announcement-dismiss:active {
            transform: scale(0.95);
        }

        /* Enhanced container styling */
        .announcement-banner .container {
            padding: 16px 24px;
            position: relative;
            z-index: 1;
        }

        /* Mobile responsiveness */
        @media (max-width: 640px) {
            .announcement-banner .container {
                padding: 12px 16px;
            }
            
            .announcement-icon {
                width: 32px;
                height: 32px;
            }
            
            .announcement-title {
                font-size: 1rem;
            }
            
            .announcement-message {
                font-size: 0.9rem;
            }
        }

        /* Add subtle animation for new announcements */
        .announcement-banner {
            animation: slideInDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function announcementsHandler() {
            return {
                dismissedAnnouncements: [],

                init() {
                    // Load dismissed announcements from localStorage
                    const stored = localStorage.getItem('dismissedAnnouncements');
                    if (stored) {
                        try {
                            this.dismissedAnnouncements = JSON.parse(stored);
                        } catch (e) {
                            this.dismissedAnnouncements = [];
                        }
                    }
                },

                isDismissed(id) {
                    return this.dismissedAnnouncements.includes(id);
                },

                dismiss(id) {
                    if (!this.dismissedAnnouncements.includes(id)) {
                        this.dismissedAnnouncements.push(id);
                        localStorage.setItem('dismissedAnnouncements', JSON.stringify(this.dismissedAnnouncements));
                    }
                }
            }
        }
    </script>
@endif

