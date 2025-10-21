import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import Starfield from "@/components/Starfield";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card } from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { Link } from "react-router-dom";
import { Mail, Lock, User, ArrowRight } from "lucide-react";
import { useLanguage } from "@/contexts/LanguageContext";

const Register = () => {
  const { t } = useLanguage();
  
  return (
    <div className="min-h-screen flex flex-col relative">
      <Starfield />
      <Navbar />
      
      <main className="flex-1 relative z-10 flex items-center justify-center py-16">
        <div className="container mx-auto px-4">
          <div className="max-w-md mx-auto">
            <Card className="glass-card p-8">
              {/* Header */}
              <div className="text-center mb-8">
                <div className="inline-flex p-3 rounded-xl gradient-primary mb-4">
                  <User className="h-6 w-6 text-white" />
                </div>
                <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
                  {t('createAccount')}
                </h1>
                <p className="text-foreground/60">
                  {t('joinNexoMarketplace')}
                </p>
              </div>

              {/* Register Form */}
              <form className="space-y-5">
                {/* Username */}
                <div className="space-y-2">
                  <Label htmlFor="username" className="text-foreground">
                    {t('username')}
                  </Label>
                  <div className="relative">
                    <User className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
                    <Input
                      id="username"
                      type="text"
                      placeholder={t('chooseUsername')}
                      className="pl-10 glass-card border-border/50 focus:border-primary/50"
                    />
                  </div>
                </div>

                {/* Email */}
                <div className="space-y-2">
                  <Label htmlFor="email" className="text-foreground">
                    {t('emailAddress')}
                  </Label>
                  <div className="relative">
                    <Mail className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
                    <Input
                      id="email"
                      type="email"
                      placeholder="your@email.com"
                      className="pl-10 glass-card border-border/50 focus:border-primary/50"
                    />
                  </div>
                </div>

                {/* Password */}
                <div className="space-y-2">
                  <Label htmlFor="password" className="text-foreground">
                    {t('password')}
                  </Label>
                  <div className="relative">
                    <Lock className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
                    <Input
                      id="password"
                      type="password"
                      placeholder={t('createStrongPassword')}
                      className="pl-10 glass-card border-border/50 focus:border-primary/50"
                    />
                  </div>
                  <p className="text-xs text-foreground/50">
                    {t('passwordRequirements')}
                  </p>
                </div>

                {/* Confirm Password */}
                <div className="space-y-2">
                  <Label htmlFor="confirm-password" className="text-foreground">
                    {t('confirmPassword')}
                  </Label>
                  <div className="relative">
                    <Lock className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-primary/70" />
                    <Input
                      id="confirm-password"
                      type="password"
                      placeholder={t('confirmYourPassword')}
                      className="pl-10 glass-card border-border/50 focus:border-primary/50"
                    />
                  </div>
                </div>

                {/* Terms & Conditions */}
                <div className="flex items-start space-x-2">
                  <Checkbox id="terms" className="mt-1" />
                  <label
                    htmlFor="terms"
                    className="text-sm text-foreground/70 cursor-pointer leading-relaxed"
                  >
                    {t('iAgreeToThe')}{" "}
                    <Link to="/terms" className="text-primary hover:text-primary/80">
                      {t('termsOfService')}
                    </Link>{" "}
                    {t('and')}{" "}
                    <Link to="/privacy" className="text-primary hover:text-primary/80">
                      {t('privacyPolicy')}
                    </Link>
                  </label>
                </div>

                {/* Turnstile CAPTCHA Placeholder */}
                <div className="p-4 glass-card border border-border/50 rounded-lg text-center">
                  <p className="text-sm text-foreground/60">
                    {t('cloudflareTurnstile')}
                  </p>
                </div>

                {/* Submit Button */}
                <Button type="submit" className="w-full btn-glow" size="lg">
                  {t('createAccount')}
                  <ArrowRight className="h-4 w-4 ml-2" />
                </Button>
              </form>

              {/* Sign In Link */}
              <p className="text-center text-sm text-foreground/60 mt-6">
                {t('alreadyHaveAccount')}{" "}
                <Link
                  to="/login"
                  className="text-primary hover:text-primary/80 font-semibold transition-colors"
                >
                  {t('signIn')}
                </Link>
              </p>
            </Card>
          </div>
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export default Register;
