@props(['user', 'showPlan' => true, 'size' => 'sm'])

@if($showPlan)
    <x-subscription-badge :user="$user" :size="$size" />
@endif

