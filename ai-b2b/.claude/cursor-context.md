# AI-B2B Project Context

## Project Overview
This is an AI-powered B2B platform project.

## Technology Stack
- **Framework**: Laravel (PHP)
- **AI Integration**: Claude API (Anthropic)
- **Third-Party Services**:
  - Postmark (Email)
  - AWS SES (Email Service)
  - Resend (Email)
  - Slack (Notifications)

## API Integrations

### Claude AI
- Model: claude-sonnet-4.5-20250929
- Max Tokens: 4096
- Configuration: `config/services.php`

### Email Services
- Postmark: Token-based authentication
- AWS SES: Key/Secret authentication
- Resend: API key authentication

### Notifications
- Slack: Bot OAuth token integration

## Environment Variables Required
```
CLAUDE_API_KEY=
CLAUDE_MODEL=claude-sonnet-4.5-20250929
CLAUDE_MAX_TOKENS=4096

POSTMARK_TOKEN=
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1

RESEND_KEY=

SLACK_BOT_USER_OAUTH_TOKEN=
SLACK_BOT_USER_DEFAULT_CHANNEL=
```

## Development Notes
- This context file helps AI assistants understand the project structure
- Update this file as the project evolves
- Keep sensitive information in .env, never commit credentials

## Project Status
- Initial setup phase
- Git repository initialized
- Service configurations defined
