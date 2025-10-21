import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import Starfield from "@/components/Starfield";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import { 
  Search, 
  HelpCircle, 
  MessageCircle, 
  Mail, 
  Shield,
  ShoppingCart,
  CreditCard,
  Package,
  UserCircle,
  Settings
} from "lucide-react";

const categories = [
  { icon: ShoppingCart, name: "Getting Started", count: 12 },
  { icon: Package, name: "Orders & Delivery", count: 15 },
  { icon: CreditCard, name: "Payments & Refunds", count: 18 },
  { icon: UserCircle, name: "Account Management", count: 10 },
  { icon: Shield, name: "Security & Privacy", count: 14 },
  { icon: Settings, name: "Seller Tools", count: 20 },
];

const faqs = [
  {
    category: "Getting Started",
    questions: [
      {
        q: "How do I create an account?",
        a: "Click the 'Sign Up' button in the top right corner, enter your email and create a password. You'll receive a verification email to activate your account.",
      },
      {
        q: "Is it free to browse products?",
        a: "Yes, browsing and searching for products is completely free. You only pay when you make a purchase.",
      },
      {
        q: "How do I search for specific products?",
        a: "Use the search bar at the top of any page, or browse by category. You can also use filters to narrow down your results.",
      },
    ],
  },
  {
    category: "Orders & Delivery",
    questions: [
      {
        q: "How quickly will I receive my digital product?",
        a: "Most digital products are delivered instantly after payment confirmation. Check your email and account dashboard for delivery details.",
      },
      {
        q: "Can I track my order status?",
        a: "Yes, go to your Account Dashboard > Orders to see the status of all your purchases.",
      },
      {
        q: "What if I don't receive my product?",
        a: "If you haven't received your product within 24 hours, contact our support team. We offer a 7-day money-back guarantee.",
      },
    ],
  },
  {
    category: "Payments & Refunds",
    questions: [
      {
        q: "What payment methods do you accept?",
        a: "We accept all major credit cards, PayPal, and cryptocurrency payments through secure payment gateways.",
      },
      {
        q: "Is my payment information secure?",
        a: "Yes, we use industry-standard SSL encryption and never store your complete card details. All payments are processed through secure third-party providers.",
      },
      {
        q: "How do refunds work?",
        a: "If you're not satisfied with your purchase, request a refund within 7 days. Refunds are processed within 5-7 business days to your original payment method.",
      },
      {
        q: "Are there any hidden fees?",
        a: "No, the price you see is the price you pay. There are no hidden fees or charges.",
      },
    ],
  },
  {
    category: "Security & Privacy",
    questions: [
      {
        q: "How do you protect my personal information?",
        a: "We use advanced encryption and follow strict privacy policies. Your data is never shared with third parties without your consent.",
      },
      {
        q: "Are the products verified?",
        a: "Yes, all products and sellers go through a verification process before being listed on our marketplace.",
      },
      {
        q: "What if I suspect fraudulent activity?",
        a: "Report any suspicious activity immediately through our support channels. We take fraud very seriously and investigate all reports.",
      },
    ],
  },
  {
    category: "Seller Tools",
    questions: [
      {
        q: "How do I become a seller?",
        a: "Click 'Become a Seller' in the navigation menu, complete the registration form, and wait for account approval. Most approvals happen within 24-48 hours.",
      },
      {
        q: "What are the seller fees?",
        a: "Free accounts have a 5% transaction fee, Pro accounts 3%, and Elite accounts 1.5%. View our Pricing page for full details.",
      },
      {
        q: "When do I receive payment for my sales?",
        a: "Payments are processed within 24 hours of a successful sale and transferred to your wallet. You can withdraw funds anytime.",
      },
    ],
  },
];

