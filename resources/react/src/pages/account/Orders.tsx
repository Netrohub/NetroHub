import AccountLayout from "@/components/AccountLayout";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import { 
  Package, 
  Search, 
  Eye,
  Download,
  MessageSquare,
  CheckCircle2,
  Clock,
  XCircle
} from "lucide-react";

const orders = [
  {
    id: "ORD-001",
    product: "Steam Account - 200+ Games Library",
    image: "https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=400&q=80",
    seller: "ProGamer_Elite",
    price: 449.99,
    status: "completed",
    date: "2024-01-20",
    deliveryDate: "2024-01-20",
  },
  {
    id: "ORD-002",
    product: "Instagram Account - 50K Followers",
    image: "https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&q=80",
    seller: "SocialKing",
    price: 299.99,
    status: "pending",
    date: "2024-01-19",
    deliveryDate: null,
  },
  {
    id: "ORD-003",
    product: "PlayStation Plus Premium - 2 Years",
    image: "https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=400&q=80",
    seller: "GameMaster_X",
    price: 349.99,
    status: "completed",
    date: "2024-01-18",
    deliveryDate: "2024-01-18",
  },
  {
    id: "ORD-004",
    product: "Epic Games - Fortnite Rare Skins",
    image: "https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&q=80",
    seller: "AccountKing",
    price: 799.99,
    status: "cancelled",
    date: "2024-01-15",
    deliveryDate: null,
  },
];

const getStatusIcon = (status: string) => {
  switch (status) {
    case "completed":
      return <CheckCircle2 className="h-4 w-4" />;
    case "pending":
      return <Clock className="h-4 w-4" />;
    case "cancelled":
      return <XCircle className="h-4 w-4" />;
    default:
      return <Package className="h-4 w-4" />;
  }
};

const getStatusColor = (status: string) => {
  switch (status) {
    case "completed":
      return "bg-primary/10 text-primary border-primary/20";
    case "pending":
      return "bg-yellow-500/10 text-yellow-500 border-yellow-500/20";
    case "cancelled":
      return "bg-red-500/10 text-red-500 border-red-500/20";
    default:
      return "bg-muted/50 text-foreground border-border";
  }
};

const Orders = () => {
  return (
    <AccountLayout>
      <div className="space-y-6">
        {/* Header */}
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
              My Orders
            </h1>
            <p className="text-foreground/60">View and manage your purchase history</p>
          </div>
        </div>

        {/* Search and Filter */}
        <Card className="glass-card p-4">
          <div className="flex gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
              <Input
                placeholder="Search orders..."
                className="pl-10 glass-card border-border/50"
              />
            </div>
            <Button variant="outline" className="glass-card border-border/50">
              All Orders
            </Button>
            <Button variant="outline" className="glass-card border-border/50">
              Completed
            </Button>
            <Button variant="outline" className="glass-card border-border/50">
              Pending
            </Button>
          </div>
        </Card>

        {/* Orders List */}
        <div className="space-y-4">
          {orders.map((order) => (
            <Card key={order.id} className="glass-card p-6">
              <div className="flex gap-6">
                {/* Product Image */}
                <div className="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden border border-border/50">
                  <img
                    src={order.image}
                    alt={order.product}
                    className="w-full h-full object-cover"
                  />
                </div>

                {/* Order Details */}
                <div className="flex-1 min-w-0">
                  <div className="flex items-start justify-between gap-4 mb-3">
                    <div>
                      <div className="flex items-center gap-3 mb-2">
                        <h3 className="font-bold text-lg text-foreground line-clamp-1">
                          {order.product}
                        </h3>
                        <Badge variant="secondary" className={getStatusColor(order.status)}>
                          {getStatusIcon(order.status)}
                          <span className="ml-1 capitalize">{order.status}</span>
                        </Badge>
                      </div>
                      <p className="text-sm text-foreground/60 mb-1">
                        Order #{order.id} • Seller: {order.seller}
                      </p>
                      <p className="text-sm text-foreground/60">
                        Ordered: {order.date}
                        {order.deliveryDate && ` • Delivered: ${order.deliveryDate}`}
                      </p>
                    </div>
                    <p className="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent whitespace-nowrap">
                      ${order.price.toFixed(2)}
                    </p>
                  </div>

                  {/* Actions */}
                  <div className="flex flex-wrap gap-2">
                    {order.status === "completed" && (
                      <>
                        <Button size="sm" className="btn-glow">
                          <Eye className="h-4 w-4 mr-2" />
                          View Details
                        </Button>
                        <Button size="sm" variant="outline" className="glass-card border-border/50">
                          <Download className="h-4 w-4 mr-2" />
                          Download
                        </Button>
                      </>
                    )}
                    {order.status === "pending" && (
                      <Button size="sm" variant="outline" className="glass-card border-border/50">
                        <Clock className="h-4 w-4 mr-2" />
                        Track Order
                      </Button>
                    )}
                    <Button size="sm" variant="outline" className="glass-card border-border/50">
                      <MessageSquare className="h-4 w-4 mr-2" />
                      Contact Seller
                    </Button>
                    {order.status === "completed" && (
                      <Button size="sm" variant="outline" className="glass-card border-border/50">
                        Leave Review
                      </Button>
                    )}
                  </div>
                </div>
              </div>
            </Card>
          ))}
        </div>

        {/* Empty State Alternative */}
        {orders.length === 0 && (
          <Card className="glass-card p-12 text-center">
            <div className="inline-flex p-4 rounded-xl bg-primary/10 border border-primary/20 mb-4">
              <Package className="h-8 w-8 text-primary" />
            </div>
            <h3 className="text-xl font-bold text-foreground mb-2">No orders yet</h3>
            <p className="text-foreground/60 mb-6">
              Start shopping to see your orders here
            </p>
            <Button className="btn-glow">
              Browse Products
            </Button>
          </Card>
        )}
      </div>
    </AccountLayout>
  );
};

export default Orders;
