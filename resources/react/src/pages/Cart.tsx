import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import Starfield from "@/components/Starfield";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import { Link } from "react-router-dom";
import { Trash2, Plus, Minus, ShoppingBag, ArrowRight, Tag } from "lucide-react";
import { useLanguage } from "@/contexts/LanguageContext";

const cartItems = [
  {
    id: 1,
    name: "Steam Account - 200+ Games",
    seller: "ProGamer_Elite",
    price: 449.99,
    quantity: 1,
    image: "https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=400&q=80",
    category: "Gaming",
  },
  {
    id: 2,
    name: "Instagram Account - 50K Followers",
    seller: "SocialKing",
    price: 299.99,
    quantity: 1,
    image: "https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&q=80",
    category: "Social Media",
  },
];

const Cart = () => {
  const { t } = useLanguage();
  const subtotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
  const serviceFee = subtotal * 0.03; // 3% service fee
  const total = subtotal + serviceFee;

  return (
    <div className="min-h-screen flex flex-col relative">
      <Starfield />
      <Navbar />
      
      <main className="flex-1 relative z-10 py-16">
        <div className="container mx-auto px-4">
          <div className="mb-8">
            <h1 className="text-4xl md:text-5xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
              {t('shoppingCart')}
            </h1>
            <p className="text-foreground/60">{cartItems.length} {t('itemsInCart')}</p>
          </div>

          <div className="grid lg:grid-cols-3 gap-8">
            {/* Cart Items */}
            <div className="lg:col-span-2 space-y-4">
              {cartItems.map((item) => (
                <Card key={item.id} className="glass-card p-6">
                  <div className="flex gap-4">
                    {/* Image */}
                    <div className="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden border border-border/50">
                      <img
                        src={item.image}
                        alt={item.name}
                        className="w-full h-full object-cover"
                      />
                    </div>

                    {/* Details */}
                    <div className="flex-1 min-w-0">
                      <div className="flex items-start justify-between gap-4 mb-2">
                        <div>
                          <h3 className="font-bold text-lg text-foreground mb-1 line-clamp-1">
                            {item.name}
                          </h3>
                          <p className="text-sm text-foreground/60">
                            by {item.seller}
                          </p>
                          <Badge variant="secondary" className="mt-2 bg-primary/10 text-primary border-primary/20">
                            {item.category}
                          </Badge>
                        </div>
                        <Button
                          size="icon"
                          variant="ghost"
                          className="text-destructive hover:text-destructive hover:bg-destructive/10"
                        >
                          <Trash2 className="h-4 w-4" />
                        </Button>
                      </div>

                      {/* Quantity and Price */}
                      <div className="flex items-center justify-between mt-4">
                        <div className="flex items-center gap-3">
                          <Button
                            size="icon"
                            variant="outline"
                            className="h-8 w-8 glass-card border-border/50"
                          >
                            <Minus className="h-3 w-3" />
                          </Button>
                          <span className="text-sm font-semibold w-8 text-center">
                            {item.quantity}
                          </span>
                          <Button
                            size="icon"
                            variant="outline"
                            className="h-8 w-8 glass-card border-border/50"
                          >
                            <Plus className="h-3 w-3" />
                          </Button>
                        </div>
                        <p className="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                          ${item.price.toFixed(2)}
                        </p>
                      </div>
                    </div>
                  </div>
                </Card>
              ))}

              {/* Coupon Code */}
              <Card className="glass-card p-6">
                <div className="flex gap-3">
                  <div className="relative flex-1">
                    <Tag className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
                    <Input
                      placeholder={t('enterCouponCode')}
                      className="pl-10 glass-card border-border/50"
                    />
                  </div>
                  <Button variant="outline" className="glass-card border-primary/30 hover:border-primary/50">
                    {t('apply')}
                  </Button>
                </div>
              </Card>
            </div>

            {/* Order Summary */}
            <div className="lg:col-span-1">
              <Card className="glass-card p-6 sticky top-4">
                <h2 className="text-xl font-bold text-foreground mb-6">{t('orderSummary')}</h2>
                
                <div className="space-y-4 mb-6">
                  <div className="flex justify-between text-foreground/70">
                    <span>{t('subtotal')}</span>
                    <span className="font-semibold">${subtotal.toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between text-foreground/70">
                    <span>{t('serviceFee')} (3%)</span>
                    <span className="font-semibold">${serviceFee.toFixed(2)}</span>
                  </div>
                  <div className="border-t border-border/30 pt-4">
                    <div className="flex justify-between items-center">
                      <span className="text-lg font-bold text-foreground">{t('total')}</span>
                      <span className="text-2xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                        ${total.toFixed(2)}
                      </span>
                    </div>
                  </div>
                </div>

                <Link to="/checkout">
                  <Button className="w-full btn-glow mb-3" size="lg">
                    {t('proceedToCheckout')}
                    <ArrowRight className="h-4 w-4 ml-2" />
                  </Button>
                </Link>

                <Link to="/products">
                  <Button variant="outline" className="w-full glass-card border-border/50" size="lg">
                    <ShoppingBag className="h-4 w-4 mr-2" />
                    {t('continueShopping')}
                  </Button>
                </Link>

                {/* Trust Badges */}
                <div className="mt-6 pt-6 border-t border-border/30 space-y-3 text-sm text-foreground/60">
                  <div className="flex items-center gap-2">
                    <div className="w-2 h-2 rounded-full bg-primary" />
                    <span>{t('secureCheckout')}</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="w-2 h-2 rounded-full bg-primary" />
                    <span>{t('instantDelivery')}</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="w-2 h-2 rounded-full bg-primary" />
                    <span>{t('moneyBackGuarantee')}</span>
                  </div>
                </div>
              </Card>
            </div>
          </div>
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export default Cart;
