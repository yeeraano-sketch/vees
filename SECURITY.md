# Security Policy

## Reporting a Vulnerability
If you discover a security vulnerability, please **do not** open a public issue.
Email security@vees.dev (or the maintainer directly) with details.

## Supported Versions
| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Security Best Practices
- Never store raw payment data
- All secrets are managed via environment variables
- All events are append-only (immutable audit log)
