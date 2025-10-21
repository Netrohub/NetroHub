import { useState } from "react";
import AccountLayout from "@/components/AccountLayout";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Progress } from "@/components/ui/progress";
import { useToast } from "@/hooks/use-toast";
import { Link } from "react-router-dom";
import { 
  CheckCircle2,
  Circle,
  Mail,
  Smartphone,
  ShieldCheck,
  AlertCircle,
  ExternalLink,
  FileText
} from "lucide-react";

interface VerificationStatus {
  email: boolean;
  phone: boolean;
  identity: boolean;
}

const KYC = () => {
  const { toast } = useToast();
  const [verificationStatus, setVerificationStatus] = useState<VerificationStatus>({
    email: true, // Simulating verified email
    phone: false,
    identity: false,
  });

  const handleVerifyEmail = () => {
    toast({
      title: "Verification Email Sent",
      description: "Please check your inbox and click the verification link.",
    });
  };

  const handleStartPersonaVerification = () => {
    toast({
      title: "Opening Persona Verification",
      description: "You'll be redirected to Persona to complete identity verification.",
    });
    // In production, this would redirect to Persona's verification flow
    // window.open('https://withpersona.com/verify?inquiry-template-id=YOUR_TEMPLATE_ID', '_blank');
    
    // Simulate verification completion after 3 seconds (for demo)
    setTimeout(() => {
      setVerificationStatus(prev => ({ ...prev, identity: true }));
      toast({
        title: "Identity Verified!",
        description: "Your identity has been successfully verified by Persona.",
      });
    }, 3000);
  };

  const verifiedSteps = Object.values(verificationStatus).filter(Boolean).length;
  const totalSteps = 3;
  const progress = (verifiedSteps / totalSteps) * 100;
  const isFullyVerified = verifiedSteps === totalSteps;

  return (
    <AccountLayout>
      <div className="space-y-6">
        {/* Header */}
        <div>
          <h1 className="text-3xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
            KYC Verification
          </h1>
          <p className="text-foreground/60">Complete your account verification to unlock all features</p>
        </div>

        {/* Overall Progress */}
        <Card className="glass-card p-6 border border-primary/30">
          <div className="flex items-start justify-between mb-6">
            <div className="flex-1">
              <div className="flex items-center gap-3 mb-2">
                <ShieldCheck className={`h-8 w-8 ${isFullyVerified ? 'text-primary' : 'text-foreground/50'}`} />
                <div>
                  <h2 className="text-2xl font-bold text-foreground">Verification Progress</h2>
                  <p className="text-sm text-foreground/60">
                    {verifiedSteps} of {totalSteps} steps completed
                  </p>
                </div>
              </div>
              <Progress value={progress} className="h-3 mt-4" />
            </div>
            {isFullyVerified && (
              <Badge className="badge-glow border-0">
                <CheckCircle2 className="h-4 w-4 mr-1" />
                Fully Verified
              </Badge>
            )}
          </div>
          
          {!isFullyVerified && (
            <div className="flex items-start gap-3 p-4 rounded-lg bg-primary/5 border border-primary/20">
              <AlertCircle className="h-5 w-5 text-primary shrink-0 mt-0.5" />
              <div>
                <p className="text-sm font-semibold text-foreground mb-1">Why verify your account?</p>
                <ul className="text-sm text-foreground/70 space-y-1">
                  <li>• Unlock higher transaction limits</li>
                  <li>• Build trust with buyers and sellers</li>
                  <li>• Access premium features</li>
                  <li>• Ensure account security</li>
                </ul>
              </div>
            </div>
          )}
        </Card>

        {/* Verification Steps */}
        <div className="space-y-4">
          {/* Step 1: Email Verification */}
          <Card className={`glass-card p-6 border ${verificationStatus.email ? 'border-primary/30' : 'border-border/30'}`}>
            <div className="flex items-start gap-4">
              <div className={`p-3 rounded-full ${verificationStatus.email ? 'bg-primary/20 border-2 border-primary' : 'bg-muted border-2 border-border/30'}`}>
                {verificationStatus.email ? (
                  <CheckCircle2 className="h-6 w-6 text-primary" />
                ) : (
                  <Circle className="h-6 w-6 text-foreground/50" />
                )}
              </div>
              
              <div className="flex-1">
                <div className="flex items-center justify-between mb-2">
                  <div>
                    <h3 className="text-lg font-bold text-foreground flex items-center gap-2">
                      Step 1: Email Verification
                      {verificationStatus.email && (
                        <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20 text-xs">
                          Verified
                        </Badge>
                      )}
                    </h3>
                    <p className="text-sm text-foreground/60 mt-1">
                      Verify your email address to secure your account
                    </p>
                  </div>
                </div>

                <div className="flex items-center gap-4 mt-4">
                  <Mail className="h-5 w-5 text-primary/70" />
                  <div className="flex-1">
                    <p className="text-sm font-medium text-foreground">john.doe@example.com</p>
                    <p className="text-xs text-foreground/60">
                      {verificationStatus.email ? 'Email verified ✓' : 'Email not verified'}
                    </p>
                  </div>
                  {!verificationStatus.email && (
                    <Button size="sm" variant="outline" className="glass-card border-border/50" onClick={handleVerifyEmail}>
                      Verify Email
                    </Button>
                  )}
                </div>
              </div>
            </div>
          </Card>

          {/* Step 2: Phone Verification */}
          <Card className={`glass-card p-6 border ${verificationStatus.phone ? 'border-primary/30' : 'border-border/30'}`}>
            <div className="flex items-start gap-4">
              <div className={`p-3 rounded-full ${verificationStatus.phone ? 'bg-primary/20 border-2 border-primary' : 'bg-muted border-2 border-border/30'}`}>
                {verificationStatus.phone ? (
                  <CheckCircle2 className="h-6 w-6 text-primary" />
                ) : (
                  <Circle className="h-6 w-6 text-foreground/50" />
                )}
              </div>
              
              <div className="flex-1">
                <div className="flex items-center justify-between mb-2">
                  <div>
                    <h3 className="text-lg font-bold text-foreground flex items-center gap-2">
                      Step 2: Phone Verification
                      {verificationStatus.phone && (
                        <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20 text-xs">
                          Verified
                        </Badge>
                      )}
                    </h3>
                    <p className="text-sm text-foreground/60 mt-1">
                      Add and verify your phone number for account security
                    </p>
                  </div>
                </div>

                <div className="flex items-center gap-4 mt-4">
                  <Smartphone className="h-5 w-5 text-primary/70" />
                  <div className="flex-1">
                    <p className="text-sm font-medium text-foreground">
                      {verificationStatus.phone ? '+1 (555) 123-4567' : 'No phone number added'}
                    </p>
                    <p className="text-xs text-foreground/60">
                      {verificationStatus.phone ? 'Phone verified ✓' : 'Phone not verified'}
                    </p>
                  </div>
                  <Button asChild size="sm" variant="outline" className="glass-card border-border/50">
                    <Link to="/account/phone-verification">
                      {verificationStatus.phone ? 'Manage Phone' : 'Verify Phone'}
                    </Link>
                  </Button>
                </div>
              </div>
            </div>
          </Card>

          {/* Step 3: Identity Verification (Persona) */}
          <Card className={`glass-card p-6 border ${verificationStatus.identity ? 'border-primary/30' : 'border-border/30'}`}>
            <div className="flex items-start gap-4">
              <div className={`p-3 rounded-full ${verificationStatus.identity ? 'bg-primary/20 border-2 border-primary' : 'bg-muted border-2 border-border/30'}`}>
                {verificationStatus.identity ? (
                  <CheckCircle2 className="h-6 w-6 text-primary" />
                ) : (
                  <Circle className="h-6 w-6 text-foreground/50" />
                )}
              </div>
              
              <div className="flex-1">
                <div className="flex items-center justify-between mb-2">
                  <div>
                    <h3 className="text-lg font-bold text-foreground flex items-center gap-2">
                      Step 3: Identity Verification
                      {verificationStatus.identity && (
                        <Badge variant="secondary" className="bg-primary/10 text-primary border-primary/20 text-xs">
                          Verified by Persona
                        </Badge>
                      )}
                    </h3>
                    <p className="text-sm text-foreground/60 mt-1">
                      Complete identity verification through our trusted partner
                    </p>
                  </div>
                </div>

                {!verificationStatus.identity && (
                  <div className="mt-4 p-4 rounded-lg bg-muted/30 border border-border/30">
                    <div className="flex items-center gap-3 mb-3">
                      <FileText className="h-5 w-5 text-primary/70" />
                      <p className="text-sm font-semibold text-foreground">What you'll need:</p>
                    </div>
                    <ul className="text-sm text-foreground/70 space-y-2 ml-8">
                      <li>• Government-issued ID (Passport, Driver's License, or National ID)</li>
                      <li>• Clear selfie photo for verification</li>
                      <li>• Proof of address (optional, for enhanced verification)</li>
                      <li>• 5-10 minutes to complete the process</li>
                    </ul>
                  </div>
                )}

                <div className="flex items-center gap-4 mt-4">
                  {verificationStatus.identity ? (
                    <>
                      <div className="flex items-center gap-3 flex-1">
                        <div className="p-2 rounded-lg bg-primary/10 border border-primary/20">
                          <ShieldCheck className="h-5 w-5 text-primary" />
                        </div>
                        <div>
                          <p className="text-sm font-medium text-foreground">Identity Verified</p>
                          <p className="text-xs text-foreground/60 flex items-center gap-1">
                            Verified by 
                            <span className="font-semibold text-primary">Persona</span>
                          </p>
                        </div>
                      </div>
                      <Badge className="bg-gradient-to-r from-primary to-accent text-white border-0">
                        <CheckCircle2 className="h-3 w-3 mr-1" />
                        Verified
                      </Badge>
                    </>
                  ) : (
                    <>
                      <Button 
                        className="btn-glow" 
                        onClick={handleStartPersonaVerification}
                        disabled={!verificationStatus.email || !verificationStatus.phone}
                      >
                        <ShieldCheck className="h-4 w-4 mr-2" />
                        Start Identity Verification
                        <ExternalLink className="h-4 w-4 ml-2" />
                      </Button>
                      <div className="flex items-center gap-2 text-xs text-foreground/50">
                        <span>Powered by</span>
                        <span className="font-bold text-foreground/70">Persona</span>
                      </div>
                    </>
                  )}
                </div>

                {!verificationStatus.email || !verificationStatus.phone ? (
                  <p className="text-xs text-foreground/50 mt-3 flex items-center gap-1">
                    <AlertCircle className="h-3 w-3" />
                    Complete email and phone verification first
                  </p>
                ) : null}
              </div>
            </div>
          </Card>
        </div>

        {/* Trust & Security Info */}
        <Card className="glass-card p-6 border border-border/30">
          <div className="flex items-start gap-4">
            <div className="p-3 rounded-lg bg-primary/10 border border-primary/20">
              <ShieldCheck className="h-6 w-6 text-primary" />
            </div>
            <div>
              <h3 className="text-lg font-bold text-foreground mb-2">Your Privacy & Security</h3>
              <div className="space-y-2 text-sm text-foreground/70">
                <p>✓ All data is encrypted and stored securely</p>
                <p>✓ Identity verification handled by Persona, a trusted industry leader</p>
                <p>✓ We never share your personal information with third parties</p>
                <p>✓ Verification typically takes 5-10 minutes</p>
              </div>
            </div>
          </div>
        </Card>
      </div>
    </AccountLayout>
  );
};

export default KYC;
