<?php

namespace App\Traits;

use App\Models\FeatureFlag;

trait HasFeatureGates
{
    /**
     * Check if user has access to a feature
     */
    public function hasFeature(string $featureKey): bool
    {
        return FeatureFlag::isEnabled($featureKey, $this);
    }

    /**
     * Check if user has access to any of the given features
     */
    public function hasAnyFeature(array $featureKeys): bool
    {
        foreach ($featureKeys as $key) {
            if ($this->hasFeature($key)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has access to all of the given features
     */
    public function hasAllFeatures(array $featureKeys): bool
    {
        foreach ($featureKeys as $key) {
            if (!$this->hasFeature($key)) {
                return false;
            }
        }
        
        return true;
    }
}