const HelpCenter = () => {
  return (
    <div className="min-h-screen flex flex-col relative">
      <Starfield />
      <Navbar />
      
      <main className="flex-1 relative z-10">
        {/* Hero Section */}
        <section className="relative py-16 md:py-24 overflow-hidden border-b border-border/30">
          <div className="absolute inset-0 gradient-nebula opacity-60" />
          <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/20 rounded-full blur-[120px] animate-pulse" />
          
          <div className="container mx-auto px-4 relative z-10">
            <div className="text-center space-y-6 max-w-3xl mx-auto">
              <div className="inline-flex p-3 rounded-xl glass-card border border-primary/30 mb-4">
                <HelpCircle className="h-8 w-8 text-primary" />
              </div>
              
              <h1 className="text-4xl md:text-6xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                How Can We Help?
              </h1>
              <p className="text-lg text-foreground/60">
                Search our knowledge base or browse categories below
              </p>

              {/* Search Bar */}
              <div className="max-w-2xl mx-auto pt-4">
                <div className="relative">
                  <Search className="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-primary/70" />
                  <Input
                    type="search"
                    placeholder="Search for help articles, FAQs, or topics..."
                    className="w-full pl-12 pr-4 h-14 glass-card border-primary/30 focus:border-primary/50 text-base"
                  />
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Categories Grid */}
        <section className="py-16">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-black text-center mb-12 bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
              Browse by Category
            </h2>
            <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
              {categories.map((category) => {
                const Icon = category.icon;
                return (
                  <Card
                    key={category.name}
                    className="glass-card p-6 cursor-pointer hover:scale-[1.02] transition-all group"
                  >
                    <div className="flex items-start gap-4">
                      <div className="p-3 rounded-xl bg-primary/10 border border-primary/20 group-hover:border-primary/40 transition-colors">
                        <Icon className="h-6 w-6 text-primary" />
                      </div>
                      <div className="flex-1">
                        <h3 className="font-bold text-lg text-foreground mb-1 group-hover:text-primary transition-colors">
                          {category.name}
                        </h3>
                        <p className="text-sm text-foreground/60">
                          {category.count} articles
                        </p>
                      </div>
                    </div>
                  </Card>
                );
              })}
            </div>
          </div>
        </section>

        {/* FAQs Section */}
        <section className="py-16 relative">
          <div className="absolute inset-0 bg-gradient-cosmic opacity-30" />
          
          <div className="container mx-auto px-4 relative z-10">
            <div className="text-center mb-12">
              <h2 className="text-4xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-4">
                Frequently Asked Questions
              </h2>
              <p className="text-foreground/60 text-lg">
                Quick answers to common questions
              </p>
            </div>

            <div className="max-w-4xl mx-auto space-y-8">
              {faqs.map((section) => (
                <Card key={section.category} className="glass-card p-6">
                  <div className="flex items-center gap-3 mb-6">
                    <Badge className="badge-glow border-0">
                      {section.category}
                    </Badge>
                  </div>
                  <Accordion type="single" collapsible className="space-y-2">
                    {section.questions.map((faq, index) => (
                      <AccordionItem
                        key={index}
                        value={`${section.category}-${index}`}
                        className="glass-card border border-border/30 rounded-lg px-4"
                      >
                        <AccordionTrigger className="text-left font-semibold text-foreground hover:text-primary transition-colors">
                          {faq.q}
                        </AccordionTrigger>
                        <AccordionContent className="text-foreground/70 leading-relaxed">
                          {faq.a}
                        </AccordionContent>
                      </AccordionItem>
                    ))}
                  </Accordion>
                </Card>
              ))}
            </div>
          </div>
        </section>

        {/* Contact Section */}
        <section className="py-16 border-t border-border/30">
          <div className="container mx-auto px-4">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-4">
                Still Need Help?
              </h2>
              <p className="text-foreground/60 text-lg">
                Our support team is here to assist you
              </p>
            </div>

            <div className="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
              <Card className="glass-card p-8 text-center">
                <div className="inline-flex p-4 rounded-xl bg-primary/10 border border-primary/20 mb-4">
                  <MessageCircle className="h-8 w-8 text-primary" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-2">Live Chat</h3>
                <p className="text-foreground/60 mb-6">
                  Chat with our support team in real-time
                </p>
                <Button className="btn-glow">
                  Start Chat
                </Button>
              </Card>

              <Card className="glass-card p-8 text-center">
                <div className="inline-flex p-4 rounded-xl bg-accent/10 border border-accent/20 mb-4">
                  <Mail className="h-8 w-8 text-accent" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-2">Email Support</h3>
                <p className="text-foreground/60 mb-6">
                  Send us an email and we'll respond within 24 hours
                </p>
                <Button variant="outline" className="glass-card border-primary/30">
                  Send Email
                </Button>
              </Card>
            </div>
          </div>
        </section>
      </main>
      
      <Footer />
    </div>
  );
};

export default HelpCenter;