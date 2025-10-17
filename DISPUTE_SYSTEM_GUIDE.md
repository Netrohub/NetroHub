# Dispute System Guide

## Overview
A complete dispute resolution system has been implemented for your marketplace, allowing buyers to raise disputes about orders, sellers to respond, and moderators to mediate and resolve conflicts fairly.

## Features

### 🎯 Core Features
- **Buyer Dispute Creation**: Buyers can create disputes for orders with issues
- **Real-time Messaging**: Chat-like interface for communication between all parties
- **Evidence Upload**: Support for image and PDF evidence
- **Moderator Dashboard**: Comprehensive admin interface for dispute management
- **Internal Notes**: Private notes visible only to moderators
- **Status Tracking**: Clear status indicators (Open, In Review, Resolved)
- **Email Notifications**: Automated notifications for all parties
- **Resolution System**: Fair resolution with refund or seller uphold options

### 🎨 User Interface
- Beautiful, modern design matching your existing Stellar theme
- Dark mode with purple accents
- Responsive design for mobile and desktop
- Real-time status badges
- File attachment previews
- Conversation thread view

## Database Structure

### Tables Created
1. **disputes** - Main dispute records
2. **dispute_messages** - Conversation messages between parties

### Dispute Statuses
- `open` - Newly created, awaiting moderator review
- `in_review` - Being actively reviewed by moderators
- `resolved_refund` - Resolved in favor of buyer (refund approved)
- `resolved_upheld` - Resolved in favor of seller

## Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

This will create:
- `disputes` table (already exists)
- `dispute_messages` table (new)

### 2. Configure Permissions
The system uses your existing role system. Ensure moderators have appropriate roles:
- SuperAdmin
- Moderator
- Finance
- Support
- Content

### 3. Storage Configuration
Ensure the storage is properly linked for file uploads:
```bash
php artisan storage:link
```

## User Workflows

### For Buyers

#### Creating a Dispute
1. Navigate to **Account** → **Orders**
2. Find the problematic order
3. Click **Create Dispute** button
4. Fill out the form:
   - Select order (pre-filled if coming from order page)
   - Choose reason (dropdown with common issues)
   - Provide detailed description (min 20 characters)
   - Upload evidence (optional: images/PDFs up to 5MB)
5. Submit the dispute

#### Managing Disputes
- View all disputes at `/disputes`
- Click on any dispute to see details and communicate
- Send messages to seller and moderators
- Upload additional evidence via messages
- Receive email notifications for responses

### For Sellers

#### Responding to Disputes
1. Receive email notification when dispute is created
2. Access dispute from `/disputes` or notification link
3. View buyer's complaint and evidence
4. Respond with your explanation
5. Upload counter-evidence if needed
6. Communicate with buyer to resolve amicably

### For Moderators/Admins

#### Accessing Dispute Dashboard
Navigate to: `/admin/disputes`

#### Dashboard Features
- **Stats Overview**: See total, open, in review, and resolved disputes
- **Filter by Status**: Quick filtering options
- **Detailed Table**: All disputes with key information
- **Search & Sort**: Find specific disputes easily

#### Reviewing a Dispute
1. Click "Review" on any dispute
2. Read the full dispute details and evidence
3. Review conversation thread between parties
4. See both public messages and internal notes

#### Taking Action
1. **Take Into Review**: Mark dispute as being actively reviewed
2. **Add Public Messages**: Communicate with both parties
3. **Add Internal Notes**: Private notes for moderator reference only
4. **Resolve Dispute**:
   - Choose resolution: Refund Buyer or Uphold Seller
   - Provide resolution notes (visible to all)
   - Submit resolution

#### Best Practices for Moderators
- Review all evidence thoroughly
- Ask clarifying questions via public messages
- Use internal notes to document your decision process
- Be fair and impartial
- Explain decisions clearly in resolution notes
- Respond within 24-48 hours

## Routes Reference

### Public Routes (Authenticated Users)
```php
GET  /disputes                 - List all user's disputes
GET  /disputes/create         - Create new dispute form
POST /disputes                 - Store new dispute
GET  /disputes/{dispute}      - View dispute details
POST /disputes/{dispute}/message - Add message to dispute
```

### Admin Routes (Moderators Only)
```php
GET  /admin/disputes                           - Dispute dashboard
GET  /admin/disputes/{dispute}                - Review dispute
POST /admin/disputes/{dispute}/take-action    - Mark as in review
POST /admin/disputes/{dispute}/message        - Add public message
POST /admin/disputes/{dispute}/internal-note  - Add internal note
POST /admin/disputes/{dispute}/resolve        - Resolve dispute
```

## Email Notifications

### Automated Notifications
1. **DisputeCreatedNotification**
   - Sent to: Seller
   - When: Buyer creates dispute
   - Contains: Dispute details, reason, link to view

2. **DisputeMessageNotification**
   - Sent to: Other party (buyer or seller)
   - When: New message is sent
   - Contains: Message preview, link to dispute

3. **DisputeResolvedNotification**
   - Sent to: Both buyer and seller
   - When: Moderator resolves dispute
   - Contains: Resolution decision, notes, link to view

## File Uploads

