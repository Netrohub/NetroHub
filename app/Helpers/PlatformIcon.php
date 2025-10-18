<?php

namespace App\Helpers;

class PlatformIcon
{
    /**
     * Map of platform names to their brand icons
     * Using Simple Icons CDN for consistent SVG brand icons
     */
    private static array $socialPlatforms = [
        'Instagram' => [
            'icon' => 'https://cdn.simpleicons.org/instagram/E4405F',
            'color' => 'text-pink-500',
            'bg' => 'bg-pink-500/10',
        ],
        'TikTok' => [
            'icon' => 'https://cdn.simpleicons.org/tiktok/000000',
            'color' => 'text-white',
            'bg' => 'bg-gray-900',
        ],
        'X (Twitter)' => [
            'icon' => 'https://cdn.simpleicons.org/x/000000',
            'color' => 'text-white',
            'bg' => 'bg-black',
        ],
        'YouTube' => [
            'icon' => 'https://cdn.simpleicons.org/youtube/FF0000',
            'color' => 'text-red-500',
            'bg' => 'bg-red-500/10',
        ],
        'Discord' => [
            'icon' => 'https://cdn.simpleicons.org/discord/5865F2',
            'color' => 'text-indigo-500',
            'bg' => 'bg-indigo-500/10',
        ],
        'Facebook' => [
            'icon' => 'https://cdn.simpleicons.org/facebook/1877F2',
            'color' => 'text-blue-600',
            'bg' => 'bg-blue-600/10',
        ],
        'Snapchat' => [
            'icon' => 'https://cdn.simpleicons.org/snapchat/FFFC00',
            'color' => 'text-yellow-400',
            'bg' => 'bg-yellow-400/10',
        ],
        'Twitch' => [
            'icon' => 'https://cdn.simpleicons.org/twitch/9146FF',
            'color' => 'text-purple-500',
            'bg' => 'bg-purple-500/10',
        ],
        'LinkedIn' => [
            'icon' => 'https://cdn.simpleicons.org/linkedin/0A66C2',
            'color' => 'text-blue-700',
            'bg' => 'bg-blue-700/10',
        ],
        'Reddit' => [
            'icon' => 'https://cdn.simpleicons.org/reddit/FF4500',
            'color' => 'text-orange-600',
            'bg' => 'bg-orange-600/10',
        ],
    ];

    private static array $gamePlatforms = [
        'fortnite' => [
            'icon' => 'https://cdn.simpleicons.org/epicgames/313131',
            'name' => 'Fortnite',
            'color' => 'text-white',
            'bg' => 'bg-gray-800',
        ],
        'whiteout_survival' => [
            'icon' => 'https://cdn.simpleicons.org/snowflake/29B5E8',
            'name' => 'Whiteout Survival',
            'color' => 'text-blue-400',
            'bg' => 'bg-blue-400/10',
        ],
        'league_of_legends' => [
            'icon' => 'https://cdn.simpleicons.org/riotgames/D32936',
            'name' => 'League of Legends',
            'color' => 'text-red-600',
            'bg' => 'bg-red-600/10',
        ],
        'valorant' => [
            'icon' => 'https://cdn.simpleicons.org/valorant/FA4454',
            'name' => 'Valorant',
            'color' => 'text-red-500',
            'bg' => 'bg-red-500/10',
        ],
        'call_of_duty' => [
            'icon' => 'https://cdn.simpleicons.org/activision/000000',
            'name' => 'Call of Duty',
            'color' => 'text-white',
            'bg' => 'bg-black',
        ],
        'minecraft' => [
            'icon' => 'https://cdn.simpleicons.org/minecraft/62B47A',
            'name' => 'Minecraft',
            'color' => 'text-green-500',
            'bg' => 'bg-green-500/10',
        ],
        'roblox' => [
            'icon' => 'https://cdn.simpleicons.org/roblox/000000',
            'name' => 'Roblox',
            'color' => 'text-white',
            'bg' => 'bg-black',
        ],
        'genshin_impact' => [
            'icon' => 'https://cdn.simpleicons.org/genshinimpact/FFB13D',
            'name' => 'Genshin Impact',
            'color' => 'text-yellow-500',
            'bg' => 'bg-yellow-500/10',
        ],
        'psn' => [
            'icon' => 'https://cdn.simpleicons.org/playstation/003791',
            'name' => 'PSN',
            'color' => 'text-blue-700',
            'bg' => 'bg-blue-700/10',
        ],
        'others' => [
            'icon' => 'https://cdn.simpleicons.org/gamepad/667EEA',
            'name' => 'Other Games',
            'color' => 'text-indigo-400',
            'bg' => 'bg-indigo-400/10',
        ],
    ];

    private static array $consolePlatforms = [
        'Mobile' => [
            'icon' => 'https://cdn.simpleicons.org/android/3DDC84',
            'color' => 'text-green-500',
            'bg' => 'bg-green-500/10',
        ],
        'PC' => [
            'icon' => 'https://cdn.simpleicons.org/windows/0078D6',
            'color' => 'text-blue-500',
            'bg' => 'bg-blue-500/10',
        ],
        'PlayStation' => [
            'icon' => 'https://cdn.simpleicons.org/playstation/003791',
            'color' => 'text-blue-700',
            'bg' => 'bg-blue-700/10',
        ],
        'Xbox' => [
            'icon' => 'https://cdn.simpleicons.org/xbox/107C10',
            'color' => 'text-green-600',
            'bg' => 'bg-green-600/10',
        ],
        'Nintendo' => [
            'icon' => 'https://cdn.simpleicons.org/nintendoswitch/E60012',
            'color' => 'text-red-600',
            'bg' => 'bg-red-600/10',
        ],
    ];

