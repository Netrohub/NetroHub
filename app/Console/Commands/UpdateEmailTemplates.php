<?php

namespace App\Console\Commands;

use App\Models\EmailTemplate;
use Illuminate\Console\Command;

class UpdateEmailTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:update {--key=* : Specific template keys to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update email templates with latest versions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $templates = $this->getTemplateData();
        $keysToUpdate = $this->option('key');
        
        if (!empty($keysToUpdate)) {
            $templates = array_filter($templates, fn($t) => in_array($t['key'], $keysToUpdate));
        }

        if (empty($templates)) {
            $this->error('No templates to update.');
            return self::FAILURE;
        }

        $updated = 0;
        $created = 0;

        foreach ($templates as $templateData) {
            $existing = EmailTemplate::where('key', $templateData['key'])->first();

            if ($existing) {
                $existing->update($templateData);
                $this->info("Updated template: {$templateData['name']}");
                $updated++;
            } else {
                EmailTemplate::create($templateData);
                $this->info("Created template: {$templateData['name']}");
                $created++;
            }
        }

        $this->newLine();
        $this->info("Updated: {$updated} templates");
        $this->info("Created: {$created} templates");

        return self::SUCCESS;
    }

    /**
     * Get template data definitions.
     */
    protected function getTemplateData(): array
    {
        return [
            [
                'key' => 'verification_email',
                'name' => 'Email Verification',
                'description' => 'Email verification link',
                'subject' => 'Verify your email - NXO',
                'body' => '<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Verify your email - NXO</title>
</head>
<body style="background-color:#f5f7fa; font-family: Arial, sans-serif; padding: 0; margin: 0;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7fa; padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
          <tr>
            <td style="background-color:#0f172a; padding: 20px; text-align:center;">
              <h1 style="color:#ffffff; margin:0; font-size:24px;">NXO</h1>
            </td>
          </tr>
          <tr>
            <td style="padding: 40px; text-align: left; color: #1e293b;">
              <h2 style="margin-top: 0;">Verify your email address</h2>
              <p style="font-size: 16px; line-height: 1.5; color: #334155;">
                Hello 👋,<br><br>
                Thank you for signing up to <strong>NXO</strong>!  
                Please verify your email address to complete your registration and activate your account.
              </p>
              <p style="font-size: 16px; margin: 30px 0;">
                Click the button below to verify your email:
              </p>
              <p style="text-align: center;">
                <a href="{{verification_url}}" style="background-color:#2563eb; color:#ffffff; text-decoration:none; padding: 14px 30px; border-radius: 8px; font-size: 16px; display: inline-block;">
                  Verify My Email
                </a>
              </p>
              <p style="font-size: 14px; color: #64748b; margin-top: 40px;">
                If the button above doesn\'t work, copy and paste the link below into your browser:
              </p>
              <p style="word-break: break-all; color:#2563eb; font-size:14px;">
                {{verification_url}}
              </p>
              <p style="font-size: 14px; color: #94a3b8; margin-top: 30px;">
                If you didn\'t create an account with NXO, you can safely ignore this email.
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color:#f1f5f9; text-align:center; padding: 15px; font-size: 12px; color:#94a3b8;">
              © {{year}} NXO. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>',
                'available_variables' => ['verification_url', 'year'],
                'is_active' => true,
            ],
        ];
    }
}

