<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CredentialDeliveryTest extends TestCase
{
    use RefreshDatabase;

    protected User $buyer;

    protected User $seller;

    protected Seller $sellerProfile;

    protected Product $uniqueProduct;

    protected Product $nonUniqueProduct;

    protected function setUp(): void
    {
        parent::setUp();

        // Create buyer
        $this->buyer = User::factory()->create();

        // Create seller
        $this->seller = User::factory()->create();
        $this->sellerProfile = Seller::factory()->create([
            'user_id' => $this->seller->id,
            'is_active' => true,
        ]);

        $category = Category::factory()->create();

        // Create unique credential product
        $this->uniqueProduct = Product::factory()->create([
            'seller_id' => $this->sellerProfile->id,
            'category_id' => $category->id,
            'delivery_credentials' => [
                'username' => 'test@example.com',
                'password' => 'SecurePass123!',
                'extras' => [
                    ['k' => '2FA Backup Codes', 'v' => 'ABC123, DEF456'],
                ],
                'instructions' => 'Please change password after login',
            ],
            'is_unique_credential' => true,
            'verification_status' => 'verified',
            'status' => 'active',
            'price' => 99.99,
        ]);

        // Create non-unique credential product
        $this->nonUniqueProduct = Product::factory()->create([
            'seller_id' => $this->sellerProfile->id,
            'category_id' => $category->id,
            'delivery_credentials' => [
                'username' => 'shared@example.com',
                'password' => 'SharedPass123!',
                'extras' => [],
                'instructions' => 'This is a shared account',
            ],
            'is_unique_credential' => false,
            'verification_status' => 'verified',
            'status' => 'active',
            'price' => 49.99,
        ]);
    }

    /** @test */
    public function unique_credential_can_only_be_claimed_by_first_buyer()
    {
        // Create two orders for the same unique product
        $order1 = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $buyer2 = User::factory()->create();
        $order2 = Order::factory()->create([
            'user_id' => $buyer2->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item1 = OrderItem::factory()->create([
            'order_id' => $order1->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        $item2 = OrderItem::factory()->create([
            'order_id' => $order2->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        // First buyer claims successfully
        $this->assertTrue($item1->claimCredentials());
        $this->assertNotNull($item1->fresh()->credential_claimed_at);

        // Second buyer fails to claim
        $this->assertFalse($item2->claimCredentials());
        $this->assertNull($item2->fresh()->credential_claimed_at);

        // Product should be archived
        $this->assertEquals('archived', $this->uniqueProduct->fresh()->status);
    }

    /** @test */
    public function non_unique_credentials_can_be_claimed_by_multiple_buyers()
    {
        $order1 = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $buyer2 = User::factory()->create();
        $order2 = Order::factory()->create([
            'user_id' => $buyer2->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item1 = OrderItem::factory()->create([
            'order_id' => $order1->id,
            'product_id' => $this->nonUniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        $item2 = OrderItem::factory()->create([
            'order_id' => $order2->id,
            'product_id' => $this->nonUniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        // Both buyers can claim
        $this->assertTrue($item1->claimCredentials());
        $this->assertTrue($item2->claimCredentials());

        // Product should still be active
        $this->assertEquals('active', $this->nonUniqueProduct->fresh()->status);
    }

    /** @test */
    public function buyer_can_view_credentials_within_limit()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
            'credential_view_limit' => 3,
        ]);

        $item->claimCredentials();

        // Can view initially
        $this->assertTrue($item->canViewCredentials());
        $this->assertEquals(3, $item->getRemainingViews());

        // Record views
        $item->recordCredentialView($this->buyer, '127.0.0.1', 'TestAgent');
        $this->assertEquals(2, $item->fresh()->getRemainingViews());

        $item->recordCredentialView($this->buyer, '127.0.0.1', 'TestAgent');
        $this->assertEquals(1, $item->fresh()->getRemainingViews());

        $item->recordCredentialView($this->buyer, '127.0.0.1', 'TestAgent');
        $this->assertEquals(0, $item->fresh()->getRemainingViews());

        // Can no longer view
        $this->assertFalse($item->fresh()->canViewCredentials());
    }

    /** @test */
    public function delivery_page_requires_authentication()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $response = $this->get(route('orders.delivery', $order));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function buyer_can_access_own_delivery_page()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        $response = $this->actingAs($this->buyer)
            ->get(route('orders.delivery', $order));

        $response->assertOk();
        $response->assertSee('Secure Delivery');
    }

    /** @test */
    public function buyer_cannot_access_others_delivery_page()
    {
        $otherBuyer = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $otherBuyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($this->buyer)
            ->get(route('orders.delivery', $order));

        $response->assertForbidden();
    }

    /** @test */
    public function credentials_are_revealed_via_ajax()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
            'credential_view_limit' => 3,
        ]);

        $item->claimCredentials();

        $response = $this->actingAs($this->buyer)
            ->postJson(route('orders.delivery.reveal', [$order, $item]));

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'credentials' => [
                'username',
                'password',
                'extras',
                'instructions',
            ],
            'remaining_views',
        ]);

        $this->assertEquals('test@example.com', $response->json('credentials.username'));
        $this->assertEquals('SecurePass123!', $response->json('credentials.password'));
        $this->assertEquals(2, $response->json('remaining_views'));

        // Check that view was logged
        $this->assertDatabaseHas('credential_views', [
            'order_item_id' => $item->id,
            'user_id' => $this->buyer->id,
        ]);
    }

    /** @test */
    public function credentials_cannot_be_viewed_after_limit_reached()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
            'credential_view_limit' => 1,
            'credential_view_count' => 1, // Already reached limit
        ]);

        $item->claimCredentials();

        $response = $this->actingAs($this->buyer)
            ->postJson(route('orders.delivery.reveal', [$order, $item]));

        $response->assertForbidden();
        $response->assertJson([
            'error' => 'Credentials cannot be viewed. You may have reached your view limit or the order is not paid.',
        ]);
    }

    /** @test */
    public function email_notification_contains_delivery_link_not_credentials()
    {
        $order = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        $notification = new \App\Notifications\OrderCompletedNotification($order);
        $mailMessage = $notification->toMail($this->buyer);

        // Check that the email contains the delivery link
        $this->assertStringContainsString('View Your Credentials', $mailMessage->actionText);
        $this->assertStringContainsString(route('orders.delivery', $order), $mailMessage->actionUrl);

        // Check that it mentions credentials are not in email
        $actionLines = implode(' ', $mailMessage->introLines);
        $this->assertStringContainsString('not sent via email', $actionLines);
    }

    /** @test */
    public function product_has_credentials_method_works_correctly()
    {
        $this->assertTrue($this->uniqueProduct->hasCredentials());

        $productWithoutCredentials = Product::factory()->create([
            'seller_id' => $this->sellerProfile->id,
            'delivery_credentials' => null,
        ]);

        $this->assertFalse($productWithoutCredentials->hasCredentials());

        $productWithIncompleteCredentials = Product::factory()->create([
            'seller_id' => $this->sellerProfile->id,
            'delivery_credentials' => [
                'username' => 'test@example.com',
                // missing password
            ],
        ]);

        $this->assertFalse($productWithIncompleteCredentials->hasCredentials());
    }

    /** @test */
    public function atomic_claiming_prevents_race_conditions()
    {
        $order1 = Order::factory()->create([
            'user_id' => $this->buyer->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $buyer2 = User::factory()->create();
        $order2 = Order::factory()->create([
            'user_id' => $buyer2->id,
            'payment_status' => 'completed',
            'paid_at' => now(),
        ]);

        $item1 = OrderItem::factory()->create([
            'order_id' => $order1->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        $item2 = OrderItem::factory()->create([
            'order_id' => $order2->id,
            'product_id' => $this->uniqueProduct->id,
            'seller_id' => $this->sellerProfile->id,
        ]);

        // Simulate concurrent claims using database transactions
        $results = [];

        DB::transaction(function () use ($item1, &$results) {
            $results[] = $item1->claimCredentials();
        });

        DB::transaction(function () use ($item2, &$results) {
            $results[] = $item2->claimCredentials();
        });

        // Only one should succeed
        $this->assertCount(2, $results);
        $this->assertTrue(in_array(true, $results));
        $this->assertTrue(in_array(false, $results));
        $this->assertNotEquals($results[0], $results[1]);
    }
}
