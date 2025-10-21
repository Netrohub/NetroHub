import { Link } from "react-router-dom";
import { Facebook, Twitter, Instagram, Mail, Shield, Zap, Award } from "lucide-react";
import { useLanguage } from "@/contexts/LanguageContext";

const Footer = () => {
  const { t } = useLanguage();
  
  return (
    <footer className="border-t border-border/50 glass-card mt-auto relative overflow-hidden">
      {/* Background glow */}
      <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-[120px]" />
      <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-accent/10 rounded-full blur-[120px]" />
      
      <div className="container mx-auto px-4 py-12 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          {/* Brand */}
          <div className="space-y-4">
            <div className="flex items-center gap-2">
              <div className="flex h-10 w-10 items-center justify-center rounded-lg gradient-primary shadow-lg">
                <span className="text-xl font-bold text-primary-foreground">N</span>
              </div>
              <span className="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                Nexo
              </span>
            </div>
            <p className="text-sm text-foreground/60 leading-relaxed">
              The premier digital gaming marketplace. Buy and sell with confidence.
            </p>
            <div className="flex gap-3">
              <a href="#" className="p-2 rounded-lg glass-card hover:bg-primary/10 text-muted-foreground hover:text-primary transition-all">
                <Facebook className="h-5 w-5" />
              </a>
              <a href="#" className="p-2 rounded-lg glass-card hover:bg-primary/10 text-muted-foreground hover:text-primary transition-all">
                <Twitter className="h-5 w-5" />
              </a>
              <a href="#" className="p-2 rounded-lg glass-card hover:bg-primary/10 text-muted-foreground hover:text-primary transition-all">
                <Instagram className="h-5 w-5" />
              </a>
              <a href="#" className="p-2 rounded-lg glass-card hover:bg-primary/10 text-muted-foreground hover:text-primary transition-all">
                <Mail className="h-5 w-5" />
              </a>
            </div>
          </div>

          {/* Marketplace */}
          <div>
            <h3 className="font-bold mb-4 text-foreground">{t('marketplace')}</h3>
            <ul className="space-y-3">
              <li>
                <Link to="/products" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('products')}
                </Link>
              </li>
              <li>
                <Link to="/games" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('games')}
                </Link>
              </li>
              <li>
                <Link to="/leaderboard" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('leaderboard')}
                </Link>
              </li>
              <li>
                <Link to="/pricing" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('pricing')}
                </Link>
              </li>
            </ul>
          </div>

          {/* Account */}
          <div>
            <h3 className="font-bold mb-4 text-foreground">{t('myAccount')}</h3>
            <ul className="space-y-3">
              <li>
                <Link to="/account" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('dashboard')}
                </Link>
              </li>
              <li>
                <Link to="/seller/dashboard" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('sellOnNexo')}
                </Link>
              </li>
              <li>
                <Link to="/account/orders" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('orders')}
                </Link>
              </li>
              <li>
                <Link to="/account/wallet" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('wallet')}
                </Link>
              </li>
            </ul>
          </div>

          {/* Legal */}
          <div>
            <h3 className="font-bold mb-4 text-foreground">{t('legalAndSupport')}</h3>
            <ul className="space-y-3">
              <li>
                <Link to="/terms" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('termsOfService')}
                </Link>
              </li>
              <li>
                <Link to="/privacy" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('privacyPolicy')}
                </Link>
              </li>
              <li>
                <Link to="/refund-policy" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('refundPolicy')}
                </Link>
              </li>
              <li>
                <Link to="/disputes" className="text-sm text-foreground/60 hover:text-primary transition-colors flex items-center gap-2 group">
                  <span className="w-1 h-1 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity" />
                  {t('disputeCenter')}
                </Link>
              </li>
            </ul>
          </div>
        </div>
        
        {/* Trust badges */}
        <div className="flex flex-wrap justify-center gap-8 py-8 border-t border-border/30">
          <div className="flex items-center gap-2 text-sm text-foreground/60">
            <Shield className="h-5 w-5 text-primary" />
            <span>{t('securePayments')}</span>
          </div>
          <div className="flex items-center gap-2 text-sm text-foreground/60">
            <Zap className="h-5 w-5 text-accent" />
            <span>{t('instantAccess')}</span>
          </div>
          <div className="flex items-center gap-2 text-sm text-foreground/60">
            <Award className="h-5 w-5 text-primary" />
            <span>{t('verifiedSellers')}</span>
          </div>
        </div>
        
        <div className="border-t border-border/30 pt-8 text-center">
          <p className="text-sm text-foreground/50">
            © 2024 Nexo Marketplace. {t('allRightsReserved')}. {t('builtForGamers')}
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
