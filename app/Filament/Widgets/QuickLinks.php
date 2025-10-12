<?php

namespace App\Filament\Widgets;

use App\Models\Dispute;
use App\Models\PayoutRequest;
use App\Models\Seller;
use App\Models\WebhookLog;
use Filament\Widgets\Widget;

class QuickLinks extends Widget
{
    protected static ?int $sort = 3;

    protected static string $view = 'filament.widgets.quick-links';

    public function getLinks(): array
    {
        $kycPending = (int) Seller::where('kyc_status', 'pending')->count() ?? 0;
        $openDisputes = (int) Dispute::whereIn('status', ['open', 'in_review'])->count() ?? 0;
        $payoutsPending = (int) PayoutRequest::where('status', 'pending')->count() ?? 0;
        $webhookFailures = (int) WebhookLog::where('status', 'failed')->count() ?? 0;

        return [
            [
                'label' => 'Review KYC',
                'count' => $kycPending,
                'url' => null,
                'color' => $kycPending > 0 ? 'warning' : 'gray',
                'icon' => 'heroicon-o-identification',
            ],
            [
                'label' => 'Open Disputes',
                'count' => $openDisputes,
                'url' => null,
                'color' => $openDisputes > 0 ? 'danger' : 'gray',
                'icon' => 'heroicon-o-exclamation-triangle',
            ],
            [
                'label' => 'Payout Requests',
                'count' => $payoutsPending,
                'url' => null,
                'color' => $payoutsPending > 0 ? 'warning' : 'gray',
                'icon' => 'heroicon-o-banknotes',
            ],
            [
                'label' => 'Webhook Failures',
                'count' => $webhookFailures,
                'url' => null,
                'color' => $webhookFailures > 0 ? 'danger' : 'gray',
                'icon' => 'heroicon-o-bolt-slash',
            ],
        ];
    }
}