    /**
     * Get icon data for a platform
     */
    public static function get(string $platform, string $type = 'social'): array
    {
        $platform = trim($platform);

        // Check social platforms
        if (isset(self::$socialPlatforms[$platform])) {
            return array_merge(self::$socialPlatforms[$platform], ['name' => $platform]);
        }

        // Check game platforms (by slug)
        $slug = strtolower(str_replace(' ', '_', $platform));
        if (isset(self::$gamePlatforms[$slug])) {
            return self::$gamePlatforms[$slug];
        }

        // Check console platforms
        if (isset(self::$consolePlatforms[$platform])) {
            return array_merge(self::$consolePlatforms[$platform], ['name' => $platform]);
        }

        // Default fallback
        return [
            'icon' => 'https://cdn.simpleicons.org/globe/667EEA',
            'name' => $platform ?: 'Platform',
            'color' => 'text-gray-400',
            'bg' => 'bg-gray-400/10',
        ];
    }

    /**
     * Get icon URL for a platform
     */
    public static function getIcon(string $platform, string $type = 'social'): string
    {
        return self::get($platform, $type)['icon'];
    }

    /**
     * Get all social platforms
     */
    public static function getSocialPlatforms(): array
    {
        return self::$socialPlatforms;
    }

    /**
     * Get all game platforms
     */
    public static function getGamePlatforms(): array
    {
        return self::$gamePlatforms;
    }

    /**
     * Get all console platforms
     */
    public static function getConsolePlatforms(): array
    {
        return self::$consolePlatforms;
    }

    /**
     * Get icon for category
     */
    public static function getCategoryIcon(string $categoryName): array
    {
        $icons = [
            'Instagram' => [
                'icon' => 'https://cdn.simpleicons.org/instagram/E4405F',
                'color' => 'text-pink-500',
                'bg' => 'bg-pink-500/10',
            ],
            'TikTok' => [
                'icon' => 'https://cdn.simpleicons.org/tiktok/000000',
                'color' => 'text-white',
                'bg' => 'bg-gray-900',
            ],
            'Fortnite' => [
                'icon' => 'https://cdn.simpleicons.org/epicgames/313131',
                'color' => 'text-white',
                'bg' => 'bg-gray-800',
            ],
            'Whiteout Survival' => [
                'icon' => 'https://cdn.simpleicons.org/snowflake/29B5E8',
                'color' => 'text-blue-400',
                'bg' => 'bg-blue-400/10',
            ],
            'Social accounts' => [
                'icon' => 'https://cdn.simpleicons.org/instagram/E4405F',
                'color' => 'text-pink-500',
                'bg' => 'bg-pink-500/10',
            ],
            'Games accounts' => [
                'icon' => 'https://cdn.simpleicons.org/epicgames/313131',
                'color' => 'text-white',
                'bg' => 'bg-gray-800',
            ],
            'Social' => [
                'icon' => 'https://cdn.simpleicons.org/instagram/E4405F',
                'color' => 'text-pink-500',
                'bg' => 'bg-pink-500/10',
            ],
            'Games' => [
                'icon' => 'https://cdn.simpleicons.org/epicgames/313131',
                'color' => 'text-white',
                'bg' => 'bg-gray-800',
            ],
            'Gaming' => [
                'icon' => 'https://cdn.simpleicons.org/epicgames/313131',
                'color' => 'text-white',
                'bg' => 'bg-gray-800',
            ],
            'Services' => [
                'icon' => 'https://cdn.simpleicons.org/servicestack/02303A',
                'color' => 'text-blue-400',
                'bg' => 'bg-blue-400/10',
            ],
            'Digital Products' => [
                'icon' => 'https://cdn.simpleicons.org/digitalocean/0080FF',
                'color' => 'text-blue-500',
                'bg' => 'bg-blue-500/10',
            ],
        ];

        return $icons[$categoryName] ?? [
            'icon' => 'https://cdn.simpleicons.org/globe/667EEA',
            'color' => 'text-gray-400',
            'bg' => 'bg-gray-400/10',
        ];
    }

    /**
     * Get platform data from product metadata or fallback
     */
    public static function getFromProduct($product): array
    {
        // Try to get from metadata first
        if (is_array($product->metadata ?? null) && isset($product->metadata['platform'])) {
            return self::get($product->metadata['platform']);
        }

        // Try to get from type
        if (isset($product->type)) {
            if ($product->type === 'social_account') {
                return self::get($product->metadata['platform'] ?? 'Instagram');
            } elseif ($product->type === 'game_account') {
                // Try to get game category from metadata
                $gameCategory = $product->metadata['game_category'] ?? 'others';

                return self::get($gameCategory, 'game');
            }
        }

        // Fallback to category
        if (isset($product->category->name)) {
            return self::getCategoryIcon($product->category->name);
        }

        return self::get('');
    }
}