### Supported File Types
- Images: JPG, JPEG, PNG
- Documents: PDF
- Maximum size: 5MB per file

### Storage Location
- Evidence files: `storage/disputes/evidence/`
- Message attachments: `storage/disputes/attachments/`

## Security Features

### Access Control
- Buyers can only view/manage their own disputes
- Sellers can only view disputes against them
- Moderators can view all disputes
- Policy-based authorization

### Data Protection
- Files stored securely in storage directory
- CSRF protection on all forms
- Input validation on all fields
- XSS protection via Laravel's Blade escaping

## Customization

### Adding New Dispute Reasons
Edit `resources/views/disputes/create.blade.php` and add options to the reason select field:

```php
<option value="Your New Reason">{{ __('Your New Reason') }}</option>
```

### Customizing Email Templates
Notifications are in `app/Notifications/`:
- `DisputeCreatedNotification.php`
- `DisputeMessageNotification.php`
- `DisputeResolvedNotification.php`

### Styling Modifications
Views use your existing Stellar theme classes:
- Primary color: Purple (`purple-500`, `purple-600`)
- Background: Slate (`slate-800`, `slate-700`)
- Borders: Slate with transparency (`slate-700/50`)

## API Integration (Future Enhancement)

The system is ready for API integration. You can add REST endpoints:

```php
// api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('disputes', DisputeApiController::class);
    Route::post('disputes/{dispute}/messages', [DisputeApiController::class, 'addMessage']);
});
```

## Testing Recommendations

### Manual Testing Checklist
- [ ] Create dispute as buyer
- [ ] Respond as seller
- [ ] Upload evidence files
- [ ] Send messages between parties
- [ ] Mark dispute as in review (admin)
- [ ] Add internal notes (admin)
- [ ] Send public messages (admin)
- [ ] Resolve dispute with refund
- [ ] Resolve dispute upholding seller
- [ ] Check all email notifications
- [ ] Test mobile responsive design
- [ ] Verify file download functionality

### Test Scenarios
1. **Happy Path**: Buyer creates dispute → Seller responds → Moderator resolves fairly
2. **Evidence Heavy**: Multiple file uploads from both parties
3. **Long Conversation**: Extended back-and-forth messaging
4. **Quick Resolution**: Immediate moderator intervention
5. **Seller No Response**: Buyer creates dispute, seller doesn't respond

## Monitoring & Analytics

### Key Metrics to Track
- Total disputes created per month
- Average resolution time
- Percentage resolved in favor of buyer vs seller
- Most common dispute reasons
- Seller dispute rate

### Database Queries for Analytics
```php
// Average resolution time
Dispute::whereNotNull('resolved_at')
    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
    ->first();

// Disputes by status
Dispute::selectRaw('status, COUNT(*) as count')
    ->groupBy('status')
    ->get();

// Top dispute reasons
Dispute::selectRaw('reason, COUNT(*) as count')
    ->groupBy('reason')
    ->orderByDesc('count')
    ->limit(10)
    ->get();
```

## Troubleshooting

### Common Issues

**Issue**: Files not uploading
- **Solution**: Check storage permissions: `chmod -R 775 storage`
- **Solution**: Ensure storage is linked: `php artisan storage:link`

**Issue**: Notifications not sending
- **Solution**: Check queue is running: `php artisan queue:work`
- **Solution**: Verify email configuration in `.env`

**Issue**: 403 Forbidden errors
- **Solution**: Check user has proper roles via `isAdmin()` method
- **Solution**: Verify middleware is applied to routes

**Issue**: Messages not appearing
- **Solution**: Check `is_internal` flag filter
- **Solution**: Verify relationship between Dispute and DisputeMessage

## Future Enhancements

### Suggested Features
1. **Automated Refund Processing**: Integrate with payment gateway to process refunds automatically
2. **Dispute Templates**: Pre-filled templates for common dispute types
3. **AI-Assisted Resolution**: ML model to suggest resolutions based on past disputes
4. **Video Evidence**: Support for video file uploads
5. **Dispute Escalation**: Tiered escalation system for complex disputes
6. **Seller Response Timer**: Automatic notifications if seller doesn't respond within X hours
7. **Dispute Prevention**: Proactive buyer-seller communication before dispute creation
8. **Analytics Dashboard**: Visual charts and graphs for dispute trends
9. **Multi-language Support**: Automatic translation for international disputes
10. **Dispute Mediation**: Optional third-party mediation service

## Support

For issues or questions about the dispute system:
1. Check this guide first
2. Review the code comments in controllers and models
3. Test in a staging environment before production
4. Monitor Laravel logs for errors: `storage/logs/laravel.log`

## Conclusion

The dispute system is fully functional and ready for production use. It provides a fair, transparent, and efficient way to handle conflicts between buyers and sellers while maintaining a positive marketplace experience.

**Key Benefits**:
- ✅ Protects buyers from fraudulent sellers
- ✅ Protects sellers from false claims
- ✅ Reduces support workload with self-service resolution
- ✅ Improves marketplace trust and reputation
- ✅ Provides clear documentation of all disputes
- ✅ Enables data-driven improvements to marketplace policies

Happy disputing! 🎯


