import AccountLayout from "@/components/AccountLayout";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Link } from "react-router-dom";
import { useToast } from "@/hooks/use-toast";
import { 
  CreditCard, 
  Plus,
  Trash2,
  CheckCircle2
} from "lucide-react";

const paymentMethods = [
  {
    id: 1,
    type: "visa",
    last4: "4242",
    expiry: "12/25",
    isDefault: true,
  },
  {
    id: 2,
    type: "mastercard",
    last4: "5555",
    expiry: "08/26",
    isDefault: false,
  },
];

const billingHistory = [
  {
    id: "INV-001",
    description: "Pro Plan - Monthly",
    amount: 29.00,
    date: "2024-01-20",
    status: "paid",
  },
  {
    id: "INV-002",
    description: "Pro Plan - Monthly",
    amount: 29.00,
    date: "2023-12-20",
    status: "paid",
  },
  {
    id: "INV-003",
    description: "Pro Plan - Monthly",
    amount: 29.00,
    date: "2023-11-20",
    status: "paid",
  },
];

const Billing = () => {
  const { toast } = useToast();

  const handleCancelSubscription = () => {
    toast({
      title: "Cancel Subscription",
      description: "Please contact support to cancel your subscription.",
      variant: "destructive",
    });
  };

  const handleAddCard = () => {
    toast({
      title: "Add Payment Method",
      description: "Payment method form will open here.",
    });
  };

  const handleSetDefault = (methodId: number) => {
    toast({
      title: "Default Payment Method",
      description: "Payment method set as default successfully.",
    });
  };

  const handleDeleteCard = (methodId: number) => {
    toast({
      title: "Delete Payment Method",
      description: "Payment method deleted successfully.",
    });
  };

  const handleDownloadInvoice = (invoiceId: string) => {
    toast({
      title: "Download Invoice",
      description: `Downloading invoice ${invoiceId}...`,
    });
  };

  return (
    <AccountLayout>
      <div className="space-y-6">
        {/* Header */}
        <div>
          <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
            Billing & Subscription
          </h1>
          <p className="text-foreground/60">Manage your subscription and payment methods</p>
        </div>

        {/* Current Plan */}
        <Card className="glass-card p-6 border border-primary/30">
          <div className="flex items-start justify-between mb-6">
            <div>
              <Badge className="badge-glow border-0 mb-3">Current Plan</Badge>
              <h2 className="text-2xl font-bold text-foreground mb-2">Pro Plan</h2>
              <p className="text-foreground/60">Unlimited listings, 3% transaction fee</p>
            </div>
            <div className="text-right">
              <p className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-1">
                $29
              </p>
              <p className="text-sm text-foreground/60">per month</p>
            </div>
          </div>

          <div className="flex items-center justify-between p-4 rounded-lg glass-card border border-border/30 mb-4">
            <div>
              <p className="font-semibold text-foreground mb-1">Next billing date</p>
              <p className="text-sm text-foreground/60">February 20, 2024</p>
            </div>
            <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20">
              <CheckCircle2 className="h-3 w-3 mr-1" />
              Active
            </Badge>
          </div>

          <div className="flex gap-3">
            <Button asChild variant="outline" className="glass-card border-border/50">
              <Link to="/pricing">
                Change Plan
              </Link>
            </Button>
            <Button 
              variant="ghost" 
              className="text-destructive hover:text-destructive"
              onClick={handleCancelSubscription}
            >
              Cancel Subscription
            </Button>
          </div>
        </Card>

        {/* Payment Methods */}
        <Card className="glass-card p-6">
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-xl font-bold text-foreground">Payment Methods</h2>
            <Button size="sm" className="btn-glow" onClick={handleAddCard}>
              <Plus className="h-4 w-4 mr-2" />
              Add Card
            </Button>
          </div>

          <div className="space-y-3">
            {paymentMethods.map((method) => (
              <div
                key={method.id}
                className="flex items-center justify-between p-4 rounded-lg glass-card border border-border/30"
              >
                <div className="flex items-center gap-4">
                  <div className="p-3 rounded-lg bg-primary/10 border border-primary/20">
                    <CreditCard className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <div className="flex items-center gap-2 mb-1">
                      <p className="font-semibold text-foreground capitalize">
                        {method.type} •••• {method.last4}
                      </p>
                      {method.isDefault && (
                        <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20 text-xs">
                          Default
                        </Badge>
                      )}
                    </div>
                    <p className="text-sm text-foreground/60">Expires {method.expiry}</p>
                  </div>
                </div>
                <div className="flex gap-2">
                  {!method.isDefault && (
                    <Button 
                      size="sm" 
                      variant="outline" 
                      className="glass-card border-border/50"
                      onClick={() => handleSetDefault(method.id)}
                    >
                      Set as Default
                    </Button>
                  )}
                  <Button
                    size="sm"
                    variant="ghost"
                    className="text-destructive hover:text-destructive"
                    onClick={() => handleDeleteCard(method.id)}
                  >
                    <Trash2 className="h-4 w-4" />
                  </Button>
                </div>
              </div>
            ))}
          </div>
        </Card>

        {/* Billing History */}
        <Card className="glass-card p-6">
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-xl font-bold text-foreground">Billing History</h2>
            <Button asChild variant="ghost" size="sm" className="text-primary hover:text-primary/80">
              <Link to="/account/billing">
                View All
              </Link>
            </Button>
          </div>

          <div className="space-y-3">
            {billingHistory.map((invoice) => (
              <div
                key={invoice.id}
                className="flex items-center justify-between p-4 rounded-lg glass-card border border-border/30"
              >
                <div>
                  <p className="font-semibold text-foreground mb-1">{invoice.description}</p>
                  <p className="text-sm text-foreground/60">
                    Invoice #{invoice.id} • {invoice.date}
                  </p>
                </div>
                <div className="flex items-center gap-4">
                  <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20">
                    {invoice.status}
                  </Badge>
                  <p className="text-lg font-bold text-foreground">
                    ${invoice.amount.toFixed(2)}
                  </p>
                  <Button 
                    size="sm" 
                    variant="outline" 
                    className="glass-card border-border/50"
                    onClick={() => handleDownloadInvoice(invoice.id)}
                  >
                    Download
                  </Button>
                </div>
              </div>
            ))}
          </div>
        </Card>
      </div>
    </AccountLayout>
  );
};

export default Billing;
