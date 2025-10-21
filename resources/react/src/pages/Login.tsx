import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import Starfield from "@/components/Starfield";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card } from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";
import { Link } from "react-router-dom";
import { Mail, Lock, ArrowRight, Smartphone } from "lucide-react";
import { useLanguage } from "@/contexts/LanguageContext";

const Login = () => {
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
                  <Lock className="h-6 w-6 text-white" />
                </div>
                <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
                  {t('welcomeBack')}
                </h1>
                <p className="text-foreground/60">
                  {t('signInToAccount')}
                </p>
              </div>

              {/* Login Form */}
              <form className="space-y-5">
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
                      placeholder="••••••••"
                      className="pl-10 glass-card border-border/50 focus:border-primary/50"
                    />
                  </div>
                </div>

                {/* Remember & Forgot */}
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-2">
                    <Checkbox id="remember" />
                    <label
                      htmlFor="remember"
                      className="text-sm text-foreground/70 cursor-pointer"
                    >
                      {t('rememberMe')}
                    </label>
                  </div>
                  <Link
                    to="/forgot-password"
                    className="text-sm text-primary hover:text-primary/80 transition-colors"
                  >
                    {t('forgotPassword')}
                  </Link>
                </div>

                {/* Turnstile CAPTCHA Placeholder */}
                <div className="p-4 glass-card border border-border/50 rounded-lg text-center">
                  <p className="text-sm text-foreground/60">
                    🔒 Cloudflare Turnstile CAPTCHA
                  </p>
                </div>

                {/* Submit Button */}
                <Button type="submit" className="w-full btn-glow" size="lg">
                  {t('signIn')}
                  <ArrowRight className="h-4 w-4 ml-2" />
                </Button>
              </form>

              {/* Divider */}
              <div className="relative my-6">
                <div className="absolute inset-0 flex items-center">
                  <div className="w-full border-t border-border/50" />
                </div>
                <div className="relative flex justify-center text-sm">
                  <span className="px-4 bg-card text-foreground/60">{t('orContinueWith')}</span>
                </div>
              </div>

              {/* Alternative Login */}
              <div className="space-y-3">
                <Button
                  type="button"
                  variant="outline"
                  className="w-full glass-card border-border/50 hover:border-primary/50"
                  size="lg"
                >
                  <Smartphone className="h-5 w-5 mr-2" />
                  {t('phoneNumber')}
                </Button>
              </div>

              {/* Sign Up Link */}
              <p className="text-center text-sm text-foreground/60 mt-6">
                {t('dontHaveAccount')}{" "}
                <Link
                  to="/register"
                  className="text-primary hover:text-primary/80 font-semibold transition-colors"
                >
                  {t('createAccount')}
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

export default Login;
