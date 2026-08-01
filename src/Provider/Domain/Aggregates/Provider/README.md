# Provider Aggregate

This directory contains the Provider Aggregate.

Rules:

- Provider is the Aggregate Root.
- No public setters.
- No public constructor.
- ProviderFactory is the only creation entry point.
- Internal entities never leave this Aggregate.
- Business rules belong to the Aggregate.
