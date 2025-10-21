import SellerLayout from "@/components/SellerLayout";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { 
  TrendingUp, 
  DollarSign, 
  Package, 
  ShoppingBag,
  Eye,
  Star,
  ArrowUpRight
} from "lucide-react";

const stats = [
  {
    label: "Total Revenue",
    value: "$12,450",
    change: "+23%",
    icon: DollarSign,
    color: "from-primary to-accent",
  },
  {
    label: "Active Listings",
    value: "24",
    change: "+3",
    icon: Package,
    color: "from-green-500 to-emerald-600",
  },
  {
    label: "Total Orders",
    value: "156",
    change: "+18%",
    icon: ShoppingBag,
    color: "from-blue-500 to-blue-700",
  },
  {
    label: "Seller Rating",
    value: "4.9",
    change: "★★★★★",
    icon: Star,
    color: "from-yellow-500 to-orange-600",
  },
];

const recentSales = [
  {
    product: "Steam Account - 200+ Games",
    buyer: "User#1234",
    amount: 449.99,
    date: "2 hours ago",
  },
  {
    product: "Instagram Account - 50K",
    buyer: "User#5678",
    amount: 299.99,
    date: "5 hours ago",
  },
  {
    product: "PlayStation Plus Premium",
    buyer: "User#9012",
    amount: 349.99,
    date: "1 day ago",
  },
];

const topProducts = [
  {
    name: "Steam Account - 500+ Games",
    sales: 45,
    revenue: "$22,450",
    views: 1250,
  },
  {
    name: "Instagram Account - 100K",
    sales: 32,
    revenue: "$17,600",
    views: 980,
  },
  {
    name: "Xbox Game Pass Ultimate",
    sales: 28,
    revenue: "$8,400",
    views: 756,
  },
];

const SellerDashboard = () => {
  return (
    <SellerLayout>
      <div className="space-y-6">
        {/* Header */}
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
              Seller Dashboard
            </h1>
            <p className="text-foreground/60">Monitor your sales and performance</p>
          </div>
          <Button className="btn-glow">
            <Package className="h-4 w-4 mr-2" />
            Create Product
          </Button>
        </div>

        {/* Stats Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
          {stats.map((stat) => {
            const Icon = stat.icon;
            return (
              <Card key={stat.label} className="glass-card p-6 relative overflow-hidden">
                <div className={`absolute top-0 right-0 w-24 h-24 bg-gradient-to-br ${stat.color} opacity-10 rounded-full blur-2xl`} />
                <div className="relative">
                  <div className="flex items-center justify-between mb-3">
                    <div className={`p-2 rounded-lg bg-gradient-to-br ${stat.color}`}>
                      <Icon className="h-5 w-5 text-white" />
                    </div>
                    <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20 text-xs">
                      {stat.change}
                    </Badge>
                  </div>
                  <p className="text-2xl font-black text-foreground mb-1">{stat.value}</p>
                  <p className="text-sm text-foreground/60">{stat.label}</p>
                </div>
              </Card>
            );
          })}
        </div>

        <div className="grid lg:grid-cols-2 gap-6">
          {/* Recent Sales */}
          <Card className="glass-card p-6">
            <div className="flex items-center justify-between mb-6">
              <h2 className="text-xl font-bold text-foreground">Recent Sales</h2>
              <Button variant="ghost" size="sm" className="text-primary hover:text-primary/80">
                View All
                <ArrowUpRight className="h-4 w-4 ml-2" />
              </Button>
            </div>

            <div className="space-y-4">
              {recentSales.map((sale, index) => (
                <div
                  key={index}
                  className="flex items-center justify-between p-4 rounded-lg glass-card border border-border/30"
                >
                  <div>
                    <p className="font-semibold text-foreground mb-1">{sale.product}</p>
                    <p className="text-sm text-foreground/60">
                      Sold to {sale.buyer} • {sale.date}
                    </p>
                  </div>
                  <p className="text-lg font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                    ${sale.amount.toFixed(2)}
                  </p>
                </div>
              ))}
            </div>
          </Card>

          {/* Top Products */}
          <Card className="glass-card p-6">
            <div className="flex items-center justify-between mb-6">
              <h2 className="text-xl font-bold text-foreground">Top Products</h2>
              <Button variant="ghost" size="sm" className="text-primary hover:text-primary/80">
                View All
                <ArrowUpRight className="h-4 w-4 ml-2" />
              </Button>
            </div>

            <div className="space-y-4">
              {topProducts.map((product, index) => (
                <div
                  key={index}
                  className="p-4 rounded-lg glass-card border border-border/30"
                >
                  <div className="flex items-center justify-between mb-3">
                    <p className="font-semibold text-foreground">{product.name}</p>
                    <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20">
                      #{index + 1}
                    </Badge>
                  </div>
                  <div className="grid grid-cols-3 gap-3 text-sm">
                    <div>
                      <p className="text-foreground/60 mb-1">Sales</p>
                      <p className="font-bold text-foreground">{product.sales}</p>
                    </div>
                    <div>
                      <p className="text-foreground/60 mb-1">Revenue</p>
                      <p className="font-bold text-primary">{product.revenue}</p>
                    </div>
                    <div>
                      <p className="text-foreground/60 mb-1">Views</p>
                      <p className="font-bold text-foreground flex items-center gap-1">
                        <Eye className="h-3 w-3" />
                        {product.views}
                      </p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </Card>
        </div>

        {/* Performance Chart Placeholder */}
        <Card className="glass-card p-6">
          <h2 className="text-xl font-bold text-foreground mb-6">Sales Performance</h2>
          <div className="h-64 flex items-center justify-center border border-border/30 rounded-lg glass-card">
            <div className="text-center">
              <TrendingUp className="h-12 w-12 text-primary mx-auto mb-3" />
              <p className="text-foreground/60">Sales chart will be displayed here</p>
            </div>
          </div>
        </Card>
      </div>
    </SellerLayout>
  );
};

export default SellerDashboard;
